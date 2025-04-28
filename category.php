<?php
/**
 * 카테고리 아카이브 템플릿
 *
 * @package GeneratePress-child
 */

// 카테고리 스타일 로드
wp_enqueue_style('category-style', get_stylesheet_directory_uri() . '/assets/css/category.css', array(), '1.0.0');

get_header(); ?>

<div id="page" class="site">
    <?php
    // 현재 카테고리 정보
    $current_category = get_queried_object();
    
    // 현재 카테고리의 조상 카테고리 확인 (saving-life의 하위 카테고리인지 체크)
    $is_saving_life_child = false;
    $saving_life_category = get_category_by_slug('news');
    
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

    // 공통 히어로 템플릿 호출
    get_template_part('template-parts/hero');
    ?>
    
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                <?php if (have_posts()) : ?>
                    <?php
                    // saving-life 관련 카테고리인 경우 해당 탭 메뉴 표시
                    if ($is_saving_life_child) {
                        get_template_part('template-parts/navigation/tab-menu', null, array(
                            'current_category' => $current_category->term_id,
                            'parent_category' => $main_category->term_id
                        ));
                        
                        // WP_Query 인수 설정 (현재 카테고리 및 하위 카테고리 포함)
                        $args = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'category',
                                    'field'    => 'term_id',
                                    'terms'    => $current_category->term_id,
                                    'include_children' => true,
                                ),
                            ),
                            'posts_per_page' => 5, // 한 페이지에 5개의 포스트
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'paged' => get_query_var('paged') ? get_query_var('paged') : 1
                        );
                        
                        // 새로운 쿼리 실행
                        $custom_query = new WP_Query($args);
                        
                        // 리스트형 레이아웃 불러오기
                        get_template_part('template-parts/category/style', 'list', array(
                            'category_slug' => 'news',
                            'custom_query' => $custom_query
                        ));
                        
                        // 페이지네이션
                        echo '<div class="apple-pagination">';
                        echo paginate_links(array(
                            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                            'format' => '?paged=%#%',
                            'current' => max(1, get_query_var('paged')),
                            'total' => $custom_query->max_num_pages,
                            'prev_text' => '<span class="prev-icon">←</span> 이전',
                            'next_text' => '다음 <span class="next-icon">→</span>',
                            'mid_size' => 2,
                            'end_size' => 1,
                        ));
                        echo '</div>';
                        
                        // 쿼리 초기화
                        wp_reset_postdata();
                    } else {
                        // 일반 카테고리인 경우 기본 탭 메뉴 표시
                        if ($current_category->parent == 0) {
                            get_template_part('template-parts/navigation/tab-menu', null, array(
                                'current_category' => $current_category->term_id,
                                'parent_category' => $current_category->term_id
                            ));
                        }
                        
                        // 현재 페이지 번호 가져오기
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        
                        // 표시 스타일 가져오기 (기본값: list)
                        $display_style = get_term_meta($current_category->term_id, 'archive_style', true);
                        $display_style = $display_style ? $display_style : 'list';
                        
                        // 해당 스타일의 템플릿 로드
                        get_template_part('template-parts/category/style', $display_style);
                        
                        // 페이지네이션
                        echo '<div class="apple-pagination">';
                        the_posts_pagination(array(
                            'prev_text' => '<span class="prev-icon">←</span> 이전',
                            'next_text' => '다음 <span class="next-icon">→</span>',
                            'mid_size' => 2,
                            'end_size' => 1,
                            'screen_reader_text' => ' ',
                        ));
                        echo '</div>';
                    }
                    ?>
                <?php else : ?>
                    <div class="no-results">
                        <h2>게시물이 없습니다</h2>
                        <p>아직 이 카테고리에 게시물이 없습니다.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<?php get_footer(); ?> 