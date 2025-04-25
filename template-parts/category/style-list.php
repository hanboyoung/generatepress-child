<?php
/**
 * 리스트형 레이아웃 템플릿
 */

$custom_query = isset($args['custom_query']) ? $args['custom_query'] : $wp_query;
?>

<div class="post-list-container">
    <?php if ($custom_query->have_posts()) : ?>
        <div class="post-list">
            <?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                <article <?php post_class('post-item'); ?>>
                    <a href="<?php the_permalink(); ?>" class="post-link">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="post-content">
                            <div class="post-meta">
                                <?php
                                $categories = get_the_category();
                                if ($categories) {
                                    echo '<span class="post-category">' . esc_html($categories[0]->name) . '</span>';
                                }
                                ?>
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                            </div>
                            <h2 class="post-title"><?php the_title(); ?></h2>
                            <div class="post-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
        <?php
        // 페이지네이션
        the_posts_pagination(array(
            'mid_size' => 2,
            'prev_text' => '이전',
            'next_text' => '다음',
        ));
        ?>
    <?php else : ?>
        <p class="no-posts">게시물이 없습니다.</p>
    <?php endif; wp_reset_postdata(); ?>
</div>

<style>
:root {
    --brand-color: #6B46C1;
    --brand-color-hover: #805AD5;
    --text-primary: #2D3748;
    --text-secondary: #4A5568;
    --background-light: #F7FAFC;
    --container-width: 1200px;
}

.post-list-container {
    max-width: var(--container-width);
    margin: 0 auto;
    padding: 2rem 1rem;
}

.post-list {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.post-item {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.post-link {
    display: flex;
    gap: 2rem;
    text-decoration: none;
    color: inherit;
    padding: 1.5rem;
}

.post-thumbnail {
    flex: 0 0 280px;
    height: 200px;
    border-radius: 8px;
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-item:hover {
    transform: translateY(-4px);
}

.post-item:hover .post-thumbnail img {
    transform: scale(1.05);
}

.post-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.post-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.75rem;
}

.post-category {
    color: var(--brand-color);
    font-weight: 600;
    font-size: 0.9rem;
}

.post-date {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.post-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 1rem;
    line-height: 1.3;
}

.post-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    font-size: 1rem;
}

@media (max-width: 768px) {
    .post-link {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
    }

    .post-thumbnail {
        flex: 0 0 200px;
        width: 100%;
    }

    .post-title {
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
    }

    .post-excerpt {
        font-size: 0.95rem;
    }
}
</style> 