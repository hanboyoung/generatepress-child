<?php
/**
 * The template for displaying archive pages.
 *
 * @package GeneratePress-child
 */

if (!defined('ABSPATH')) {
    exit;
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
        'posts_per_page' => 10,
        'paged' => $paged,
    );
    $custom_query = new WP_Query($args);
    $main_query_object = $wp_query;
    $wp_query = $custom_query; // 일시적으로 메인 쿼리 대체
}
?>

<style>
    /* 전체 레이아웃 고정 */
    html, body {
        overflow-x: hidden;
    }
    
    body.archive {
        width: 100%;
        margin: 0;
        padding: 0;
    }
    
    /* Newsroom 스타일 */
    .newsroom-container {
        max-width: 1400px;
        width: 100%;
        margin: 0 auto;
        padding: 30px 20px;
        box-sizing: border-box;
        position: relative;
    }
    
    /* 고정 레이아웃 유지 */
    #main.site-main {
        min-height: 600px;
        width: 100%;
        position: relative;
        box-sizing: border-box;
    }
    
    .newsroom-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e5e5e5;
        width: 100%;
        box-sizing: border-box;
        position: relative;
    }
    
    .newsroom-title {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    
    .newsroom-nav {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    
    .newsroom-nav a {
        color: #333;
        text-decoration: none;
        font-size: 14px;
    }
    
    .newsroom-search {
        position: relative;
    }
    
    .newsroom-search input {
        padding: 8px 15px 8px 35px;
        border-radius: 30px;
        border: 1px solid #e5e5e5;
        background-color: #f5f5f7;
        font-size: 14px;
        width: 180px;
        outline: none;
    }
    
    .newsroom-search:before {
        content: '🔍';
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        font-size: 14px;
    }
    
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        background-color: #f5f5f7;
        padding: 15px 20px;
        margin-bottom: 40px;
        border-radius: 8px;
        width: 100%;
        box-sizing: border-box;
        position: relative;
    }
    
    .filter-label {
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-right: 20px;
        display: flex;
        align-items: center;
    }
    
    .filter-dropdown {
        position: relative;
        margin-right: 30px;
        min-width: 120px;
    }
    
    .filter-dropdown select {
        appearance: none;
        background-color: transparent;
        border: none;
        padding: 0 20px 0 0;
        font-size: 14px;
        color: #333;
        cursor: pointer;
        font-weight: 500;
        width: 100%;
    }
    
    .filter-dropdown:after {
        content: '▼';
        font-size: 10px;
        color: #666;
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }
    
    .archive-date-title {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        margin: 40px 0 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e5e5;
        width: 100%;
        box-sizing: border-box;
    }
    
    .posts-grid {
        display: flex;
        flex-direction: column;
        gap: 40px;
        width: 100%;
        min-height: 400px;
        box-sizing: border-box;
        position: relative;
    }
    
    .post-item {
        display: flex;
        gap: 30px;
        padding-bottom: 40px;
        border-bottom: 1px solid #e5e5e5;
        width: 100%;
        box-sizing: border-box;
    }
    
    .post-item:last-child {
        border-bottom: none;
    }
    
    .post-thumbnail {
        flex: 0 0 300px;
        height: 200px;
        border-radius: 8px;
        overflow: hidden;
        background-color: #f5f5f7;
    }
    
    .post-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .post-thumbnail img:hover {
        transform: scale(1.05);
    }
    
    .post-content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .post-category {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        color: #666;
        margin-bottom: 10px;
    }
    
    .post-title {
        font-size: 22px;
        font-weight: 600;
        color: #333;
        margin: 0 0 15px;
        line-height: 1.3;
    }
    
    .post-title a {
        color: #333;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .post-title a:hover {
        color: #0066cc;
    }
    
    .post-date {
        color: #666;
        font-size: 14px;
        margin-top: auto;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 50px;
        padding-top: 20px;
    }
    
    .pagination .page-numbers {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        margin: 0 5px;
        border-radius: 50%;
        background-color: transparent;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .pagination .page-numbers.current {
        background-color: #0066cc;
        color: white;
    }
    
    .pagination .page-numbers:hover:not(.current) {
        background-color: #f5f5f7;
    }
    
    .pagination .prev,
    .pagination .next {
        width: auto;
        padding: 0 15px;
        border-radius: 18px;
    }
    
    .no-thumbnail {
        width: 100%;
        height: 100%;
        background-color: #f5f5f7;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .no-posts {
        text-align: center;
        padding: 100px 0;
        color: #666;
        font-size: 16px;
        width: 100%;
        min-height: 400px;
        background-color: #f9f9f9;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin: 40px 0;
        box-sizing: border-box;
    }
    
    @media (max-width: 768px) {
        .post-item {
            flex-direction: column;
            gap: 20px;
        }
        
        .post-thumbnail {
            flex: 0 0 auto;
            height: 200px;
            width: 100%;
        }
        
        .newsroom-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .newsroom-nav {
            width: 100%;
            justify-content: space-between;
        }
        
        .filter-bar {
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .filter-label {
            width: 100%;
            margin-right: 0;
        }
        
        .filter-dropdown {
            margin-right: 15px;
        }
    }
</style>

<main id="main" class="site-main">
    <div class="newsroom-container">
        <div class="newsroom-header">
            <h1 class="newsroom-title">복지신성</h1>
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
            
            <!-- 년도 필터 복원 -->
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
            
            <!-- 월 필터 복원 -->
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
        
        // 현재 아카이브의 타입 확인 및 타이틀 설정
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
        
        // 타이틀 표시
        echo '<h2 class="archive-date-title">' . $title . '</h2>';
        
        if (have_posts()) :
            echo '<div class="posts-grid">';
            
            while (have_posts()) : the_post();
                // 포스트 카테고리 가져오기
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
            
            // 페이지네이션
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
        
        // 기본 아카이브 페이지인 경우 원래 메인 쿼리로 복원
        if ($is_default_archive) {
            $wp_query = $main_query_object;
            wp_reset_postdata();
        }
        ?>
    </div>
</main>

<script>
    // 필터 드롭다운 이벤트 처리
    document.addEventListener('DOMContentLoaded', function() {
        // 필터 선택 시 포스트 스타일 일관성 유지
        const postItems = document.querySelectorAll('.post-item');
        postItems.forEach(item => {
            const thumbnail = item.querySelector('.post-thumbnail');
            if (!thumbnail.querySelector('img') && !thumbnail.querySelector('.no-thumbnail')) {
                thumbnail.innerHTML = '<div class="no-thumbnail"></div>';
            }
        });
        
        // 필터 요소
        const yearFilter = document.getElementById('year-filter');
        const monthFilter = document.getElementById('month-filter');
        const topicFilter = document.getElementById('topic-filter');
        const searchInput = document.querySelector('.newsroom-search input');
        
        // 현재 URL에서 검색어 가져오기
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('s')) {
            searchInput.value = urlParams.get('s');
        }
        
        // 검색 처리
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                window.location.href = '<?php echo esc_url(home_url('/')); ?>?s=' + this.value;
            }
        });
        
        // 년도 필터 변경 처리
        yearFilter.addEventListener('change', function() {
            handleFilterChange();
        });
        
        // 월 필터 변경 처리
        monthFilter.addEventListener('change', function() {
            handleFilterChange();
        });
        
        // 태그 필터 변경 처리
        topicFilter.addEventListener('change', function() {
            handleFilterChange();
        });
        
        // 필터 변경 처리 함수
        function handleFilterChange() {
            const selectedYear = yearFilter.value;
            const selectedMonth = monthFilter.value;
            const selectedTag = topicFilter.value;
            let url = '<?php echo esc_url(home_url('/')); ?>';
            
            // 태그가 선택된 경우
            if (selectedTag) {
                url += 'tag/' + selectedTag + '/';
                
                // 년도가 선택된 경우
                if (selectedYear) {
                    if (url.endsWith('/')) {
                        url = url.slice(0, -1);
                    }
                    url += '?year=' + selectedYear;
                    
                    // 월도 선택된 경우
                    if (selectedMonth) {
                        url += '&monthnum=' + selectedMonth;
                    }
                }
            } 
            // 태그는 없지만 년도가 선택된 경우
            else if (selectedYear) {
                url += selectedYear + '/';
                
                // 월도 선택된 경우
                if (selectedMonth) {
                    url += selectedMonth + '/';
                }
            }
            // 아무것도 선택되지 않은 경우 기본 아카이브로 이동
            else if (!selectedYear && !selectedMonth && !selectedTag) {
                url = '<?php echo esc_url(home_url('/')); ?>아카이브/';
            }
            
            window.location.href = url;
        }
    });
</script>

<?php
/**
 * generate_after_primary_content_area hook.
 *
 * @since 2.0
 */
do_action('generate_after_primary_content_area');

generate_construct_sidebars();

get_footer(); 