<?php
/**
 * Template Name: 블로그 카테고리 템플릿
 * Description: 블로그 카테고리용 커스텀 템플릿
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <?php if (have_posts()) : ?>
                <?php
                // 스타일 설정 (카드형/리스트형/이미지형)
                $style = get_term_meta(get_queried_object_id(), 'display_style', true) ?: 'card';
                
                // 해당 카테고리용 스타일 템플릿 로드
                get_template_part('template-parts/category/style', $style);
                
                // 페이지네이션
                get_template_part('template-parts/pagination');
                ?>
            <?php else : ?>
                <div class="no-results">
                    <h2>게시물이 없습니다</h2>
                    <p>아직 이 카테고리에 게시물이 없습니다.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php get_footer(); ?> 