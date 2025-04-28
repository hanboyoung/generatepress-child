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
                                <?php else: ?>
                                    <div class="story-no-thumbnail"></div>
                                <?php endif; ?>
                                
                                <div class="story-card-overlay">
                                    <?php
                                    // 카테고리 표시
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
    /* 애플 스토리 그리드 레이아웃 */
    .apple-stories-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 20px;
        margin: 0 auto;
        max-width: 1200px;
        padding: 0 20px;
    }
    
    @media (min-width: 735px) {
        .apple-stories-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }
    
    @media (min-width: 1069px) {
        .apple-stories-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding: 0;
        }
    }
    
    /* 스토리 카드 기본 스타일 */
    .story-card {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        height: 0;
        padding-bottom: 66.67%; /* 3:2 비율 */
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
    
    /* 이미지 스타일 */
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
    
    /* 그라데이션 오버레이 */
    .story-card-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 75% 24px 24px;
        background: linear-gradient(to top, 
            rgba(0, 0, 0, 0.85) 0%, 
            rgba(0, 0, 0, 0.6) 30%, 
            rgba(0, 0, 0, 0.3) 60%, 
            rgba(0, 0, 0, 0) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }
    
    /* 카테고리 라벨 */
    .category-label {
        display: inline-block;
        padding: 6px 12px;
        background-color: var(--purple-base, #6E45E2);
        color: white;
        font-size: 13px;
        font-weight: 500;
        border-radius: 20px;
        margin-bottom: 12px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    
    /* 제목 스타일 */
    .story-card-title {
        font-size: 22px;
        font-weight: 600;
        line-height: 1.3;
        margin: 0 0 12px;
        color: white;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }
    
    /* 날짜 스타일 */
    .story-card-meta {
        display: flex;
        align-items: center;
    }
    
    .story-card-date {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.8);
    }
    
    /* 하단 그림자 강화 - 가독성 향상 */
    .story-card:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 40%;
        background: linear-gradient(to top, 
            rgba(0, 0, 0, 0.2) 0%, 
            rgba(0, 0, 0, 0) 100%);
        pointer-events: none;
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
    
    /* 반응형 조정 */
    @media (max-width: 734px) {
        .story-card {
            padding-bottom: 75%; /* 모바일에서는 4:3 비율 */
        }
        
        .story-card-title {
            font-size: 18px;
        }
        
        .story-card-overlay {
            padding: 75% 16px 16px;
        }
        
        .category-label {
            font-size: 12px;
            padding: 4px 10px;
        }
        
        .pagination-nav a,
        .pagination-nav span {
            width: 36px;
            height: 36px;
            font-size: 14px;
        }
    }
    </style>

    <?php wp_reset_postdata();
endif;
?> 