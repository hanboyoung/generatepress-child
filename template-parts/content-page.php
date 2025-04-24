<?php
/**
 * 동적 글목록 페이지 템플릿
 */

// 현재 페이지 번호
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// 기본 쿼리 설정
$query_args = array(
    'post_type' => 'post',
    'posts_per_page' => 9,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC'
);

// 새로운 쿼리 실행
$posts_query = new WP_Query($query_args);

if ($posts_query->have_posts()) : ?>
    <div class="cards-section">
        <div class="cards-container">
            <div class="cards-grid">
                <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
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
                                <div class="card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></div>
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
                'query' => $posts_query
            ));
            ?>
        </div>
    </div>

    <?php wp_reset_postdata();
endif;
?> 