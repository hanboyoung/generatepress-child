<?php
/**
 * ⚠️ 경고: 이 파일은 현재 프로덕션에서 사용 중인 완성된 버전입니다!
 * 🚫 직접 수정하지 마세요!
 * 
 * 최종 수정일: 2024-04-18
 * 버전: 1.0.0
 * 
 * 새로운 페이지 템플릿이 필요한 경우:
 * 1. 이 파일을 복사하여 새로운 이름으로 저장 (예: page-custom.php)
 * 2. 새로운 파일에서 작업을 진행해 주세요
 */

/**
 * 정적 페이지 템플릿
 *
 * @package GeneratePress-child
 */

get_header(); ?>

<div id="page" class="site">
    <?php
    // 히어로 섹션
    get_template_part('template-parts/hero');
    ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">



                        <section class="custom-board">
            <h2 class="custom-board-title">자료실 / 공지사항</h2>
            <ul class="custom-board-list">
                <?php
                $args = array(
                'post_type' => 'post',
                'posts_per_page' => 10,
                'category_name' => 'board'
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post(); ?>
                    <li class="custom-board-item">
                    <a href="<?php the_permalink(); ?>">
                        <span class="board-title"><?php the_title(); ?></span>
                        <span class="board-meta"><?php echo get_the_date('Y.m.d'); ?></span>
                    </a>
                    </li>
                <?php endwhile;
                wp_reset_postdata();
                else : ?>
                <li class="custom-board-item no-post">등록된 글이 없습니다.</li>
                <?php endif; ?>
            </ul>
            </section>
                
                
            </div>
        </main>
    </div>
</div>

<style>
.custom-board {
  max-width: 800px;
  margin: 0 auto;
  padding: 60px 20px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
}
.custom-board-title {
  font-size: 24px;
  font-weight: 800;
  margin-bottom: 30px;
  text-align: center;
  color: var(--text-primary);
}
.custom-board-list {
  list-style: none;
  margin: 0;
  padding: 0;
}
.custom-board-item {
  padding: 18px 24px;
  border-bottom: 1px solid #eee;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: background 0.2s;
}
.custom-board-item:hover {
  background: #f9f9f9;
}
.custom-board-item a {
  display: flex;
  justify-content: space-between;
  width: 100%;
  text-decoration: none;
  color: inherit;
}
.board-title {
  font-size: 16px;
  font-weight: 500;
}
.board-meta {
  font-size: 14px;
  color: #999;
}
.no-post {
  text-align: center;
  padding: 40px;
  color: #999;
}
    
</style>

<?php get_footer(); ?>