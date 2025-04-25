<?php
/**
 * 생활경제방 카테고리 아카이브 템플릿
 *
 * @package GeneratePress-child
 */

// 카테고리 스타일 로드
wp_enqueue_style('category-style', get_stylesheet_directory_uri() . '/assets/css/category.css', array(), '1.0.0');
wp_enqueue_style('list-style', get_stylesheet_directory_uri() . '/assets/css/list.css', array(), '1.0.0');

get_header(); ?>

<div id="page" class="site apple-newsroom">
    <?php
    // 현재 카테고리 정보 가져오기
    $current_category = get_queried_object();
    
    $is_saving_life_child = false;
    $saving_life_category = get_category_by_slug('saving-life');
    
    if ($saving_life_category) {
        if ($current_category->term_id == $saving_life_category->term_id) {
            $is_saving_life_child = true;
            $main_category = $saving_life_category;
        } else {
            $ancestors = get_ancestors($current_category->term_id, 'category');
            if (in_array($saving_life_category->term_id, $ancestors)) {
                $is_saving_life_child = true;
                $main_category = $saving_life_category;
            }
        }
    }
    ?>
    
    <!-- 카테고리 히어로 섹션 -->
    <section class="category-hero">
        <div class="container">
            <h1 class="category-title"><?php echo esc_html($current_category->name); ?></h1>
            <?php if ($current_category->description) : ?>
                <p class="category-description"><?php echo wp_kses_post($current_category->description); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                <?php
                // 탭 메뉴 표시
                get_template_part('template-parts/navigation/tab-menu', null, array(
                    'current_category' => $current_category->term_id,
                    'parent_category' => $main_category->term_id
                ));

                // 현재 페이지 번호 가져오기
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                
                // WP_Query 인수 설정
                $args = array(
                    'cat' => $current_category->term_id,
                    'posts_per_page' => 5, // 한 페이지에 5개의 포스트
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'paged' => $paged
                );
                
                // 새로운 쿼리 실행
                $custom_query = new WP_Query($args);

                // 리스트형 레이아웃 불러오기
                get_template_part('template-parts/category/style', 'list', array(
                    'category_slug' => 'saving-life',
                    'custom_query' => $custom_query
                ));
                
                // 페이지네이션
                if ($custom_query->max_num_pages > 1) :
                    echo '<div class="pagination">';
                    echo paginate_links(array(
                        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'format' => '?paged=%#%',
                        'current' => max(1, $paged),
                        'total' => $custom_query->max_num_pages,
                        'prev_text' => '이전',
                        'next_text' => '다음',
                        'mid_size' => 2,
                        'end_size' => 1,
                    ));
                    echo '</div>';
                endif;

                // 쿼리 초기화
                wp_reset_postdata();
                ?>
            </div>
        </main>
    </div>
</div>

<style>
.category-meta {
    margin-bottom: 16px;
}

.category-label {
    display: inline-block;
    font-size: 16px;
    font-weight: 600;
    color: #6B46C1;
}

.post-item {
    border: 1px solid #e6e6e6;
    border-radius: 8px;
}

.post-item:after {
    content: "";
    display: block;
    clear: both;
}

.post-list {
    border-top: 1px solid #e6e6e6;
    padding-top: 30px;
}

.post-item + .post-item {
    margin-top: 24px;
}

.pagination {
    border-top: 1px solid #e6e6e6;
    padding-top: 30px;
}
</style>

<?php get_footer(); ?> 