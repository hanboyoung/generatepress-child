<?php
/**
 * 404 에러 페이지 템플릿
 * 애플 스타일의 404 페이지
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="error-404-wrapper">
            <div class="error-404-container">
                <div class="error-404-content">
                    <h1 class="error-404-title">페이지를 찾을 수 없습니다.</h1>
                    <p class="error-404-description">요청하신 페이지가 삭제되었거나, 이름이 변경되었거나, 일시적으로 사용이 중단되었을 수 있습니다.</p>
                    <div class="error-404-actions">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="error-404-button">홈으로 가기</a>
                        <button onclick="window.history.back();" class="error-404-button error-404-button-secondary">이전 페이지로</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php get_footer(); ?> 