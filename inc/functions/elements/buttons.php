<?php
/**
 * 버튼 관련 함수들
 *
 * @package GeneratePress-child
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 버튼 스타일 로드
 */
function gpc_enqueue_button_styles() {
    wp_enqueue_style('gpc-button-style', get_stylesheet_directory_uri() . '/assets/css/button.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'gpc_enqueue_button_styles');

/**
 * 기본 버튼 생성 함수
 */
function gpc_create_button($text, $url, $class = '') {
    $classes = 'gpc-button ' . $class;
    return sprintf(
        '<a href="%s" class="%s">%s</a>',
        esc_url($url),
        esc_attr($classes),
        esc_html($text)
    );
}

/**
 * 프라이머리 버튼 생성
 */
function gpc_primary_button($text, $url) {
    return gpc_create_button($text, $url, 'gpc-button-primary');
}

/**
 * 세컨더리 버튼 생성
 */
function gpc_secondary_button($text, $url) {
    return gpc_create_button($text, $url, 'gpc-button-secondary');
}

/**
 * Universe.io 스타일 버튼 생성
 */
function gpc_universe_button($text, $url, $class = '') {
    $classes = 'btn-universe ' . $class;
    return sprintf(
        '<a href="%s" class="%s">%s</a>',
        esc_url($url),
        esc_attr($classes),
        esc_html($text)
    );
}

/**
 * 카테고리 버튼 HTML 생성
 */
function gpc_category_button($text, $url, $is_active = false) {
    $class = 'gpc-category-button' . ($is_active ? ' active' : '');
    return sprintf(
        '<a href="%s" class="%s"><span>%s</span></a>',
        esc_url($url),
        esc_attr($class),
        esc_html($text)
    );
} 