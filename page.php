<?php
/**
 * ⚠️ 경고: 이 파일은 현재 프로덕션에서 사용 중인 완성된 버전입니다!
 * 🚫 직접 수정하지 마세요!
 * 
 * 최종 수정일: 2024-04-18
 * 버전: 1.0.0
 * 
 * 새로운 페이지 템플릿이 필요한 경우:
 * 1. 이 파일을 복사하여 새로운 이름으로 저장 (예: page-custom.php)
 * 2. 새로운 파일에서 작업을 진행해 주세요
 */

/**
 * 정적 페이지 템플릿
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
            <div class="container">
                <?php              
                // 현재 페이지의 슬러그 가져오기
                $page_slug = get_post_field('post_name', get_post());
                
                // 카드형 레이아웃 불러오기
                get_template_part('template-parts/category/style', 'card', array(
                    'category_slug' => $page_slug // 페이지 슬러그를 카테고리 슬러그로 사용
                ));
                ?>
            </div>
        </main>
    </div>
</div>

<?php get_footer(); ?> 