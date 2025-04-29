<?php
/**
 * 이미지 중심 카드형 레이아웃 템플릿 (애플 스타일)
 */

$category = get_queried_object();
$category_slug = $category->slug;
$custom_class = "category-{$category_slug}-card";
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 12,
    'paged' => $paged,
    'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $category->term_id,
            'include_children' => true,
        ),
    ),
);

$image_query = new WP_Query($args);

if ($image_query->have_posts()) : ?>
<div class="apple-stories-section">
    <div class="apple-stories-container <?php echo esc_attr($custom_class); ?>">
        <div class="apple-stories-grid">
            <?php while ($image_query->have_posts()) : $image_query->the_post(); ?>
                <article <?php post_class('story-card'); ?>>
                    <a href="<?php the_permalink(); ?>" class="story-card-link">
                        <div class="story-card-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', array('class' => 'story-card-thumb')); ?>
                            <?php else : ?>
                                <div class="story-no-thumbnail"></div>
                            <?php endif; ?>
                        </div>

                        <div class="story-card-overlay">
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) : ?>
                                <div class="story-card-category">
                                    <span class="category-label"><?php echo esc_html($categories[0]->name); ?></span>
                                </div>
                            <?php endif; ?>
                            <h2 class="story-card-title"><?php the_title(); ?></h2>
                            <div class="story-card-meta">
                                <time datetime="<?php echo get_the_date('c'); ?>" class="story-card-date">
                                    <?php echo get_the_date('Y년 n월 j일'); ?>
                                </time>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>

        <?php 
            // 페이지네이션
            get_template_part('template-parts/pagination', null, array(
                'query' => $image_query
            ));
            ?>
        </div>



<style>
/* ===== 기본 레이아웃 ===== */
.apple-stories-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 20px;
    margin: 0 auto;
    max-width: 1200px;
    padding: 20px;
}

@media (min-width: 735px) {
    .apple-stories-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }
}
@media (min-width: 1069px) {
    .apple-stories-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
    }
}

/* ===== 카드 스타일 ===== */
.story-card {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    padding-bottom: 66.67%;
    background: #f5f5f7;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.story-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.story-card-link {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    text-decoration: none;
    color: white;
}

.story-card-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.story-card-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.5s ease;
}

.story-card:hover .story-card-thumb {
    transform: scale(1.05);
}

.story-no-thumbnail {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f5f5f7, #d1d1d6);
}

/* ===== 오버레이 영역 ===== */
.story-card-overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 24px;
    background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

.story-card-category {
    margin-bottom: 10px;
}

.category-label {
    background-color: #6E45E2;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    display: inline-block;
}

.story-card-title {
    font-size: 22px;
    font-weight: 600;
    line-height: 1.3;
    margin-bottom: 8px;
}

.story-card-meta {
    font-size: 14px;
    color: rgba(255,255,255,0.8);
}

/* ===== 페이지네이션 ===== */
.pagination-nav {
    margin: 60px auto 0;
    text-align: center;
}

.pagination-nav ul {
    display: inline-flex;
    list-style: none;
    gap: 8px;
    padding: 0;
}

.pagination-nav li {
    margin: 0;
}

.pagination-nav a, .pagination-nav span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    text-decoration: none;
    border-radius: 20px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.pagination-nav a {
    background: #f5f5f7;
    color: #1d1d1f;
}

.pagination-nav a:hover {
    background: #eee6ff;
    color: #6E45E2;
}

.pagination-nav .current {
    background: #6E45E2;
    color: #fff;
}
</style>

<?php wp_reset_postdata(); endif; ?>