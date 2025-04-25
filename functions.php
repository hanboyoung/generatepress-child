<?php
/**
 * GeneratePress 차일드 테마 함수 (정리된 버전)
 */

if (!defined('ABSPATH')) exit; // 직접 접근 방지

/**
 * 자식 테마 스타일 등록 (컴포넌트 기반)
 */
function gpc_enqueue_child_styles() {
    $base_uri = get_stylesheet_directory_uri();
    $base_dir = get_stylesheet_directory();
    // 메인 스타일, 항상 적용
    wp_enqueue_style('gpc-style', $base_uri . '/style.css', array(), filemtime($base_dir . '/style.css'));

    // 공통 컴포넌트 (항상 불러올 것만)
    $css_components = ['header', 'hero', 'card', 'image', 'tab-menu', 'page', 'pagination', 'tag', 'button', 'list'];
    foreach ($css_components as $component) {
        $path = "/assets/css/{$component}.css";
        if (file_exists($base_dir . $path)) {
            wp_enqueue_style("gpc-{$component}-style", $base_uri . $path, ['gpc-style'], filemtime($base_dir . $path));
        }
    }
    // 페이지 전용: page-about.css 
    if (is_page()) {
        $slug = get_post_field('post_name', get_post());
        $path = "/assets/css/page-{$slug}.css";
        if (file_exists($base_dir . $path)) {
            wp_enqueue_style("gpc-page-{$slug}-style", $base_uri . $path, ['gpc-style'], filemtime($base_dir . $path));
        }
    }

    // 카테고리 전용: category-news.css
    if (is_category()) {
        $category = get_queried_object();
        if (isset($category->slug)) {
            $slug = $category->slug;
            $path = "/assets/css/category-{$slug}.css";
            if (file_exists($base_dir . $path)) {
                wp_enqueue_style("gpc-category-{$slug}-style", $base_uri . $path, ['gpc-style'], filemtime($base_dir . $path));
            }
        }
    }

}
add_action('wp_enqueue_scripts', 'gpc_enqueue_child_styles', 99);

/**S
 * 부모 테마 주요 액션/필터 제거 (필요한 경우만 유지)
 */
function gpc_clean_parent_hooks() {
    remove_action('generate_after_entry_header', 'generate_post_image', 10);
    remove_action('generate_before_content', 'generate_featured_page_header', 10);
    remove_action('generate_credits', 'generate_add_footer_info', 10);
}
add_action('init', 'gpc_clean_parent_hooks');

/**
 * 메뉴 출력용 디버깅 제거 (운영용에는 비활성화)
 * - wp_debug_menu_items()
 * - wp_add_menu_debug_script()
 * - debug_menu_setup()
 */

/**
 * 썸네일 이미지 사이즈 정의
 */
function gpc_custom_image_sizes() {
    add_image_size('card-thumb', 600, 400, true);
    add_image_size('story-thumb', 600, 800, true);
    add_image_size('hero-image', 1200, 600, true);
}
add_action('after_setup_theme', 'gpc_custom_image_sizes');

/**
 * 관리자 페이지에서 페이지 템플릿 선택 허용
 */
function gpc_enable_page_templates() {
    add_post_type_support('page', 'page-attributes');
}
add_action('init', 'gpc_enable_page_templates');

/**
 * 관리자바 위치 조정 (프론트에만 적용)
 */
function gpc_adminbar_position_fix() {
    if (!is_admin() && is_admin_bar_showing()) {
        echo '<style>html{margin-top:0!important;}body.admin-bar .site-header{top:32px;}@media(max-width:782px){body.admin-bar .site-header{top:46px;}}</style>';
    }
}
add_action('wp_head', 'gpc_adminbar_position_fix');

/**
 * 카드형 레이아웃 스타일시트 등록
 */
function enqueue_card_styles() {
    wp_enqueue_style('card-style', get_stylesheet_directory_uri() . '/template-parts/css/card.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_card_styles');

/**
 * 이미지 그리드 스타일시트 등록
 */
function enqueue_image_grid_styles() {
    wp_enqueue_style('image-grid-style', get_stylesheet_directory_uri() . '/template-parts/css/image.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_image_grid_styles');

/**
 * 
 */
