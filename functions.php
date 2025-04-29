<?php
/**
 * GeneratePress 차일드 테마 함수 정리
 */

if (!defined('ABSPATH')) exit; // 직접 접근 방지

/**
 * 스타일 및 스크립트 등록
 */
function gpc_enqueue_child_styles() {
    $base_uri = get_stylesheet_directory_uri();
    $base_dir = get_stylesheet_directory();

    // 메인 스타일 always
    wp_enqueue_style('gpc-style', $base_uri . '/style.css', array('generate-style'), filemtime($base_dir . '/style.css'));

    // 공통 CSS 컴포넌트
    $components = ['header', 'hero', 'card', 'image', 'page', 'pagination', 'tag', 'button', 'list', 'category'];
    foreach ($components as $component) {
        $path = "/assets/css/{$component}.css";
        if (file_exists($base_dir . $path)) {
            wp_enqueue_style("gpc-{$component}-style", $base_uri . $path, ['gpc-style'], filemtime($base_dir . $path));
        }
    }

    // 특정 페이지 전용 스타일
    if (is_page()) {
        $slug = get_post_field('post_name', get_post());
        $path = "/assets/css/page-{$slug}.css";
        if (file_exists($base_dir . $path)) {
            wp_enqueue_style("gpc-page-{$slug}-style", $base_uri . $path, ['gpc-style'], filemtime($base_dir . $path));
        }
    }

    // 특정 카테고리 전용 스타일
    if (is_category()) {
        $category = get_queried_object();
        if (isset($category->slug)) {
            $slug = $category->slug;
            $path = "/assets/css/category-{$slug}.css";
            if (file_exists($base_dir . $path)) {
                wp_enqueue_style("gpc-category-{$slug}-style", $base_uri . $path, ['gpc-style'], filemtime($base_dir . $path));
            }
        }

        // 카테고리 전용 탭 메뉴 스타일
        $tab_menu_path = "/assets/css/tab-menu.css";
        if (file_exists($base_dir . $tab_menu_path)) {
            wp_enqueue_style("gpc-tab-menu", $base_uri . $tab_menu_path, ['gpc-style'], filemtime($base_dir . $tab_menu_path));
        }
    }
}
add_action('wp_enqueue_scripts', 'gpc_enqueue_child_styles', 20);

/**
 * GeneratePress 기본 후크 제거
 */
function gpc_clean_parent_hooks() {
    remove_action('generate_after_entry_header', 'generate_post_image', 10);
    remove_action('generate_before_content', 'generate_featured_page_header', 10);
    remove_action('generate_credits', 'generate_add_footer_info', 10);
}
add_action('init', 'gpc_clean_parent_hooks');

/**
 * 이미지 사이즈 등록
 */
function gpc_custom_image_sizes() {
    add_image_size('card-thumb', 600, 400, true);
    add_image_size('story-thumb', 600, 800, true);
    add_image_size('hero-image', 1200, 600, true);
}
add_action('after_setup_theme', 'gpc_custom_image_sizes');

/**
 * 페이지 템플릿 기능 활성화
 */
function gpc_enable_page_templates() {
    add_post_type_support('page', 'page-attributes');
}
add_action('init', 'gpc_enable_page_templates');

/**
 * 관리자 바 위치 조정 (프론트엔드 전용)
 */
function gpc_adminbar_position_fix() {
    if (!is_admin() && is_admin_bar_showing()) {
        echo '<style>html{margin-top:0!important;}body.admin-bar .site-header{top:32px;}@media(max-width:782px){body.admin-bar .site-header{top:46px;}}</style>';
    }
}
add_action('wp_head', 'gpc_adminbar_position_fix');

/**
 * 카테고리 아카이브에 하위 카테고리 포함
 */
function include_subcategories_in_main_query($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_category()) {
        $term = get_queried_object();
        $tax_query = array(
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $term->term_id,
                'include_children' => true,
            ),
        );
        $query->set('tax_query', $tax_query);
    }
}
add_action('pre_get_posts', 'include_subcategories_in_main_query');

/**
 * 카테고리 사이드바 등록
 */
function gpc_register_category_sidebar() {
    register_sidebar(array(
        'name' => 'Category Archive Sidebar',
        'id' => 'category-sidebar',
        'description' => '카테고리 아카이브용 사이드바',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'gpc_register_category_sidebar');

/**
 * 뉴스 카테고리만 템플릿 변경
 */
function gpc_use_news_template($template) {
    if (!is_category()) return $template;

    $news_cat = get_category_by_slug('news');
    $current_cat = get_queried_object();
    if ($news_cat && ($current_cat->term_id === $news_cat->term_id || in_array($news_cat->term_id, get_ancestors($current_cat->term_id, 'category')))) {
        $new_template = locate_template('category-news.php');
        if ($new_template) return $new_template;
    }
    return $template;
}
add_filter('category_template', 'gpc_use_news_template');

/**
 * 모바일 메뉴 스타일/스크립트 등록
 */
function gpc_enqueue_responsive_menu() {
    wp_enqueue_style('gpc-responsive-menu', get_stylesheet_directory_uri() . '/assets/css/responsive-menu.css', array('generate-style', 'generate-mobile-style'), filemtime(get_stylesheet_directory() . '/assets/css/responsive-menu.css'));
    wp_enqueue_script('gpc-mobile-menu', get_stylesheet_directory_uri() . '/assets/js/mobile-menu.js', array('jquery', 'generate-menu'), filemtime(get_stylesheet_directory() . '/assets/js/mobile-menu.js'), true);
}
add_action('wp_enqueue_scripts', 'gpc_enqueue_responsive_menu', 20);

/**
 * GeneratePress 반응형 기능 복원
 */
function gpc_restore_generatepress_responsive() {
    if (!wp_script_is('generate-menu', 'enqueued')) {
        wp_enqueue_script('generate-menu');
    }
    if (!wp_style_is('generate-mobile-style', 'enqueued')) {
        wp_enqueue_style('generate-mobile-style');
    }
}
add_action('wp_enqueue_scripts', 'gpc_restore_generatepress_responsive', 100);

// Footer 스타일 추가
function gpc_enqueue_footer_styles() {
    wp_enqueue_style('gpc-footer-style', get_stylesheet_directory_uri() . '/assets/css/footer.css', array('gpc-style'), filemtime(get_stylesheet_directory() . '/assets/css/footer.css'));
}
add_action('wp_enqueue_scripts', 'gpc_enqueue_footer_styles', 25);