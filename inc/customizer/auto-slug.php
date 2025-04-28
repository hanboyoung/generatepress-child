<?php
/**
 * 새로 등록되는 페이지/카테고리/태그 슬러그 최적화 자동 생성
 * (SEO 친화형 변환 포함)
 */

// 보안을 위해 직접 접근 차단
if (!defined('ABSPATH')) exit;


// 한글을 영어로 변환하는 최적화 함수
function slugify($text) {
    $map = array(
        '워드프레스' => 'wordpress',
        '오류' => 'error',
        '해결' => 'solution',
        '경제' => 'economy',
        '뉴스' => 'news',
        '영상' => 'video',
        '편집' => 'editing',
        '디자인' => 'design',
        '투자' => 'investment',
        '부동산' => 'real-estate',
        '재테크' => 'finance',
        '자동화' => 'automation',
        '무료' => 'free',
        '공유' => 'sharing',
        '문제' => 'problem',
        '서비스' => 'services',
        '복지' => 'welfare',
        '정책' => 'policy',
    );

    // 매칭 먼저 변환
    $text = strtr($text, $map);

    // 나머지는 워드프레스 기본 sanitize로 처리
    $text = sanitize_title($text);

    return $text;
}

// 1. 페이지 저장할 때 슬러그 자동 생성
add_action('save_post_page', function($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    $post = get_post($post_id);
    if ($post && empty($post->post_name)) {
        $new_slug = slugify($post->post_title);
        wp_update_post([
            'ID' => $post_id,
            'post_name' => $new_slug,
        ]);
    }
});

// 2. 카테고리/태그 생성할 때 슬러그 자동 생성
add_filter('pre_insert_term', function($term, $taxonomy) {
    if (in_array($taxonomy, ['category', 'post_tag'])) {
        $term = slugify($term);
    }
    return $term;
}, 10, 2);
