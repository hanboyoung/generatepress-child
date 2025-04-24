<?php
/**
 * 리스트형 레이아웃 템플릿 - 애플 뉴스룸 스타일
 */

// 현재 카테고리 정보
$category = get_queried_object();
$category_slug = $category->slug;

// 필터 옵션 설정
$years = array(
    'all' => '전체',
    '2024' => '2024',
    '2023' => '2023',
    '2022' => '2022'
);

$months = array(
    'all' => '전체',
    '01' => '1월',
    '02' => '2월',
    '03' => '3월',
    '04' => '4월',
    '05' => '5월',
    '06' => '6월',
    '07' => '7월',
    '08' => '8월',
    '09' => '9월',
    '10' => '10월',
    '11' => '11월',
    '12' => '12월'
);

// 현재 선택된 필터 값
$selected_year = isset($_GET['year']) ? $_GET['year'] : 'all';
$selected_month = isset($_GET['month']) ? $_GET['month'] : 'all';
?>

<div class="filter-bar">
    <div class="filter-container">
        <span class="filter-label">필터</span>
        
        <select class="filter-select" name="year" onchange="updateFilters()">
            <?php foreach ($years as $value => $label) : ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($selected_year, $value); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select class="filter-select" name="month" onchange="updateFilters()">
            <?php foreach ($months as $value => $label) : ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($selected_month, $value); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="news-list-container">
    <div class="news-list">
        <?php 
        $current_month = '';
        while (have_posts()) : the_post(); 
            $post_month = get_the_date('F Y');
            
            // 월 구분선 표시
            if ($post_month !== $current_month) {
                echo '<h2 class="month-divider">' . esc_html($post_month) . '</h2>';
                $current_month = $post_month;
            }
        ?>
            <article <?php post_class('news-item'); ?>>
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="news-image">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="news-content">
                        <?php
                        // 포스트 카테고리 가져오기
                        $categories = get_the_category();
                        if ($categories) {
                            echo '<div class="news-category">' . esc_html($categories[0]->name) . '</div>';
                        }
                        ?>
                        <h2 class="news-title"><?php the_title(); ?></h2>
                        <div class="news-date"><?php echo get_the_date(); ?></div>
                    </div>
                </a>
            </article>
        <?php endwhile; ?>
    </div>
</div>

<script>
function updateFilters() {
    const yearSelect = document.querySelector('select[name="year"]');
    const monthSelect = document.querySelector('select[name="month"]');
    
    let url = new URL(window.location.href);
    url.searchParams.set('year', yearSelect.value);
    url.searchParams.set('month', monthSelect.value);
    
    window.location.href = url.toString();
}
</script> 