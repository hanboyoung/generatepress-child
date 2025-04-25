<?php
/**
 * 카테고리 아카이브 리스트형 레이아웃 - 애플 스타일
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
                                <?php
                                // 모든 태그 표시
                                $tags = get_the_tags();
                                if (!empty($tags)) {
                                    echo '<div class="post-tags">';
                                    $tag_count = count($tags);
                                    $max_display = 3; // 최대 표시할 태그 수
                                    
                                    for ($i = 0; $i < min($tag_count, $max_display); $i++) {
                                        echo '<span class="post-tag">' . esc_html($tags[$i]->name) . '</span>';
                                    }
                                    
                                    // 추가 태그가 있는 경우 +N 형식으로 표시
                                    if ($tag_count > $max_display) {
                                        $remaining = $tag_count - $max_display;
                                        echo '<span class="post-tag-more">+' . $remaining . '</span>';
                                    }
                                    
                                    echo '</div>';
                                } else {
                                    // 태그가 없는 경우 카테고리를 표시
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo '<div class="post-tags">';
                                        echo '<span class="post-tag">' . esc_html($categories[0]->name) . '</span>';
                                        echo '</div>';
                                    }
                                }
                                ?>
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