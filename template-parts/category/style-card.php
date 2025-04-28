<?php
/**
 * 카드형 레이아웃 템플릿 (애플 스타일)
 */

// 카테고리 슬러그로 카테고리 정보 가져오기
$category_slug = isset($args['category_slug']) ? $args['category_slug'] : null;
$category = $category_slug ? get_category_by_slug($category_slug) : null;

// 현재 페이지 번호
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// 쿼리 인자 설정
$query_args = array(
    'post_type' => 'post',
    'posts_per_page' => 9,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $category->term_id,
            'include_children' => true,
        ),
    ),
);

// 새로운 쿼리 실행
$card_query = new WP_Query($query_args);

if ($card_query->have_posts()) : ?>
    <div class="cards-section">
        <div class="cards-container">
            <div class="cards-grid">
                <?php while ($card_query->have_posts()) : $card_query->the_post(); ?>
                    <article class="card">
                        <a href="<?php the_permalink(); ?>" class="card-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-image">
                                    <?php the_post_thumbnail('card-thumb'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="card-content">
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
                                
                                <h2 class="card-title"><?php the_title(); ?></h2>
                                <div class="card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></div>
                                <div class="card-meta">
                                    <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('Y년 n월 j일'); ?></time>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php 
            // 페이지네이션
            get_template_part('template-parts/pagination', null, array(
                'query' => $card_query
            ));
            ?>
        </div>
    </div>

    <?php wp_reset_postdata();
endif;
?> 