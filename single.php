<?php
/**
 * 싱글 포스트 템플릿
 * 
 * 애플 스타일의 단일 포스트 페이지
 * - 히어로 섹션 (특성 이미지)
 * - 포스트 메타 (날짜, 카테고리)
 * - 콘텐츠
 * - 이전/다음 포스트 내비게이션
 */

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container">
        <header class="entry-header">
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            
            <div class="entry-meta">
                <span class="posted-on">
                    <?php echo get_the_date(); ?>
                </span>
                <?php
                $categories = get_the_category();
                if ($categories) :
                    echo '<span class="cat-links">';
                    foreach ($categories as $category) :
                        echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
                    endforeach;
                    echo '</span>';
                endif;
                ?>
            </div>

            <?php if (has_post_thumbnail()) : ?>
                <div class="featured-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
        </header>

        <div class="content-area">
            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <footer class="entry-footer">
                <?php
                $tags = get_the_tags();
                if ($tags) :
                    echo '<div class="tags-links">';
                    foreach ($tags as $tag) :
                        echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">#' . esc_html($tag->name) . '</a>';
                    endforeach;
                    echo '</div>';
                endif;
                ?>

                <nav class="post-navigation">
                    <?php
                    the_post_navigation(array(
                        'prev_text' => '이전 글: %title',
                        'next_text' => '다음 글: %title',
                    ));
                    ?>
                </nav>
            </footer>
        </div>
    </div>
</article>

<?php
get_footer();
?>
