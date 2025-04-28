<?php
/**
 * 카드형 레이아웃 템플릿
 */

// 현재 카테고리 정보
$category = get_queried_object();
$category_slug = $category->slug;

// 카테고리별 커스텀 클래스
$custom_class = "category-{$category_slug}-card";
?>

<div class="cards-container <?php echo esc_attr($custom_class); ?>">
    <div class="cards-grid">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('card'); ?>>
                <a href="<?php the_permalink(); ?>" class="card-link">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="card-image">
                            <?php the_post_thumbnail('card-thumb'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-content">
                        <h2 class="card-title"><?php the_title(); ?></h2>
                        <div class="card-excerpt"><?php the_excerpt(); ?></div>
                        
                        <div class="card-meta">
                            <div class="post-date"><?php echo get_the_date(); ?></div>
                            <?php
                            $tags = get_the_tags();
                            if ($tags) : ?>
                                <div class="tags-container">
                                    <?php foreach ($tags as $tag) : ?>
                                        <span class="category-tag"><?php echo $tag->name; ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            </article>
        <?php endwhile; ?>
    </div>
</div> 