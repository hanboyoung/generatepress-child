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
            <div class="news-grid">
                <?php while ($image_query->have_posts()) : $image_query->the_post(); ?>
                    <article <?php post_class('news-card'); ?>>
                        <a href="<?php the_permalink(); ?>" class="news-card-link">
                            <div class="news-card-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="news-thumbnail">
                                        <?php the_post_thumbnail('large', array('class' => 'news-card-thumb')); ?>
                                    </div>
                                <?php else: ?>
                                    <div class="news-thumbnail news-no-thumbnail"></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="news-card-content">
                                <?php
                                // 태그 표시
                                $post_tags = get_the_tags();
                                if (!empty($post_tags)) : ?>
                                    <div class="news-card-tag">
                                        <?php 
                                        $first_tag = reset($post_tags);
                                        echo '<span class="category-tag category-tag-' . esc_attr($first_tag->slug) . '">' . esc_html($first_tag->name) . '</span>';
                                        ?>
                                    </div>
                                <?php endif; ?>
                                
                                <h2 class="news-card-title"><?php the_title(); ?></h2>
                                
                                <div class="news-card-meta">
                                    <time datetime="<?php echo get_the_date('c'); ?>" class="news-card-date">
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
    
    <style>
    /* 애플 뉴스룸 스타일 그리드 */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 40px;
        margin: 0 auto;
        max-width: 1100px;
        padding: 0 20px;
    }
    
    @media (min-width: 735px) {
        .news-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }
    }
    
    @media (min-width: 1069px) {
        .news-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            padding: 0;
        }
    }
    
    /* 뉴스 카드 스타일 */
    .news-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .news-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    .news-card-link {
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .news-card-image {
        position: relative;
        overflow: hidden;
        border-radius: 20px 20px 0 0;
    }
    
    .news-thumbnail {
        padding-bottom: 56.25%; /* 16:9 비율 */
        position: relative;
        overflow: hidden;
    }
    
    .news-card-thumb {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .news-card:hover .news-card-thumb {
        transform: scale(1.05);
    }
    
    .news-no-thumbnail {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #f5f5f7;
    }
    
    .news-card-content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        background: #fff;
    }
    
    .news-card-tag {
        margin-bottom: 15px;
    }
    
    .news-card-title {
        font-size: 22px;
        font-weight: 600;
        line-height: 1.3;
        margin: 0 0 15px;
        color: #1d1d1f;
    }
    
    .news-card-meta {
        margin-top: auto;
        display: flex;
        align-items: center;
    }
    
    .news-card-date {
        font-size: 14px;
        color: #6e6e73;
    }
    
    /* 페이지네이션 스타일 */
    .pagination-nav {
        margin-top: 60px;
        text-align: center;
    }
    
    .pagination-nav ul {
        display: inline-flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 8px;
    }
    
    .pagination-nav li {
        margin: 0;
    }
    
    .pagination-nav a,
    .pagination-nav span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 500;
        color: #1d1d1f;
        transition: all 0.2s ease;
    }
    
    .pagination-nav a {
        background: #f5f5f7;
    }
    
    .pagination-nav a:hover {
        background: var(--purple-ultra-light);
        color: var(--purple-base);
    }
    
    .pagination-nav .current {
        background: var(--purple-base);
        color: #fff;
    }
    
    .pagination-nav .prev,
    .pagination-nav .next {
        font-size: 14px;
    }
    
    @media (max-width: 734px) {
        .pagination-nav ul {
            gap: 5px;
        }
        
        .pagination-nav a,
        .pagination-nav span {
            width: 35px;
            height: 35px;
            font-size: 14px;
        }
    }
    </style>

    <?php wp_reset_postdata();
endif;
?> 