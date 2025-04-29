<?php
/**
 * 메인 카테고리 랜딩 페이지 (애플 스타일 / 슬러그 지정 방식)
 *
 * @package GeneratePress-child
 */

get_header(); ?>

<div id="page" class="site main-category-landing">
    <div class="container">

    <?php
        // ✅ 표시할 카테고리 슬러그 순서대로 나열
        $custom_order = array('wordpress', 'video-design', 'ai-automation', 'bookmark');

        // ✅ 섹션 제목 설정 (필수는 아님, 없으면 카테고리명 출력)
        $section_titles = array(
            'wordpress' => '워드프레스',
            'video-design' => '🎬 영상 디자인',
            'ai-automation' => '🤖 AI 자동화 수익',
            'bookmark' => '📚 기타 북마크',
        );

        foreach ($custom_order as $slug) :
            $category = get_category_by_slug($slug);
            if (!$category) continue; // 카테고리가 없으면 건너뜀

            $custom_title = isset($section_titles[$slug]) ? $section_titles[$slug] : $category->name;

            // 글이 있는지 쿼리
            $query = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'cat' => $category->term_id,
            ));

            if ($query->have_posts()) : ?>
                <section class="category-section">
                    <div class="category-header">
                        <h2 class="category-title"><?php echo esc_html($custom_title); ?></h2>
                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="view-all">전체 보기 →</a>
                    </div>

                    <div class="post-cards">
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
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
                        <?php endwhile; ?>
                    </div>
                </section>
                <?php 
                wp_reset_postdata();
            endif;
        endforeach;
    ?>

    </div>
</div>

<style>
/* ===== 메인 레이아웃 ===== */
.main-category-landing .container {
    padding: 60px 20px;
    max-width: 1200px;
    margin: 0 auto;
}

/* ===== 카테고리 섹션 ===== */
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

/* 전체 보기 버튼 */
.view-all {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 16px;
    font-weight: 600;
    color: #6E45E2;
    text-decoration: none;
    padding: 8px 16px;
    background-color: #F6F2FF;
    border-radius: 9999px;
    transition: background 0.3s, color 0.3s, transform 0.2s;
}
.view-all:hover {
    background-color: #E4D9FF;
    color: #5a34cc;
    transform: translateY(-2px);
}

/* ===== 카드 레이아웃 ===== */
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

/* ===== 반응형 ===== */
@media (max-width: 1024px) {
    .post-cards {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 600px) {
    .post-cards {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>