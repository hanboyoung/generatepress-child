<?php
/**
 * The template for displaying archive pages.
 *
 * @package GeneratePress-child
 */

if (!defined('ABSPATH')) {
    exit; // 보안: 직접 접근 방지
}

get_header();

// 커스텀 쿼리를 만들어 초기 페이지 로드시 최신 포스트를 표시
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$is_default_archive = (!is_category() && !is_tag() && !is_author() && !is_date());

// 기본 아카이브 페이지인 경우 최신 포스트 표시
if ($is_default_archive) {
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 6,
        'paged' => $paged,
    );
    $custom_query = new WP_Query($args);
    $main_query_object = $wp_query;
    $wp_query = $custom_query; // 일시적으로 메인 쿼리 대체
}
?>

<main id="main" class="site-main">
    <div class="newsroom-container">
        <div class="newsroom-header">
            <h1 class="newsroom-title">아카이브 전체 보기</h1>
            <div class="newsroom-nav">
                <a href="<?php echo esc_url(home_url('/')); ?>">홈</a>
                <a href="#">최신 스토리</a>
                <div class="newsroom-search">
                    <input type="text" placeholder="검색" aria-label="검색">
                </div>
            </div>
        </div>

        <div class="filter-bar">
            <span class="filter-label">Filter</span>

            <!-- 년도 필터 -->
            <div class="filter-dropdown">
                <select name="year" id="year-filter">
                    <option value="">모든 년도</option>
                    <?php
                    $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY post_date DESC");
                    $current_year = get_query_var('year');

                    foreach($years as $year) {
                        $selected = ($current_year == $year) ? 'selected' : '';
                        echo '<option value="' . esc_attr($year) . '" ' . $selected . '>' . esc_html($year) . '년</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- 월 필터 -->
            <div class="filter-dropdown">
                <select name="month" id="month-filter">
                    <option value="">모든 월</option>
                    <?php
                    $current_month = get_query_var('monthnum');

                    for ($i = 1; $i <= 12; $i++) {
                        $month_string = sprintf("%02d", $i);
                        $selected = ($current_month == $month_string) ? 'selected' : '';
                        echo '<option value="' . esc_attr($month_string) . '" ' . $selected . '>' . esc_html($i) . '월</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- 태그 필터 -->
            <div class="filter-dropdown">
                <select name="topic" id="topic-filter">
                    <option value="">모든 태그</option>
                    <?php
                    $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC'));
                    $current_tag = get_query_var('tag');

                    foreach ($tags as $tag) {
                        $selected = ($current_tag === $tag->slug) ? 'selected' : '';
                        echo '<option value="' . esc_attr($tag->slug) . '" ' . $selected . '>' . esc_html($tag->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <?php
        $queried_object = get_queried_object();

        if (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        } elseif (is_author()) {
            $title = get_the_author();
        } elseif (is_year()) {
            $title = get_the_date('Y') . '년';
        } elseif (is_month()) {
            $title = get_the_date('Y년 n월');
        } elseif (is_day()) {
            $title = get_the_date();
        } else {
            $title = '복지신성';
        }

        echo '<h2 class="archive-date-title">' . $title . '</h2>';

        if (have_posts()) :
            echo '<div class="posts-grid">';

            while (have_posts()) : the_post();
                $categories = get_the_category();
                $category_name = !empty($categories) ? esc_html($categories[0]->name) : '생활 경제';
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                    <div class="post-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('medium');
                            } else {
                                echo '<div class="no-thumbnail"></div>';
                            }
                            ?>
                        </a>
                    </div>

                    <div class="post-content">
                        <div class="post-category"><?php echo $category_name; ?></div>
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="post-date"><?php echo get_the_date('Y년 n월 j일'); ?></div>
                    </div>
                </article>
                <?php
            endwhile;

            echo '</div>';

            echo '<div class="pagination">';
            echo paginate_links(array(
                'prev_text' => '이전',
                'next_text' => '다음',
            ));
            echo '</div>';

        else :
            ?>
            <div class="no-posts">
                <p>포스트가 없습니다.</p>
            </div>
            <?php
        endif;

        if ($is_default_archive) {
            $wp_query = $main_query_object;
            wp_reset_postdata();
        }
        ?>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const yearFilter = document.getElementById('year-filter');
    const monthFilter = document.getElementById('month-filter');
    const topicFilter = document.getElementById('topic-filter');
    const searchInput = document.querySelector('.newsroom-search input');

    const HOME_URL = '<?php echo esc_url(home_url('/')); ?>';

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('s') && searchInput) {
        searchInput.value = urlParams.get('s');
    }

    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                window.location.href = HOME_URL + '?s=' + encodeURIComponent(this.value);
            }
        });
    }

    if (yearFilter) yearFilter.addEventListener('change', applyFilters);
    if (monthFilter) monthFilter.addEventListener('change', applyFilters);
    if (topicFilter) topicFilter.addEventListener('change', applyFilters);

    function applyFilters() {
        const year = yearFilter ? yearFilter.value : '';
        const month = monthFilter ? monthFilter.value : '';
        const tag = topicFilter ? topicFilter.value : '';

        let newUrl = HOME_URL;

        if (tag) {
            newUrl += 'tag/' + encodeURIComponent(tag) + '/';
        }

        if (year) {
            newUrl += year + '/';
            if (month) {
                newUrl += month + '/';
            }
        }

        if (!tag && !year && !month) {
            newUrl += 'archive/';
        }

        window.location.href = newUrl;
    }
});
</script>

<?php
do_action('generate_after_primary_content_area');
generate_construct_sidebars();
get_footer();
