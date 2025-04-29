<?php
/**
 * 뉴스 카테고리 아카이브 템플릿
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
    ?>
    
    <!-- 공통 히어로 템플릿 호출 -->
    <?php get_template_part('template-parts/hero'); ?>

     <!-- 애플 스타일 히어로 섹션
    <section class="apple-hero">
        <div class="apple-hero-container">
            <h1 class="apple-hero-title"><?php echo esc_html($current_category->name); ?></h1>
            <?php if ($current_category->description) : ?>
                <p class="apple-hero-description"><?php echo wp_kses_post($current_category->description); ?></p>
            <?php endif; ?>
        </div>
    </section> -->

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                <div class="layout-category">
                    <div class="category-main">
                        <?php
                        // 탭 메뉴 표시
                        get_template_part('template-parts/navigation/tab-menu', null, array(
                            'current_category' => $current_category->term_id,
                            'parent_category' => $main_category->term_id
                        ));

                        // 현재 페이지 번호 가져오기
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        
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
                            'posts_per_page' => 5, // 한 페이지에 5개의 포스트로 통일
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'paged' => $paged
                        );
                        
                        // 새로운 쿼리 실행
                        $custom_query = new WP_Query($args);

                        // 리스트형 레이아웃 불러오기
                        get_template_part('template-parts/category/style', 'list', array(
                            'category_slug' => 'news',
                            'custom_query' => $custom_query
                        ));

                        

                        
                        // 쿼리 초기화
                        wp_reset_postdata();
                        ?>
                    </div><!-- .category-main -->

                    <!-- 사이드바 -->
                    <aside class="category-sidebar widget-area">
                        <?php if ( is_active_sidebar( 'category-sidebar' ) ) : ?>
                            <?php dynamic_sidebar( 'category-sidebar' ); ?>
                        <?php else : ?>
                            <section class="widget widget_search">
                                <?php get_search_form(); ?>
                            </section>
                            <section class="widget widget_categories">
                                <h2 class="widget-title">카테고리</h2>
                                <ul>
                                    <?php wp_list_categories( array('title_li' => '', 'depth' => 1) ); ?>
                                </ul>
                            </section>
                            <!-- <section class="widget widget_recent_entries">
                                <h2 class="widget-title">최근 글</h2>
                                <?php the_widget('WP_Widget_Recent_Posts', array('number' => 5)); ?>
                            </section>
                            <section class="widget widget_tag_cloud">
                                <h2 class="widget-title">태그 클라우드</h2>
                                <?php the_widget('WP_Widget_Tag_Cloud', array('smallest' => 12, 'largest' => 18)); ?>
                            </section> -->
                            <section class="widget widget_popular_posts">
                                <h2 class="widget-title">인기 글</h2>
                                <?php
                                $popular = get_popular_posts_by_likes(5);
                                if ($popular->have_posts()) :
                                    echo '<ul>';
                                    while ($popular->have_posts()) : $popular->the_post();
                                        echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
                                    endwhile;
                                    echo '</ul>';
                                    wp_reset_postdata();
                                endif;
                                ?>
                            </section>
                        <?php endif; ?>
                    </aside><!-- .category-sidebar -->
                </div><!-- .layout-category -->
            </div><!-- .container -->
        </main>
    </div>
</div>

<?php get_footer(); ?> 