<?php
/**
 * 공통 카테고리 아카이브 템플릿 (브레드크럼 + 히어로 수정, 애플 스타일)
 *
 * @package GeneratePress-child
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div id="page" class="site">

    <section class="category-hero">
        <div class="category-hero-inner">

            <!-- 커스텀 브레드크럼 -->
            <nav class="breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">홈</a> ›
                <a href="<?php echo esc_url(home_url('/workspace/')); ?>">작업실</a> ›
                <span><?php single_cat_title(); ?></span>
            </nav>

            <h1 class="category-title"><?php single_cat_title(); ?></h1>

            <?php if (category_description()) : ?>
                <p class="category-description"><?php echo category_description(); ?></p>
            <?php endif; ?>

        </div>
    </section>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">

                <?php if (have_posts()) : ?>
                    <section class="category-posts">
                        <div class="post-grid">
                            <?php while (have_posts()) : the_post(); ?>
                                <article class="post-card">
                                    <a href="<?php the_permalink(); ?>" class="post-link">
                                    <div class="thumbnail">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <img src="<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>" alt="<?php the_title_attribute(); ?>">
                                        <?php else : ?>
                                            <div class="no-thumbnail"></div>
                                        <?php endif; ?>
                                    </div>
                                        <div class="content">
                                            <h2 class="title"><?php the_title(); ?></h2>
                                            <time class="date"><?php echo get_the_date(); ?></time>
                                        </div>
                                    </a>
                                </article>
                            <?php endwhile; ?>
                        </div>
                    </section>

                    <div class="apple-pagination">
                        <?php
                        the_posts_pagination(array(
                            'prev_text' => '<span class="prev-icon">\u2190</span> 이전',
                            'next_text' => '다음 <span class="next-icon">\u2192</span>',
                            'mid_size' => 2,
                            'end_size' => 1,
                            'screen_reader_text' => ' ',
                        ));
                        ?>
                    </div>

                <?php else : ?>
                    <div class="no-results">
                        <h2>게시물이 없습니다</h2>
                        <p>아직 이 카테고리에 게시물이 없습니다.</p>
                    </div>
                <?php endif; ?>

            </div>
        </main>
    </div>

</div>


<?php get_footer(); ?>