<?php
/**
 * ==================================================================================
 * ⚠️ 경고: 이 파일은 현재 프로덕션에서 사용 중인 완성된 버전입니다!
 * 🚫 직접 수정하지 마세요!
 * 
 * ⚠️ 주의사항:
 * 1. 이 파일은 프로덕션 환경의 핵심 컴포넌트입니다.
 * 2. 수정이 필요한 경우 반드시 관리자에게 문의해주세요.
 * 3. 무단 수정 시 사이트에 심각한 문제가 발생할 수 있습니다.
 * 4. 변경 사항은 반드시 버전 관리를 통해 추적되어야 합니다.
 * 
 * 최종 수정일: 2024-04-18
 * 버전: 1.0.0
 * 담당자: 관리자
 * ==================================================================================
 */

// 직접 접근 방지
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

<<<<<<< HEAD
// 페이지/포스트 vs 카테고리 구분하여 타이틀/설명 설정
if (is_category()) {
    $title = single_cat_title('', false);
    $description = category_description();
} elseif (is_singular()) {
    // Rank Math 설명 가져오기 (자동 생성 포함)
    $description = get_post_meta(get_the_ID(), 'rank_math_description', true);
    // 설명이 없는 경우 기본 발췌문 사용
    if (empty($description)) {
        $description = get_the_excerpt();
    }
    $title = get_the_title();
} else {
    // 기본 fallback
    $title = get_the_title();
    $description = '';
=======
// Rank Math 설명 가져오기 (자동 생성 포함)
$description = get_post_meta(get_the_ID(), 'rank_math_description', true);

// 설명이 없는 경우 기본 발췌문 사용
if (empty($description)) {
    $description = get_the_excerpt();
>>>>>>> c67b8701cb5503dba20b9d48cacd87dac3637a20
}
?>

<div class="hero-wrapper">
<<<<<<< HEAD
    <div class="hero-section<?php echo is_category() ? ' category-hero' : ''; ?>">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo esc_html($title); ?></h1>
=======
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title"><?php the_title(); ?></h1>
>>>>>>> c67b8701cb5503dba20b9d48cacd87dac3637a20
            <?php if (!empty($description)) : ?>
                <div class="hero-description"><?php echo esc_html($description); ?></div>
            <?php endif; ?>
        </div>
    </div>
</div> 