<?php
/**
 * 공통 카테고리 아카이브 템플릿 (애플 스타일)
 * @package GeneratePress-child
 */

if (!defined('ABSPATH')) exit;

get_header(); ?>

<div id="page" class="site">
    <section class="category-hero">
        <div class="container">
            <div class="breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">홈</a> › 
                <?php
                $ancestors = get_ancestors(get_queried_object_id(), 'category');
                $ancestors = array_reverse($ancestors);
                foreach ($ancestors as $ancestor) {
                    echo '<a href="' . esc_url(get_category_link($ancestor)) . '">' . esc_html(get_cat_name($ancestor)) . '</a> › ';
                }
                ?>
                <span><?php single_cat_title(); ?></span>
            </div>

            <h1 class="category-title"><?php single_cat_title(); ?></h1>
            <?php if (category_description()) : ?>
                <p class="category-description"><?php echo category_description(); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                <?php if (have_posts()) : ?>
                    <section class="category-posts">
                        <div class="post-grid">
                            <?php while (have_posts()) : the_post(); ?>
                                <article class="post-card">
                                    <a href="<?php the_permalink(); ?>" class="post-link">
                                        <div class="thumbnail">
                                            <?php if (has_post_thumbnail()) {
                                                the_post_thumbnail('medium');
                                            } else {
                                                echo '<div class="no-thumbnail"></div>';
                                            } ?>
                                        </div>
                                        <div class="content">
                                            <h2 class="title"><?php the_title(); ?></h2>
                                            <time class="date" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
                                        </div>
                                    </a>
                                </article>
                            <?php endwhile; ?>
                        </div>
                    </section>

                    <div class="apple-pagination">
                        <?php
                        the_posts_pagination(array(
                            'prev_text' => '<span class="prev-icon">&larr;</span> 이전',
                            'next_text' => '다음 <span class="next-icon">&rarr;</span>',
                            'mid_size' => 2,
                            'end_size' => 1,
                            'screen_reader_text' => ' ',
                        ));
                        ?>
                    </div>

                <?php else : ?>
                    <div class="no-results">
                        <h2>게시물이 없습니다</h2>
                        <p>이 카테고리에 등록된 글이 없습니다.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<style>
/* ❯ 카테고리 히어로 */
.category-hero {
    padding: 100px 20px 40px;
    background: #f9f9fb;
    text-align: center;
}
.breadcrumb {
    text-align: left;
    font-size: 14px;
    margin-bottom: 20px;
    color: #999;
}
.breadcrumb a {
    color: #6e6e73;
    text-decoration: none;
}
.breadcrumb a:hover {
    text-decoration: underline;
}
.category-title {
    font-size: 48px;
    font-weight: 700;
    color: #1d1d1f;
}
.category-description {
    margin-top: 20px;
    font-size: 18px;
    color: #6e6e73;
}

/* ❯ 게시물 카드 */
.category-posts {
    padding: 60px 0;
}
.post-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}
.post-card {
    background: #f5f5f7;
    border-radius: 16px;
    overflow: hidden;
    transition: 0.3s;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}
.post-card:hover {
    transform: translateY(-5px);
}
.thumbnail img, .no-thumbnail {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background: #d1d1d6;
}
.content {
    padding: 20px;
}
.title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 8px;
}
.date {
    font-size: 14px;
    color: #6e6e73;
}

/* ❯ 페이지네이션 */
.apple-pagination {
    margin: 40px 0;
    text-align: center;
}
.apple-pagination .page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 4px;
    padding: 8px 12px;
    font-size: 15px;
    color: #1d1d1f;
    text-decoration: none;
    border-radius: 50px;
    transition: all 0.2s;
}
.apple-pagination .page-numbers:hover {
    background: #eee6ff;
    color: #6E45E2;
}
.apple-pagination .page-numbers.current {
    background: #6E45E2;
    color: #fff;
}
.apple-pagination .prev-icon, .apple-pagination .next-icon {
    font-size: 14px;
}

@media (max-width: 768px) {
    .category-title {
        font-size: 36px;
    }
    .post-grid {
        gap: 20px;
    }
}
@media (max-width: 480px) {
    .category-title {
        font-size: 28px;
    }
    .thumbnail img, .no-thumbnail {
        height: 180px;
    }
}
</style>

<?php get_footer(); ?>