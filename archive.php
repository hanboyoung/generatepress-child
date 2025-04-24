<?php
/**
 * The template for displaying archive pages.
 *
 * @package GeneratePress-child
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="main" class="site-main">
    <?php
    $queried_object = $wp_query->get_queried_object();
    $archive_type = '';

    if (is_category()) {
        $archive_type = 'category';
    } elseif (is_tag()) {
        $archive_type = 'tag';
    } elseif (is_author()) {
        $archive_type = 'author';
    } elseif (is_date()) {
        $archive_type = 'date';
    } elseif (is_post_type_archive()) {
        $archive_type = 'post_type';
    }

    // 카테고리 아카이브인 경우에만 카드형 레이아웃 사용
    if ($archive_type === 'category') {
        ?>
        <div class="archive-container">
            <div class="archive-header">
                <h1 class="archive-title"><?php echo single_cat_title('', false); ?></h1>
                <?php if (category_description()) : ?>
                    <div class="archive-description"><?php echo category_description(); ?></div>
                <?php endif; ?>
            </div>

            <div class="archive-content">
                <?php
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="post-content">
                                <header class="entry-header">
                                    <h2 class="entry-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <div class="entry-meta">
                                        <span class="posted-on"><?php echo get_the_date(); ?></span>
                                        <span class="byline"><?php the_author(); ?></span>
                                    </div>
                                </header>

                                <div class="entry-summary">
                                    <?php the_excerpt(); ?>
                                </div>

                                <footer class="entry-footer">
                                    <a href="<?php the_permalink(); ?>" class="read-more">자세히 보기</a>
                                </footer>
                            </div>
                        </article>
                        <?php
                    endwhile;

                    the_posts_pagination(array(
                        'prev_text' => '이전',
                        'next_text' => '다음',
                    ));
                else :
                    ?>
                    <p class="no-posts">포스트가 없습니다.</p>
                    <?php
                endif;
                ?>
            </div>
        </div>
        <?php
    } else {
        // 다른 아카이브 타입의 경우 기본 레이아웃 사용
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', get_post_type());
            endwhile;

            the_posts_pagination(array(
                'prev_text' => '이전',
                'next_text' => '다음',
            ));
        else :
            get_template_part('template-parts/content', 'none');
        endif;
    }
    ?>
</main>

<?php
/**
 * generate_after_primary_content_area hook.
 *
 * @since 2.0
 */
do_action('generate_after_primary_content_area');

generate_construct_sidebars();

get_footer(); 