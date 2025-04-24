<?php
/**
 * ==================================================================================
 * ⚠️ 경고: 이 파일은 현재 프로덕션에서 사용 중인 완성된 버전입니다!
 * 🚫 직접 수정하지 마세요!
 * 
 * 최종 수정일: 2024-04-18
 * 버전: 1.0.0
 * 
 * 새로운 페이지 템플릿이 필요한 경우:
 * 1. 이 파일을 복사하여 새로운 이름으로 저장 (예: page-custom.php)
 * 2. 새로운 파일에서 작업을 진행해 주세요
 * ==================================================================================
 */

/**
 * Template Name: 미혼엄마 이야기 페이지
 * 
 * @package GeneratePress-child
 */

get_header(); ?>

<div id="page" class="site">
    <?php
    // 히어로 섹션
    get_template_part('template-parts/hero');
    ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <!-- 메인 콘텐츠 -->
            <div class="main-content-section">
                <div class="container">
                    <?php              
                    // 이미지형 레이아웃 불러오기
                    get_template_part('template-parts/category/style', 'image', array(
                        'category_slug' => 'single-mom-story' // 미혼엄마 이야기 카테고리
                    ));
                    ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php get_footer(); ?> 