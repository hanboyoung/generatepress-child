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

<?php
get_footer();
?> 