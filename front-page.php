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
                <p class="hero-description animate-on-scroll">프리랜서 영상제작자 미혼 엄마의 세상인 아들과 함께<br>우리가 경험하는 ✨기적✨을 기록 합니다.</p>
                <div class="hero-buttons animate-on-scroll">
                    <a href="#latest-posts" class="hero-button hero-button-primary">최신 스토리 보기</a>
                    <a href="/contact" class="hero-button hero-button-secondary">문의하기</a>
                </div>
            </div>
        </section>

        <div class="site-content">
            <?php
            // 메인 쿼리 설정
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 6,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC'
            );
            $main_query = new WP_Query($args);

            if ($main_query->have_posts()) :
                while ($main_query->have_posts()) : $main_query->the_post();
                    get_template_part('template-parts/content', get_post_type());
                endwhile;

                the_posts_pagination(array(
                    'prev_text' => '이전',
                    'next_text' => '다음',
                ));

                wp_reset_postdata();
            else :
                get_template_part('template-parts/content', 'none');
            endif;
            ?>
        </div>
    </main>
</div>

<style>
<style>
:root {
  --purple-base: #6E45E2;
  --purple-dark: #5B35D5;
  --purple-light: #8A67E8;
  --purple-ultra-light: #F6F2FF;
  --text-primary: #1d1d1f;
  --text-secondary: #86868b;
  --background-primary: #fff;
  --background-secondary: #fbfbfd;
  --hero-primary: #6E45E2;
  --hero-secondary: #8A67E8;
  --hero-gradient: linear-gradient(135deg, var(--hero-primary), var(--hero-secondary));
  --hero-text-primary: #1d1d1f;
  --hero-text-secondary: #6e6e73;
  --hero-background: #fff;
  --hero-shadow: 0 20px 40px rgba(110, 69, 226, 0.15);
}

/* Hero Section */
.hero-section {
  position: relative;
  min-height: 60vh;
  background: var(--background-primary);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 80px 20px;
  overflow: hidden;
}

.hero-content {
  max-width: 1000px;
  width: 100%;
  text-align: center;
  position: relative;
  z-index: 2;
}

.hero-title {
  font-size: 72px;
  font-weight: 700;
  line-height: 1.1;
  margin-bottom: 24px;
  background: linear-gradient(135deg, var(--purple-dark), var(--purple-light));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  letter-spacing: -0.015em;
}

.hero-description {
  font-size: 28px;
  line-height: 1.5;
  max-width: 800px;
  margin: 0 auto 40px;
  color: var(--text-secondary);
  font-weight: 800;
}

.hero-buttons {
  display: flex;
  gap: 20px;
  justify-content: center;
}

.hero-button {
  padding: 18px 35px;
  border-radius: 980px;
  font-size: 20px;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.3s ease;
}

.hero-button-primary {
  background: var(--purple-base);
  color: #fff;
}

.hero-button-primary:hover {
  background: var(--purple-dark);
  color: #fff;
  transform: translateY(-2px);
}

.hero-button-secondary {
  border: 1px solid var(--purple-base);
  color: var(--purple-base);
  background: transparent;
}

.hero-button-secondary:hover {
  background: var(--purple-ultra-light);
  transform: translateY(-2px);
}

/* Posts Grid Section */
.posts-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 100px 20px;
  background: var(--background-secondary);
}

.posts-header {
  text-align: center;
  margin-bottom: 80px;
}

.posts-title {
  font-size: 48px;
  font-weight: 600;
  color: var(--text-primary);
  margin: 0;
  line-height: 1.2;
  letter-spacing: -0.015em;
}

.posts-content {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 40px;
  margin-bottom: 60px;
}

/* Post Card */
.post-card {
  background: var(--background-primary);
  border-radius: 20px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  border: 1px solid rgba(0, 0, 0, 0.04);
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.post-card.is-visible {
  opacity: 1;
  transform: translateY(0);
}

.post-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
}

.post-thumbnail {
  position: relative;
  padding-top: 66%;
  overflow: hidden;
  background: #f5f5f7;
}

.post-thumbnail img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.post-card:hover .post-thumbnail img {
  transform: scale(1.05);
}

.post-content {
  padding: 32px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.entry-title {
  font-size: 24px;
  font-weight: 600;
  line-height: 1.3;
  margin: 0 0 16px;
  letter-spacing: -0.015em;
}

.entry-title a {
  color: var(--text-primary);
  text-decoration: none;
  transition: color 0.2s ease;
}

.entry-title a:hover {
  color: var(--purple-base);
}

.entry-summary {
  font-size: 16px;
  line-height: 1.6;
  color: var(--text-secondary);
  margin-bottom: 24px;
  flex-grow: 1;
}

/* Responsive */
@media (max-width: 1024px) {
  .hero-title { font-size: 56px; }
  .hero-description { font-size: 24px; }
  .posts-content { gap: 30px; }
}

@media (max-width: 768px) {
  .hero-section { min-height: 50vh; padding: 60px 20px; }
  .hero-title { font-size: 42px; }
  .hero-description { font-size: 20px; }
  .hero-buttons { flex-direction: column; gap: 16px; }
  .posts-content { grid-template-columns: 1fr; gap: 24px; }
  .posts-title { font-size: 36px; }
  .post-content { padding: 24px; }
  .entry-title { font-size: 20px; }
}

/* Animations */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

.post-card {
  animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.post-card:nth-child(2) { animation-delay: 0.2s; }
.post-card:nth-child(3) { animation-delay: 0.3s; }
.post-card:nth-child(4) { animation-delay: 0.4s; }
.post-card:nth-child(5) { animation-delay: 0.5s; }
.post-card:nth-child(6) { animation-delay: 0.6s; }

</style>

<?php
get_footer();
?> 