<?php
/**
 * 이미지 중심 카드형 레이아웃 템플릿 (애플 스타일)
 */

// 현재 카테고리 정보
$category = get_queried_object();
$category_slug = $category->slug;

// 카테고리별 커스텀 클래스
$custom_class = "category-{$category_slug}-card";

// 페이지네이션 설정
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// 쿼리 설정
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 12,
    'paged' => $paged,
    'category_name' => $category_slug
);

$image_query = new WP_Query($args);

if ($image_query->have_posts()) : ?>
    <div class="image-grid-section">
        <div class="image-grid-container <?php echo esc_attr($custom_class); ?>">
            <div class="image-grid">
                <?php while ($image_query->have_posts()) : $image_query->the_post(); ?>
                    <article <?php post_class('image-card'); ?>>
                        <a href="<?php the_permalink(); ?>" class="image-card-link">
                            <div class="image-card-media">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large', array('class' => 'image-card-thumb')); ?>
                                <?php else: ?>
                                    <div class="image-card-no-thumb"></div>
                                <?php endif; ?>
                                
                                <div class="image-card-overlay">
                                    <div class="image-card-content">
                                        <?php
                                        // 태그 표시
                                        $tags = get_the_tags();
                                        if (!empty($tags)) : ?>
                                            <div class="tags-container">
                                                <?php foreach ($tags as $tag) : ?>
                                                    <span class="category-tag category-tag-<?php echo esc_attr($tag->slug); ?>">
                                                        <?php echo esc_html($tag->name); ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <h2 class="image-card-title"><?php the_title(); ?></h2>
                                        <div class="image-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></div>
                                        
                                        <div class="image-card-meta">
                                            <time datetime="<?php echo get_the_date('c'); ?>" class="image-card-date">
                                                <?php echo get_the_date('Y년 n월 j일'); ?>
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            // 페이지네이션
            $total_pages = $image_query->max_num_pages;
            if ($total_pages > 1) : ?>
                <nav class="pagination-nav">
                    <?php
                    echo paginate_links(array(
                        'base' => get_pagenum_link(1) . '%_%',
                        'format' => '/page/%#%',
                        'current' => $paged,
                        'total' => $total_pages,
                        'prev_text' => '이전',
                        'next_text' => '다음',
                        'type' => 'list'
                    ));
                    ?>
                </nav>
            <?php endif; ?>
        </div>
    </div>

    <?php wp_reset_postdata();
endif;
?> 