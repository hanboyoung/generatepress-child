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
    
    <!-- 히어로 섹션 -->
    <section class="hero-section category-hero">
        <div class="hero-content">
            <h1 class="hero-title animate-on-scroll"><?php echo esc_html($current_category->name); ?></h1>
            <?php if ($current_category->description) : ?>
                <p class="hero-description animate-on-scroll"><?php echo wp_kses_post($current_category->description); ?></p>
            <?php endif; ?>
        </div>
    </section>

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
                        
                        // WP_Query 인수 설정
                        $args = array(
                            'cat' => $current_category->term_id,
                            'posts_per_page' => -1,
                            'orderby' => 'date',
                            'order' => 'DESC'
                        );
                        
                        // 새로운 쿼리 실행
                        $custom_query = new WP_Query($args);
                        
                        // 리스트형 레이아웃 불러오기
                        get_template_part('template-parts/category/style', 'list', array(
                            'category_slug' => 'saving-life',
                            'custom_query' => $custom_query
                        ));
                        
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
                        
                        // 표시 스타일 가져오기 (기본값: list)
                        $display_style = get_term_meta($current_category->term_id, 'archive_style', true);
                        $display_style = $display_style ? $display_style : 'list';
                        
                        // 해당 스타일의 템플릿 로드
                        get_template_part('template-parts/category/style', $display_style);
                        
                        // 페이지네이션
                        get_template_part('template-parts/pagination');
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