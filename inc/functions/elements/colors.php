<?php
/**
 * 카테고리 및 태그 컬러 관련 함수들
 *
 * @package GeneratePress-child
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 카테고리별 컬러 정의
 */
function gpc_get_category_color($category_id) {
    $colors = array(
        '1' => '#ff6b6b', // 빨강
        '2' => '#4ecdc4', // 청록
        '3' => '#95a5a6', // 회색
        // 필요한 만큼 추가
    );
    
    return isset($colors[$category_id]) ? $colors[$category_id] : '#333333';
}

/**
 * 태그 배경색 가져오기
 */
function gpc_get_tag_background($tag_id) {
    $backgrounds = array(
        '1' => '#f8f9fa',
        '2' => '#e9ecef',
        '3' => '#dee2e6',
        // 필요한 만큼 추가
    );
    
    return isset($backgrounds[$tag_id]) ? $backgrounds[$tag_id] : '#f8f9fa';
}

/**
 * 카테고리 레이블 HTML 생성
 */
function gpc_category_label($category_id, $category_name) {
    $color = gpc_get_category_color($category_id);
    return sprintf(
        '<span class="gpc-category-label" style="background-color: %s">%s</span>',
        esc_attr($color),
        esc_html($category_name)
    );
} 