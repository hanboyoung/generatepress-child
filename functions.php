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
    
    // 메인 스타일, 항상 적용 (부모 테마 스타일 의존성 추가)
    wp_enqueue_style('gpc-style', $base_uri . '/style.css', array('generate-style'), filemtime($base_dir . '/style.css'));

    // 공통 컴포넌트 (항상 불러올 것만)
    $css_components = ['header', 'hero', 'card', 'image', 'page', 'pagination', 'tag', 'button', 'list'];
    foreach ($css_components as $component) {
        $path = "/assets/css/{$component}.css";
        if (file_exists($base_dir . $path)) {
            wp_enqueue_style("gpc-{$component}-style", $base_uri . $path, ['gpc-style'], filemtime($base_dir . $path));
        }
    }
    
    // 카테고리 페이지에서만 탭 메뉴 스타일 로드
    if (is_category()) {
        $tab_menu_path = "/assets/css/tab-menu.css";
        if (file_exists($base_dir . $tab_menu_path)) {
            wp_enqueue_style("gpc-tab-menu-style", $base_uri . $tab_menu_path, ['gpc-style'], filemtime($base_dir . $tab_menu_path));
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
add_action('wp_enqueue_scripts', 'gpc_enqueue_child_styles', 20);

/**
 * 부모 테마 주요 액션/필터 제거 (필요한 경우만 유지)
 */
function gpc_clean_parent_hooks() {
    // 이미지 관련 훅만 제거 (반응형 관련 훅은 유지)
    remove_action('generate_after_entry_header', 'generate_post_image', 10);
    remove_action('generate_before_content', 'generate_featured_page_header', 10);
    
    // 푸터 크레딧 제거
    remove_action('generate_credits', 'generate_add_footer_info', 10);
    
    // 중요: 반응형 관련 액션/필터는 제거하지 않음
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
 * 이미지 그리드 스타일시트 등록
 */
function enqueue_image_grid_styles() {
    wp_enqueue_style('image-grid-style', get_stylesheet_directory_uri() . '/template-parts/css/image.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_image_grid_styles');

/**
 * 반응형 메뉴 스타일 및 스크립트 등록
 */
function gpc_enqueue_responsive_menu() {
    // Register styles with dependency on GeneratePress styles
    wp_enqueue_style(
        'gpc-responsive-menu',
        get_stylesheet_directory_uri() . '/assets/css/responsive-menu.css',
        array('generate-style', 'generate-mobile-style'),
        filemtime( get_stylesheet_directory() . '/assets/css/responsive-menu.css' )
    );

    // Register scripts with dependency on GeneratePress navigation
    wp_enqueue_script(
        'gpc-mobile-menu',
        get_stylesheet_directory_uri() . '/assets/js/mobile-menu.js',
        array('jquery', 'generate-menu'),
        filemtime( get_stylesheet_directory() . '/assets/js/mobile-menu.js' ),
        true
    );
}
add_action( 'wp_enqueue_scripts', 'gpc_enqueue_responsive_menu', 20 );

/**
 * GeneratePress 기본 반응형 기능 활성화
 * 부모 테마의 반응형 기능과 동작을 복원합니다.
 */
function gpc_restore_generatepress_responsive() {
    // GeneratePress 모바일 네비게이션 스크립트 로드
    if (!wp_script_is('generate-menu', 'enqueued')) {
        wp_enqueue_script('generate-menu');
    }
    
    // GeneratePress 모바일 반응형 스타일 로드
    if (!wp_style_is('generate-mobile-style', 'enqueued')) {
        wp_enqueue_style('generate-mobile-style');
    }
    
    // 부모 테마의 일부 제거된 기능을 복원
    add_action('wp_footer', function() {
        if (function_exists('generate_back_to_top')) {
            generate_back_to_top();
        }
    });
    
    // GeneratePress 메뉴 관련 클래스 추가
    add_filter('body_class', function($classes) {
        $classes[] = 'nav-aligned-center';
        $classes[] = 'nav-dropdown-mobile';
        return $classes;
    });
}
add_action('wp_enqueue_scripts', 'gpc_restore_generatepress_responsive', 100);

/**
 * 좋아요 기능 AJAX 처리
 */
function post_like_callback() {
    // 보안 검증
    check_ajax_referer('like_post_nonce', 'nonce');
    
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    
    if ($post_id <= 0) {
        wp_send_json_error();
        return;
    }
    
    // 현재 좋아요 수 가져오기
    $likes = get_post_meta($post_id, 'post_likes', true);
    if (!$likes) $likes = 0;
    
    // 사용자가 이미 좋아요 했는지 확인
    $already_liked = isset($_COOKIE['post_liked_' . $post_id]);
    
    if ($already_liked) {
        // 좋아요 취소
        $likes--;
        $liked = false;
    } else {
        // 좋아요 추가
        $likes++;
        $liked = true;
    }
    
    // 좋아요 수가 음수가 되지 않도록
    if ($likes < 0) $likes = 0;
    
    // 좋아요 수 업데이트
    update_post_meta($post_id, 'post_likes', $likes);
    
    // 결과 반환
    wp_send_json_success(array(
        'likes' => $likes,
        'liked' => $liked
    ));
}
add_action('wp_ajax_post_like', 'post_like_callback');
add_action('wp_ajax_nopriv_post_like', 'post_like_callback');

/**
 * 인기 포스트 가져오기 (좋아요 수 기준)
 */
function get_popular_posts_by_likes($count = 5) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $count,
        'meta_key' => 'post_likes',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => 'post_likes',
                'value' => '0',
                'compare' => '>'
            )
        )
    );
    
    return new WP_Query($args);
}
