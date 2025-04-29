<?php
/**
 * 애플 스타일 랜딩페이지 (업그레이드 버전)
 *
 * @package GeneratePress-child
 */

get_header();
wp_enqueue_script('scroll-animations', get_stylesheet_directory_uri() . '/assets/js/scroll-animations.js', array(), '1.0.0', true);
?>

<div id="primary" class="content-area">
  <main id="main" class="site-main">

    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-content">
        <h1 class="hero-title animate-on-scroll">사람 살리는 기획자</h1>
        <p class="hero-subtitle animate-on-scroll">
          아들과 함께 살아가는 프리랜서 미혼 엄마.<br>
          우리가 경험하는 기적을 기록합니다.
        </p>
        <div class="hero-buttons">
          <a href="#latest-posts" class="hero-button hero-button-primary animate-on-scroll">최신 스토리 보기</a>
          <a href="/contact" class="hero-button hero-button-secondary animate-on-scroll">문의하기</a>
        </div>
      </div>
    </section>

    <!-- 최신 포스트 섹션 -->
    <section class="apple-section latest-updates" id="latest-posts">
      <div class="section-container">
        <div class="section-header">
          <h2>최신 업데이트</h2>
          <a href="<?php echo esc_url(home_url('/archive/')); ?>" class="view-all-link">모두 보기 →</a>
        </div>

        <div class="featured-grid">
          <?php
          $args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'meta_query' => array(
              array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
              )
            )
          );
          $latest_query = new WP_Query($args);
          if ($latest_query->have_posts()) :
            while ($latest_query->have_posts()) : $latest_query->the_post(); ?>
              <article class="post-card animate-on-scroll">
                <a href="<?php the_permalink(); ?>" class="card-link">
                  <div class="card-image">
                    <?php the_post_thumbnail('large'); ?>
                  </div>
                  <div class="card-content">
                    <div class="card-label">최신</div>
                    <h3 class="card-title"><?php the_title(); ?></h3>
                    <div class="card-date"><?php echo get_the_date(); ?></div>
                  </div>
                </a>
              </article>
          <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
      </div>
    </section>

    <!-- 카테고리 강조 섹션 -->
    <?php
    $featured_categories = array(
      array('slug' => 'saving-life', 'title' => '세상 이야기', 'desc' => '사람 살리는 기획자의 이야기', 'color' => '#6E45E2'),
      array('slug' => 'ai', 'title' => 'AI 자료실', 'desc' => '유용한 자동화 & 인공지능 노트', 'color' => '#8A67E8')
    );

    foreach ($featured_categories as $cat) {
      $term = get_category_by_slug($cat['slug']);
      if (!$term) continue;

      $query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 4,
        'cat' => $term->term_id
      ));

      if ($query->have_posts()) : ?>
        <section class="category-section" style="--section-color: <?php echo esc_attr($cat['color']); ?>">
          <div class="section-container">
            <div class="section-header">
              <div>
                <h2><?php echo esc_html($cat['title']); ?></h2>
                <p class="section-description"><?php echo esc_html($cat['desc']); ?></p>
              </div>
              <a href="<?php echo esc_url(get_category_link($term->term_id)); ?>" class="view-all-link">전체 보기 →</a>
            </div>
            <div class="posts-row">
              <?php while ($query->have_posts()) : $query->the_post(); ?>
                <article class="post-card horizontal animate-on-scroll">
                  <a href="<?php the_permalink(); ?>" class="card-link">
                    <div class="card-image">
                      <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('medium');
                      } else {
                        echo '<div class="no-thumbnail"></div>';
                      } ?>
                    </div>
                    <div class="card-content">
                      <h3 class="card-title"><?php the_title(); ?></h3>
                      <div class="card-date"><?php echo get_the_date(); ?></div>
                    </div>
                  </a>
                </article>
              <?php endwhile; ?>
            </div>
          </div>
        </section>
    <?php
        wp_reset_postdata();
      endif;
    }
    ?>

  </main>
</div>


<style>
:root {
  --apple-blue: #0066CC;
  --apple-black: #1d1d1f;
  --apple-gray: #86868b;
  --apple-light-gray: #f5f5f7;
  --apple-white: #ffffff;
  --apple-section-padding: 90px 0;
  --apple-container-width: 980px;
  --purple-base: #6E45E2;
  --purple-dark: #5B35D5;
  --purple-light: #8A67E8;
  --purple-ultra-light: #F6F2FF;
  --border-color: rgba(0, 0, 0, 0.1);
}

/* Hero 섹션 */
.hero-section {
  background: var(--apple-white);
  padding: 180px 20px 120px;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.hero-content {
  max-width: 800px;
}

.hero-title {
  font-size: 56px;
  line-height: 1.1;
  font-weight: 700;
  letter-spacing: -0.015em;
  margin-bottom: 20px;
  color: var(--apple-black);
}

.hero-description {
  font-size: 24px;
  line-height: 1.5;
  color: var(--apple-gray);
  margin-bottom: 40px;
  font-weight: 400;
}

.hero-buttons {
  display: flex;
  justify-content: center;
  gap: 16px;
  flex-wrap: wrap;
}

.hero-button {
  padding: 14px 28px;
  border-radius: 980px;
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

/* 애플 섹션 공통 스타일 */
.apple-section {
  padding: var(--apple-section-padding);
  color: var(--apple-black);
  background-color: var(--apple-white);
}

.section-container {
  max-width: var(--apple-container-width);
  margin: 0 auto;
  padding: 0 20px;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 40px;
}

.section-header h2 {
  font-size: 36px;
  font-weight: 600;
  margin: 0;
  letter-spacing: -0.015em;
}

.header-content {
  max-width: 60%;
}

.section-description {
  margin-top: 10px;
  font-size: 18px;
  color: var(--apple-gray);
  line-height: 1.5;
}

.view-all-link {
  font-size: 17px;
  font-weight: 500;
  color: var(--apple-blue);
  text-decoration: none;
  transition: color 0.2s ease;
  display: flex;
  align-items: center;
}

.view-all-link:hover {
  text-decoration: underline;
}

.arrow {
  margin-left: 6px;
  transition: transform 0.2s ease;
}

.view-all-link:hover .arrow {
  transform: translateX(3px);
}

/* 포스트 카드 스타일 */
.featured-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.post-card {
  border-radius: 16px;
  overflow: hidden;
  background-color: var(--apple-white);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.post-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12);
}

.post-card.featured {
  grid-column: span 2;
  grid-row: span 2;
}

.card-link {
  text-decoration: none;
  color: inherit;
  display: block;
}

.card-image {
  width: 100%;
  position: relative;
  overflow: hidden;
}

.post-card img {
  width: 100%;
  display: block;
  height: auto;
  transition: transform 0.5s ease;
}

.post-card:hover img {
  transform: scale(1.03);
}

.post-card.featured .card-image {
  height: 400px;
}

.post-card.featured img {
  height: 100%;
  object-fit: cover;
}

.card-content {
  padding: 24px;
}

.card-label {
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  font-weight: 600;
  color: var(--apple-blue);
  margin-bottom: 12px;
}

.card-title {
  font-size: 22px;
  font-weight: 600;
  margin: 0 0 12px;
  color: var(--apple-black);
  line-height: 1.3;
}

.post-card.featured .card-title {
  font-size: 28px;
}

.card-date {
  font-size: 14px;
  color: var(--apple-gray);
}

.card-excerpt {
  font-size: 15px;
  color: var(--apple-gray);
  margin-bottom: 14px;
  line-height: 1.5;
}

.no-thumbnail {
  background-color: #f2f2f2;
  height: 100%;
  min-height: 200px;
}

/* 카테고리 섹션 스타일 */
.category-section {
  background-color: var(--apple-light-gray);
  position: relative;
}

.category-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background-color: var(--section-color, var(--apple-blue));
}

.posts-row {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
}

.post-card.horizontal {
  display: flex;
  flex-direction: column;
}

.post-card.horizontal .card-image {
  height: 200px;
}

.post-card.horizontal img {
  height: 100%;
  object-fit: cover;
}

/* 구독 섹션 */
.subscription-section {
  background-color: var(--purple-ultra-light);
  padding: 80px 0;
  text-align: center;
}

.subscription-content {
  max-width: 600px;
  margin: 0 auto;
}

.subscription-content h2 {
  font-size: 32px;
  font-weight: 600;
  margin-bottom: 16px;
  color: var(--apple-black);
}

.subscription-content p {
  font-size: 18px;
  color: var(--apple-gray);
  margin-bottom: 30px;
}

.subscription-form {
  display: flex;
  max-width: 460px;
  margin: 0 auto;
}

.subscription-form input {
  flex: 1;
  height: 50px;
  padding: 0 20px;
  border: 1px solid var(--border-color);
  border-radius: 25px 0 0 25px;
  font-size: 16px;
  outline: none;
}

.subscription-form button {
  background-color: var(--purple-base);
  color: white;
  border: none;
  padding: 0 30px;
  height: 50px;
  border-radius: 0 25px 25px 0;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.subscription-form button:hover {
  background-color: var(--purple-dark);
}

/* 애니메이션 */
.animate-on-scroll {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.8s ease, transform 0.8s ease;
}

.animate-on-scroll.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* 반응형 */
@media (max-width: 980px) {
  .hero-title {
    font-size: 44px;
  }
  
  .hero-description {
    font-size: 20px;
  }
  
  .section-header {
    flex-direction: column;
    gap: 16px;
  }
  
  .header-content {
    max-width: 100%;
  }
  
  .featured-grid,
  .posts-row {
    grid-template-columns: 1fr;
  }
  
  .post-card.featured {
    grid-column: span 1;
  }
  
  .post-card.featured .card-image {
    height: 300px;
  }
  
  .subscription-form {
    flex-direction: column;
    width: 100%;
  }
  
  .subscription-form input,
  .subscription-form button {
    width: 100%;
    border-radius: 25px;
    margin-bottom: 10px;
  }
}

@media (max-width: 600px) {
  .hero-section {
    padding: 120px 20px 80px;
  }
  
  .hero-title {
    font-size: 36px;
  }
  
  .hero-description {
    font-size: 18px;
  }
  
  .hero-buttons {
    flex-direction: column;
    width: 100%;
  }
  
  .hero-button {
    width: 100%;
  }
  
  .section-header h2 {
    font-size: 28px;
  }
  
  .section-description {
    font-size: 16px;
  }
  
  .post-card.featured .card-title {
    font-size: 24px;
  }
  
  .card-title {
    font-size: 20px;
  }
}
</style>

<?php get_footer(); ?>
