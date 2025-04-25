<?php
/**
 * 카테고리 아카이브 리스트형 레이아웃
 *
 * @package GeneratePress-child
 */

// 포스트 쿼리
$custom_query = $args['custom_query'] ?? null;

if (!$custom_query) {
    return;
}
?>

<div class="post-list-container">
    <div class="post-list">
        <?php if ($custom_query->have_posts()) : ?>
            <?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                <article class="post-item">
                    <a href="<?php the_permalink(); ?>" class="post-link">
                        <div class="post-thumbnail">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php else : ?>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="post-content">
                            <div class="post-meta">
                                <span class="post-category">업데이트</span>
                            </div>
                            <h2 class="post-title"><?php the_title(); ?></h2>
                            <div class="post-date">
                                <?php echo get_the_date('Y년 n월 j일'); ?>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="no-posts">등록된 게시물이 없습니다.</p>
        <?php endif; ?>
    </div>
</div> 