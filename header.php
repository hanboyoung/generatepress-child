<?php
/**
 * ⚠️ 경고: 이 파일은 현재 프로덕션에서 사용 중인 완성된 버전입니다!
 * 🚫 직접 수정하지 마세요!
 * 
 * 최종 수정일: 2024-04-18
 * 버전: 1.0.0
 * 
 * 헤더 수정이 필요한 경우:
 * 1. 반드시 관리자에게 문의해주세요
 * 2. 승인 후 새로운 파일을 생성하여 작업을 진행합니다
 * 3. 테스트 완료 후 관리자 검토를 거쳐 적용됩니다
 */

if (!defined('ABSPATH')) {
    exit; // 직접 접근 방지
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <header class="site-header">
        <div class="header-inner">
            <div class="site-branding">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h1>';
                }
                ?>
            </div>

            <nav class="main-navigation header-nav">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="screen-reader-text">메뉴</span>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'nav-menu header-menu',
                    'fallback_cb'    => false,
                ));
                ?>
            </nav>
        </div>
    </header>

    <div id="page" class="site">
        <div id="content" class="site-content"> 