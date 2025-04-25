<?php
/**
 * 프론트 페이지 템플릿
 *
 * @package GeneratePress-child
 */

get_header();

// 스크롤 애니메이션 스크립트 추가
wp_enqueue_script('scroll-animations', get_stylesheet_directory_uri() . '/assets/js/scroll-animations.js', array(), '1.0.0', true);
?>

<div id="primary" class="content-area">
  <main id="main" class="site-main">

    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-content">
        <h1 class="hero-title animate-on-scroll">사람 살리는 기획자.</h1>
        <p class="hero-description animate-on-scroll">
          프리랜서 영상제작자 미혼 엄마의 세상인 아들과 함께<br>
          우리가 경험하는 ✨기적✨을 기록 합니다.
        </p>
        <div class="hero-buttons animate-on-scroll">
        <a href="#latest-posts" class="hero-button hero-button-primary animate-on-scroll">최신 스토리 보기</a>
        <a href="/contact" class="hero-button hero-button-secondary animate-on-scroll">문의하기</a>
        </div>
      </div>
    </section>

    <!-- Apple Newsroom 스타일 최신 글 -->
    <section class="newsroom-hero" id="latest-posts">
      <h2 class="newsroom-title">최신 뉴스</h2>
      <div class="newsroom-grid">
        <?php
        $args = array(
          'post_type' => 'post',
          'posts_per_page' => 6,
          'meta_query' => array(
            array(
              'key'     => '_thumbnail_id',
              'compare' => 'EXISTS'
            )
          )
        );
        $news_query = new WP_Query($args);
        $count = 0;

        if ($news_query->have_posts()) :
          while ($news_query->have_posts()) : $news_query->the_post();
            $count++;
            $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>
            <article class="newsroom-card <?php echo $count === 1 ? 'featured' : ''; ?>">
              <a href="<?php the_permalink(); ?>">
                <div class="newsroom-thumb" style="background-image:url('<?php echo esc_url($thumb_url); ?>');"></div>
                <div class="newsroom-meta">
                  <span class="newsroom-date"><?php echo get_the_date('Y년 n월 j일'); ?></span>
                  <h3 class="newsroom-headline"><?php the_title(); ?></h3>
                </div>
              </a>
            </article>
          <?php endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </section>

  </main>
</div>

<style>
:root {
  --purple-base: #6E45E2;
  --purple-dark: #5B35D5;
  --purple-light: #8A67E8;
  --purple-ultra-light: #F6F2FF;
  --text-primary: #1d1d1f;
  --text-secondary: #86868b;
  --background-primary: #fff;
  --background-secondary: #f9f9fb;
}

/* Hero Section */
.hero-section {
  background: var(--background-primary);
  padding: 150px 20px 100px;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}
.hero-content {
  max-width: 800px;
}
.hero-title {
  font-size: 48px;
  font-weight: 800;
  line-height: 1.3;
  margin-bottom: 20px;
  color: var(--text-primary);
}
.hero-description {
  font-size: 20px;
  color: var(--text-secondary);
  font-weight: 500;
  margin-bottom: 40px;
  line-height: 1.7;
}
.hero-buttons {
  display: flex;
  justify-content: center;
  gap: 16px;
  flex-wrap: wrap;
}
.hero-button {
  padding: 14px 28px;
  border-radius: 999px;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
}
.hero-button-primary {
  background: var(--purple-base);
  color: #fff;
}
.hero-button-primary:hover {
  background: var(--purple-dark);
}
.hero-button-secondary {
  border: 1px solid var(--purple-base);
  color: var(--purple-base);
  background: transparent;
}
.hero-button-secondary:hover {
  background: var(--purple-ultra-light);
}

/* Newsroom 스타일 */
.newsroom-hero {
  max-width: 1200px;
  margin: 0 auto;
  padding: 80px 20px;
}
.newsroom-title {
  font-size: 32px;
  font-weight: 800;
  margin-bottom: 40px;
}
.newsroom-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 32px;
}
.newsroom-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
  display: flex;
  flex-direction: column;
  transition: transform 0.2s ease;
}
.newsroom-card:hover {
  transform: translateY(-5px);
}
.newsroom-card.featured {
  grid-column: span 2;
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 300px;
}
.newsroom-thumb {
  background-size: cover;
  background-position: center;
  height: 200px;
}
.newsroom-card.featured .newsroom-thumb {
  height: 100%;
}
.newsroom-meta {
  padding: 24px;
}
.newsroom-date {
  font-size: 14px;
  color: #888;
  display: block;
  margin-bottom: 10px;
}
.newsroom-headline {
  font-size: 20px;
  font-weight: 700;
  color: #1d1d1f;
  margin: 0;
  line-height: 1.4;
}

@media (max-width: 768px) {
  .newsroom-grid {
    grid-template-columns: 1fr;
  }
  .newsroom-card.featured {
    grid-template-columns: 1fr;
  }
}

.animate-on-scroll {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.6s ease;
}

.animate-on-scroll.is-visible {
  opacity: 1;
  transform: translateY(0);
}
</style>








<?php get_footer(); ?> 