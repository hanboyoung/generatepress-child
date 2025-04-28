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

<style>
/* 포스트 리스트 기본 스타일 */
.post-list-container {
    margin-bottom: 40px;
}

.post-list {
    display: flex;
    flex-direction: column;
}

/* 포스트 아이템 스타일 */
.post-item {
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #e6e6e6;
}

.post-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

/* 포스트 링크 스타일 */
.post-link {
    display: flex;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
}

/* 포스트 썸네일 스타일 */
.post-thumbnail {
    flex: 0 0 180px;
    height: 120px;
    margin-right: 24px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-link:hover .post-thumbnail img {
    transform: scale(1.05);
}

/* 포스트 컨텐츠 스타일 */
.post-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* 포스트 메타 스타일 */
.post-meta {
    margin-bottom: 12px;
}

/* 포스트 태그 스타일 */
.post-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}

.post-tag {
    display: inline-block;
    padding: 5px 12px;
    background-color: var(--purple-ultra-light, #F6F2FF);
    color: var(--purple-base, #6E45E2);
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.post-tag-more {
    display: inline-block;
    padding: 5px 12px;
    background-color: #f5f5f7;
    color: #6e6e73;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
}

/* 포스트 제목 스타일 */
.post-title {
    margin: 0 0 12px;
    font-size: 24px;
    font-weight: 600;
    line-height: 1.3;
    color: #1d1d1f;
    transition: color 0.2s ease;
}

.post-link:hover .post-title {
    color: var(--purple-base, #6E45E2);
}

/* 포스트 날짜 스타일 */
.post-date {
    font-size: 16px;
    color: #6e6e73;
}

/* 등록된 포스트가 없을 때 스타일 */
.no-posts {
    text-align: center;
    padding: 40px 0;
    font-size: 18px;
    color: #6e6e73;
}

/* 반응형 스타일 */
@media (max-width: 768px) {
    .post-link {
        align-items: flex-start;
    }
    
    .post-thumbnail {
        flex: 0 0 120px;
        height: 90px;
        margin-right: 16px;
    }
    
    .post-title {
        font-size: 20px;
        margin-bottom: 8px;
    }
    
    .post-date {
        font-size: 14px;
    }
    
    .post-tag {
        font-size: 13px;
        padding: 4px 10px;
    }
    
    .post-tag-more {
        font-size: 13px;
        padding: 4px 10px;
    }
    
    .post-item {
        margin-bottom: 24px;
        padding-bottom: 24px;
    }
}
</style> 