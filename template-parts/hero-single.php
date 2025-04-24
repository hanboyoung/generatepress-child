<?php
/**
 * 싱글 포스트 히어로 섹션 템플릿
 * 애플 스타일 디자인
 */
?>

<header class="entry-header">
    <div class="entry-header-content">
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
    </div>

    <?php if (has_post_thumbnail()) : ?>
        <div class="featured-image">
            <?php the_post_thumbnail('large'); ?>
        </div>
    <?php endif; ?>
</header> 