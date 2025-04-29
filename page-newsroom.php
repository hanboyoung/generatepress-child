<?php
/**
 * 메인 카테고리 랜딩 페이지 (슬러그 기반, 애플 스타일)
 *
 * @package GeneratePress-child
 */

get_header(); ?>

<div id="page" class="site main-category-landing">
    <div class="container">

        <?php
        // ✅ 메인 카테고리 슬러그 지정
        $main_category_slug = 'news'; // 예시: 'news'

        // ✅ 메인 카테고리 정보 가져오기
        $main_category = get_term_by('slug', $main_category_slug, 'category');

        if ($main_category) :

            // ✅ 메인 카테고리의 하위 카테고리 가져오기 (슬러그로 찾음)
            $child_categories = get_categories(array(
                'taxonomy' => 'category',
                'parent' => $main_category->term_id, // 직접 parent를 지정
                'hide_empty' => true,
                'orderby' => 'name',
                'order' => 'ASC',
            ));

            // ✅ 섹션 제목 설정 (선택사항)
            $section_titles = array(
                'news-economic' => '살면서 꼭 필요한 경제 소식!',
                'news-policy-welfare'   => '정책, 복지 서비스를 공유 합니다.',
                'life-news'   => '라이프 스타일',
                // 계속 추가 가능
            );

            foreach ($child_categories as $child) :
                $slug = $child->slug;
                $custom_title = isset($section_titles[$slug]) ? $section_titles[$slug] : $child->name;
                ?>
                
                <section class="category-section">
                    <div class="category-header">
                        <h2 class="category-title"><?php echo esc_html($custom_title); ?></h2>
                        <a href="<?php echo esc_url(get_category_link($child->term_id)); ?>" class="view-all">전체 보기 →</a>
                    </div>

                    <?php
                    // 하위 카테고리 최신 글 3개만 표시
                    $query = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'cat' => $child->term_id,
                    ));

                    if ($query->have_posts()) :
                        echo '<div class="post-cards">';
                        while ($query->have_posts()) : $query->the_post(); ?>
                            <article class="post-card">
                                <a href="<?php the_permalink(); ?>" class="post-card-link">
                                    <div class="post-card-thumbnail">
                                        <?php if (has_post_thumbnail()) {
                                            the_post_thumbnail('medium');
                                        } else {
                                            echo '<div class="no-thumbnail"></div>';
                                        } ?>
                                    </div>
                                    <div class="post-card-content">
                                        <h3 class="post-card-title"><?php the_title(); ?></h3>
                                        <time class="post-card-date" datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date('Y년 n월 j일'); ?>
                                        </time>
                                    </div>
                                </a>
                            </article>
                        <?php endwhile;
                        echo '</div>';
                    endif;

                    wp_reset_postdata();
                    ?>
                </section>
            <?php endforeach;
        endif;
        ?>

    </div>
</div>

<style>
/* ===== 스타일은 동일 ===== */
.main-category-landing .container {
    padding: 60px 20px;
    max-width: 1200px;
    margin: 0 auto;
}
.category-section {
    margin-bottom: 80px;
}
.category-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}
.category-title {
    font-size: 32px;
    font-weight: 700;
    color: #1d1d1f;
}

.view-all {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 16px;
    font-weight: 600;
    color: #6E45E2; /* 브랜드 보라색 */
    text-decoration: none;
    padding: 8px 16px;
    background-color: #F6F2FF; /* 살짝 보라빛 배경 */
    border-radius: 9999px; /* pill 형태 */
    transition: background 0.3s, color 0.3s, transform 0.2s;
}

.view-all:hover {
    background-color: #E4D9FF; /* 더 진한 보라빛 배경 */
    color: #5a34cc; /* 살짝 진한 보라 텍스트 */
    transform: translateY(-2px); /* 약간 튀어 오르는 효과 */
}

.post-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}
.post-card {
    background: #f5f5f7;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}
.post-card-link {
    display: block;
    color: inherit;
    text-decoration: none;
}
.post-card-thumbnail img, .no-thumbnail {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background: #d1d1d6;
}
.post-card-content {
    padding: 20px;
}
.post-card-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 10px;
}
.post-card-date {
    font-size: 14px;
    color: #666;
}

.post-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* ⭐ 가로 3개 고정 */
    gap: 30px;
}

@media (max-width: 1024px) {
    .post-cards {
        grid-template-columns: repeat(2, 1fr); /* ⭐ 태블릿에서는 2개 */
    }
}

@media (max-width: 600px) {
    .post-cards {
        grid-template-columns: 1fr; /* ⭐ 모바일에서는 1개 */
    }
}
</style>

<?php get_footer(); ?>