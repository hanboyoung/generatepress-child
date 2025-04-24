<?php
/**
 * 테마 커스터마이저 설정
 *
 * @package GeneratePress-child
 */

if (!defined('ABSPATH')) {
    exit;
}

function gpc_customize_register($wp_customize) {
    // 새로운 섹션 추가
    $wp_customize->add_section('gpc_theme_options', array(
        'title'    => '테마 옵션',
        'priority' => 130,
    ));

    // 헤더 배경색 설정
    $wp_customize->add_setting('gpc_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gpc_header_bg_color', array(
        'label'    => '헤더 배경색',
        'section'  => 'gpc_theme_options',
        'settings' => 'gpc_header_bg_color',
    )));

    // 푸터 텍스트 설정
    $wp_customize->add_setting('gpc_footer_text', array(
        'default'           => '© 2024 당신의 사이트. All rights reserved.',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('gpc_footer_text', array(
        'label'    => '푸터 텍스트',
        'section'  => 'gpc_theme_options',
        'settings' => 'gpc_footer_text',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'gpc_customize_register');

// 실시간 미리보기를 위한 JavaScript
function gpc_customize_preview_js() {
    wp_enqueue_script('gpc-customizer', get_stylesheet_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), '1.0', true);
}
add_action('customize_preview_init', 'gpc_customize_preview_js');

// 커스터마이저 설정값 가져오기 헬퍼 함수
function gpc_get_theme_option($option_name, $default = '') {
    return get_theme_mod($option_name, $default);
} 