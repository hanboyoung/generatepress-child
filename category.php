<?php
/**
 * 카테고리 아카이브 템플릿
 *
 * @package GeneratePress-child
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <?php if (have_posts()) : ?>
                <?php get_template_part('template-parts/archive-header'); ?>
                
                <?php
                // 표시 스타일 가져오기 (기본값: card)
                $display_style = get_term_meta(get_queried_object_id(), 'archive_style', true);
                $display_style = $display_style ? $display_style : 'card';
                
                // 해당 스타일의 템플릿 로드
                get_template_part('template-parts/archive/content', $display_style);
                
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