<?php
/**
 * 싱글 포스트 템플릿
 * 
 * 애플 스타일의 단일 포스트 페이지
 * - 히어로 섹션 (특성 이미지)
 * - 포스트 메타 (날짜, 카테고리)
 * - 콘텐츠
 * - 사이드바 (오른쪽)
 * - 이전/다음 포스트 내비게이션
 */

get_header();
?>

<div class="single-container">
    <div class="content-sidebar-wrapper">
        <main class="content-area">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    
                    <div class="entry-meta">
                        <span class="posted-on">
                            <?php echo get_the_date(); ?>
                        </span>
                        <?php
                        $categories = get_the_category();
                        if ($categories) :
                            echo '<span class="cat-links">';
                            foreach ($categories as $category) :
                                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
                            endforeach;
                            echo '</span>';
                        endif;
                        ?>
                    </div>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer">
                    <?php
                    $tags = get_the_tags();
                    if ($tags) :
                        echo '<div class="tags-links">';
                        foreach ($tags as $tag) :
                            printf(
                                '<a href="%1$s" class="tag-link"><svg class="tag-icon" viewBox="0 0 24 24" width="16" height="16"><path d="M10.9,2.1c-0.6-0.5-1.4-0.7-2.1-0.4l-7.5,2.7C0.5,4.6,0,5.5,0,6.4v4.7c0,0.5,0.2,0.9,0.4,1.2l7.8,9.5 c0.4,0.5,1.1,0.8,1.8,0.8s1.4-0.3,1.8-0.8l7.8-9.5c0.3-0.4,0.4-0.8,0.4-1.2V6.4c0-0.9-0.5-1.8-1.4-2.1l-7.5-2.7 C11.5,1.4,11.1,1.6,10.9,2.1z M13.5,9C12.7,9,12,8.3,12,7.5S12.7,6,13.5,6S15,6.7,15,7.5S14.3,9,13.5,9z"></path></svg>%2$s</a>',
                                esc_url(get_tag_link($tag->term_id)),
                                esc_html($tag->name)
                            );
                        endforeach;
                        echo '</div>';
                    endif;
                    ?>

                    <!-- 좋아요 버튼 -->
                    <div class="post-likes-container">
                        <?php 
                        // 포스트 ID
                        $post_id = get_the_ID();
                        
                        // 현재 좋아요 수 가져오기
                        $likes = get_post_meta($post_id, 'post_likes', true);
                        if (!$likes) $likes = 0;
                        
                        // 현재 사용자가 이미 좋아요를 눌렀는지 확인
                        $liked = false;
                        if (isset($_COOKIE['post_liked_' . $post_id])) {
                            $liked = true;
                        }
                        ?>
                        
                        <button id="like-button" class="like-button <?php echo $liked ? 'liked' : ''; ?>" data-post-id="<?php echo $post_id; ?>" data-nonce="<?php echo wp_create_nonce('like_post_nonce'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" class="like-icon">
                                <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z"/>
                            </svg>
                            <span class="like-count"><?php echo $likes; ?></span>
                            <span class="like-text">좋아요</span>
                        </button>
                        
                        <div class="like-message"></div>
                    </div>

                    <nav class="post-navigation">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        
                        if (!empty($prev_post)) {
                            $prev_thumb = get_the_post_thumbnail($prev_post->ID, 'thumbnail');
                            ?>
                            <div class="nav-previous">
                                <a href="<?php echo get_permalink($prev_post->ID); ?>">
                                    <div class="nav-thumbnail">
                                        <?php if ($prev_thumb) : ?>
                                            <?php echo $prev_thumb; ?>
                                        <?php else : ?>
                                            <div class="no-nav-thumbnail"></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="nav-content">
                                        <span class="nav-subtitle">이전 글</span>
                                        <h4 class="nav-title"><?php echo get_the_title($prev_post->ID); ?></h4>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                        
                        if (!empty($next_post)) {
                            $next_thumb = get_the_post_thumbnail($next_post->ID, 'thumbnail');
                            ?>
                            <div class="nav-next">
                                <a href="<?php echo get_permalink($next_post->ID); ?>">
                                    <div class="nav-content">
                                        <span class="nav-subtitle">다음 글</span>
                                        <h4 class="nav-title"><?php echo get_the_title($next_post->ID); ?></h4>
                                    </div>
                                    <div class="nav-thumbnail">
                                        <?php if ($next_thumb) : ?>
                                            <?php echo $next_thumb; ?>
                                        <?php else : ?>
                                            <div class="no-nav-thumbnail"></div>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </nav>
                </footer>
            </article>
        </main>

        <aside class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-widget related-posts">
                    <h3 class="widget-title">관련 포스트</h3>
                    <?php
                    // 현재 포스트의 카테고리 기반으로 관련 포스트 가져오기
                    $categories = get_the_category();
                    if ($categories) {
                        $category_ids = array();
                        foreach ($categories as $category) {
                            $category_ids[] = $category->term_id;
                        }
                        
                        $related_args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 3,
                            'post__not_in' => array(get_the_ID()),
                            'category__in' => $category_ids,
                            'orderby' => 'rand'
                        );
                        
                        $related_query = new WP_Query($related_args);
                        
                        if ($related_query->have_posts()) {
                            echo '<ul class="related-posts-list">';
                            while ($related_query->have_posts()) {
                                $related_query->the_post();
                                ?>
                                <li class="related-post-item">
                                    <a href="<?php the_permalink(); ?>" class="related-post-link">
                                        <div class="related-post-image">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('thumbnail'); ?>
                                            <?php else : ?>
                                                <div class="no-thumbnail"></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="related-post-content">
                                            <h4 class="related-post-title"><?php the_title(); ?></h4>
                                            <span class="related-post-date"><?php echo get_the_date(); ?></span>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                            echo '</ul>';
                            wp_reset_postdata();
                        } else {
                            echo '<p>관련 포스트가 없습니다.</p>';
                        }
                    }
                    ?>
                </div>

                <div class="sidebar-widget recent-posts">
                    <h3 class="widget-title">최신 포스트</h3>
                    <?php
                    $recent_args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'post__not_in' => array(get_the_ID()),
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );
                    
                    $recent_query = new WP_Query($recent_args);
                    
                    if ($recent_query->have_posts()) {
                        echo '<ul class="recent-posts-list">';
                        while ($recent_query->have_posts()) {
                            $recent_query->the_post();
                            ?>
                            <li class="recent-post-item">
                                <a href="<?php the_permalink(); ?>" class="recent-post-link">
                                    <h4 class="recent-post-title"><?php the_title(); ?></h4>
                                    <span class="recent-post-date"><?php echo get_the_date(); ?></span>
                                </a>
                            </li>
                            <?php
                        }
                        echo '</ul>';
                        wp_reset_postdata();
                    } else {
                        echo '<p>최신 포스트가 없습니다.</p>';
                    }
                    ?>
                </div>

                <!-- <div class="sidebar-widget categories">
                    <h3 class="widget-title">카테고리</h3>
                    <ul class="categories-list">
                        <?php
                        // 최상위 카테고리만 가져오기 (하위 카테고리 제외)
                        $categories = get_categories(array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'parent' => 0 // 부모가 0인 카테고리만 가져오기 (최상위 카테고리)
                        ));
                        
                        foreach ($categories as $category) {
                            printf(
                                '<li><a href="%1$s">%2$s <span class="count">(%3$s)</span></a></li>',
                                esc_url(get_category_link($category->term_id)),
                                esc_html($category->name),
                                esc_html($category->count)
                            );
                        }
                        ?>
                    </ul>
                </div> -->

                <div class="sidebar-widget tags-cloud">
                    <h3 class="widget-title">태그</h3>
                    <div class="tags-buttons">
                        <?php
                        // 태그 가져오기
                        $tags = get_tags(array(
                            'orderby' => 'count',
                            'order' => 'DESC',
                            'number' => 20 // 표시할 태그 수 제한
                        ));
                        
                        if ($tags) {
                            foreach ($tags as $tag) {
                                printf(
                                    '<a href="%1$s" class="tag-button" data-count="%3$s">%2$s</a>',
                                    esc_url(get_tag_link($tag->term_id)),
                                    esc_html($tag->name),
                                    esc_html($tag->count)
                                );
                            }
                        } else {
                            echo '<p>태그가, 없습니다.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
    /* 보라색 브랜드 컬러 변수 */
    :root {
        --brand-purple: #6E45E2;
        --brand-purple-light: #8A67E8;
        --brand-purple-dark: #5B35D5;
        --brand-purple-ultra-light: #F6F2FF;
    }
    
    /* 애플 스타일 싱글 페이지 스타일 */
    .single-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .content-sidebar-wrapper {
        display: flex;
        gap: 50px;
    }
    
    .content-area {
        flex: 1;
        min-width: 0; /* 플렉스 아이템이 너무 작아지지 않도록 */
    }
    
    .sidebar {
        width: 340px;
        flex-shrink: 0;
    }
    
    .sidebar-inner {
        position: sticky;
        top: 120px; /* 헤더 높이 + 여백 */
    }
    
    /* 애플 스타일 헤더 */
    .entry-header {
        margin-bottom: 40px;
    }
    
    .entry-title {
        font-size: 42px;
        font-weight: 700;
        margin: 0 0 25px;
        line-height: 1.2;
        color: #1d1d1f;
        letter-spacing: -0.5px;
    }
    
    .entry-meta {
        display: flex;
        gap: 15px;
        font-size: 15px;
        color: #6e6e73;
        margin-bottom: 25px;
        align-items: center;
    }
    
    .cat-links {
        display: flex;
        gap: 8px;
    }
    
    .cat-links a {
        color: var(--brand-purple);
        text-decoration: none;
        font-weight: 500;
        padding: 4px 10px;
        background-color: rgba(110, 69, 226, 0.08);
        border-radius: 15px;
        transition: all 0.2s ease;
    }
    
    .cat-links a:hover {
        background-color: rgba(110, 69, 226, 0.15);
        color: var(--brand-purple-dark);
    }
    
    .featured-image {
        margin-bottom: 40px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }
    
    .featured-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.5s ease;
    }
    
    .featured-image:hover img {
        transform: scale(1.02);
    }
    
    /* 콘텐츠 스타일 */
    .entry-content {
        font-size: 19px; /* 기본 폰트 크기 증가 */
        line-height: 1.7; /* 라인 높이 증가 */
        color: #1d1d1f;
    }
    
    .entry-content p {
        margin-bottom: 24px; /* 단락 간격 증가 */
    }
    
    /* 개선된 H2 스타일 - 더 세련된 디자인 */
    .entry-content h2 {
        font-size: 30px;
        font-weight: 700;
        margin: 50px 0 24px;
        color: white;
        padding: 6px 20px;
        background: linear-gradient(135deg, var(--brand-purple) 0%, var(--brand-purple-light) 100%);
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(110, 69, 226, 0.2);
        position: relative;
        overflow: hidden;
        letter-spacing: -0.5px;
        transform: translateZ(0);
    }
    
    .entry-content h2::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
        transform: skewX(-20deg) translateX(-100%);
        transition: transform 0.6s ease;
    }
    
    .entry-content h2:hover::before {
        transform: skewX(-20deg) translateX(100%);
    }
    
    .entry-content h2::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 30%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='80' cy='20' r='20' fill='white' fill-opacity='0.05'/%3E%3Ccircle cx='20' cy='80' r='30' fill='white' fill-opacity='0.05'/%3E%3C/svg%3E");
        background-size: 100px 100px;
        background-repeat: no-repeat;
        background-position: right top;
        opacity: 0.6;
    }
    
    /* 개선된 H3 스타일 - 밑줄 강조 */
    .entry-content h3 {
        font-size: 26px;
        font-weight: 600;
        margin: 40px 0 20px;
        color: var(--brand-purple-dark);
        padding: 0 0 10px 0;
        position: relative;
        border-bottom: none;
    }
    
    .entry-content h3::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, var(--brand-purple) 0%, rgba(110, 69, 226, 0.2) 100%);
        border-radius: 3px;
    }
    
    /* 강화된 링크 스타일 */
    .entry-content a {
        color: var(--brand-purple);
        text-decoration: none;
        background-color: var(--brand-purple-ultra-light);
        padding: 2px 5px;
        border-radius: 4px;
        font-weight: 500;
        transition: all 0.2s ease;
        border-bottom: none;
    }
    
    .entry-content a:hover {
        background-color: rgba(110, 69, 226, 0.15);
        color: var(--brand-purple-dark);
        box-shadow: 0 2px 4px rgba(110, 69, 226, 0.1);
    }
    
    /* 인용문 스타일 강화 */
    .entry-content blockquote {
        background-color: #f8f8fa;
        border-left: none;
        padding: 30px;
        margin: 35px 0;
        font-style: italic;
        font-size: 20px;
        color: #444;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        position: relative;
    }
    
    .entry-content blockquote::before {
        content: '"';
        position: absolute;
        top: 10px;
        left: 20px;
        font-size: 60px;
        color: var(--brand-purple-light);
        opacity: 0.2;
        font-family: Georgia, serif;
        line-height: 1;
    }
    
    .entry-content blockquote p {
        margin: 0;
        position: relative;
        z-index: 1;
        padding-left: 20px;
    }
    
    /* 목차 스타일 - 밑줄 제거 */
    .entry-content .toc,
    .entry-content .lwptoc,
    .entry-content .ez-toc-container,
    .entry-content #toc_container {
        background-color: #f8f8fa;
        border-radius: 12px;
        padding: 25px;
        margin: 30px 0;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        border: none;
    }
    
    .entry-content .toc a,
    .entry-content .lwptoc a,
    .entry-content .ez-toc-container a,
    .entry-content #toc_container a {
        text-decoration: none;
        background: none;
        padding: 0;
        border-bottom: none;
        color: #333;
        transition: color 0.2s ease;
    }
    
    .entry-content .toc a:hover,
    .entry-content .lwptoc a:hover,
    .entry-content .ez-toc-container a:hover,
    .entry-content #toc_container a:hover {
        color: var(--brand-purple);
        background: none;
        text-decoration: none;
        box-shadow: none;
    }
    
    /* 이미지 스타일 개선 */
    .entry-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 24px 0;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    /* 코드 블록 스타일 */
    .entry-content pre,
    .entry-content code {
        background-color: #f5f5f7;
        border-radius: 8px;
        padding: 15px;
        overflow-x: auto;
        border: 1px solid rgba(0, 0, 0, 0.05);
        font-family: 'Courier New', monospace;
    }
    
    .entry-content pre {
        margin: 25px 0;
    }
    
    .entry-content code {
        padding: 3px 5px;
        background-color: rgba(110, 69, 226, 0.08);
        color: var(--brand-purple-dark);
        border-radius: 4px;
        font-size: 0.9em;
    }
    
    /* 목록 스타일 개선 */
    .entry-content ul,
    .entry-content ol {
        margin: 0 0 24px 30px;
        padding-left: 20px;
    }
    
    .entry-content li {
        margin-bottom: 12px;
    }
    
    /* 표 스타일 */
    .entry-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 30px 0;
        font-size: 17px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .entry-content th {
        background-color: #f5f5f7;
        padding: 15px 18px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid #e5e5e5;
    }
    
    .entry-content td {
        padding: 12px 18px;
        border-bottom: 1px solid #e5e5e5;
    }
    
    .entry-content tr:last-child td {
        border-bottom: none;
    }
    
    .entry-content tr:nth-child(even) {
        background-color: #fafafa;
    }
    
    /* 푸터 스타일 */
    .entry-footer {
        margin-top: 60px;
        padding-top: 30px;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
    }
    
    .tags-links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 40px;
    }
    
    .tag-link {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        background-color: #f5f5f7;
        border-radius: 20px;
        font-size: 14px;
        color: #555;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .tag-link:hover {
        background-color: var(--brand-purple-ultra-light);
        transform: translateY(-2px);
        box-shadow: 0 3px 6px rgba(110, 69, 226, 0.15);
        color: var(--brand-purple);
        border-color: rgba(110, 69, 226, 0.2);
    }
    
    .tag-icon {
        fill: var(--brand-purple);
        margin-right: 6px;
        flex-shrink: 0;
    }
    
    /* 내비게이션 (썸네일 추가 및 레이아웃 개선) */
    .post-navigation {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
        gap: 20px;
    }
    
    .post-navigation a {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 15px;
        text-decoration: none;
        padding: 15px;
        border-radius: 16px;
        background-color: #f8f8fa;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
        min-height: 100px;
    }
    
    .post-navigation a:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        background-color: var(--brand-purple-ultra-light);
    }
    
    .nav-thumbnail {
        flex: 0 0 70px;
        height: 70px;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .nav-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-nav-thumbnail {
        width: 100%;
        height: 100%;
        background-color: #e8e8ed;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .nav-content {
        flex: 1;
        min-width: 0;
    }
    
    .nav-previous a {
        flex-direction: row;
        text-align: left;
    }
    
    .nav-next a {
        flex-direction: row-reverse;
        text-align: right;
    }
    
    .nav-subtitle {
        display: block;
        font-size: 13px;
        color: #6e6e73;
        margin-bottom: 6px;
        font-weight: 500;
    }
    
    .nav-title {
        font-size: 17px;
        font-weight: 600;
        color: #1d1d1f;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* 사이드바 스타일 - 세련된 디자인 */
    .sidebar-widget {
        margin-bottom: 35px;
        padding: 25px;
        background-color: #f8f8fa;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .sidebar-widget:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
    }
    
    .widget-title {
        font-size: 20px;
        font-weight: 600;
        margin: 0 0 22px;
        color: #1d1d1f;
        position: relative;
        padding-bottom: 12px;
    }
    
    .widget-title:after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, var(--brand-purple), var(--brand-purple-light));
        border-radius: 3px;
    }
    
    /* 관련 포스트 */
    .related-posts-list,
    .recent-posts-list,
    .categories-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .related-post-item {
        margin-bottom: 22px;
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .related-post-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .related-post-item:last-child {
        margin-bottom: 0;
    }
    
    .related-post-link {
        display: flex;
        gap: 15px;
        text-decoration: none;
        color: inherit;
        padding: 12px;
    }
    
    .related-post-image {
        flex: 0 0 70px;
        height: 70px;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .related-post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-thumbnail {
        width: 100%;
        height: 100%;
        background-color: #e8e8ed;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8e8e93;
        font-size: 20px;
    }
    
    .related-post-content {
        flex: 1;
        min-width: 0;
    }
    
    .related-post-title {
        font-size: 15px;
        font-weight: 500;
        margin: 0 0 8px;
        color: #1d1d1f;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .related-post-date {
        font-size: 13px;
        color: #6e6e73;
        display: flex;
        align-items: center;
    }
    
    .related-post-date:before {
        content: "•";
        display: inline-block;
        margin-right: 5px;
        color: var(--brand-purple);
    }
    
    /* 최신 포스트 */
    .recent-post-item {
        margin-bottom: 18px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease;
    }
    
    .recent-post-item:hover {
        transform: translateX(3px);
    }
    
    .recent-post-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .recent-post-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    .recent-post-title {
        font-size: 15px;
        font-weight: 500;
        margin: 0 0 8px;
        color: #1d1d1f;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .recent-post-date {
        font-size: 13px;
        color: #6e6e73;
        display: flex;
        align-items: center;
    }
    
    .recent-post-date:before {
        content: "•";
        display: inline-block;
        margin-right: 5px;
        color: var(--brand-purple);
    }
    
    /* 카테고리 */
    .categories-list li {
        margin-bottom: 14px;
        transition: transform 0.2s ease;
    }
    
    .categories-list li:hover {
        transform: translateX(3px);
    }
    
    .categories-list a {
        text-decoration: none;
        color: #1d1d1f;
        display: flex;
        justify-content: space-between;
        font-size: 15px;
        padding: 10px 15px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        transition: background-color 0.2s ease;
    }
    
    .categories-list a:hover {
        color: var(--brand-purple);
        background-color: var(--brand-purple-ultra-light);
    }
    
    .count {
        color: #6e6e73;
        background-color: #f5f5f7;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    /* 태그 클라우드 스타일 */
    .tags-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .tag-button {
        display: inline-block;
        padding: 8px 14px;
        background-color: #fff;
        border-radius: 20px;
        font-size: 14px;
        color: #1d1d1f;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
    }
    
    .tag-button:hover {
        background-color: var(--brand-purple);
        color: #fff;
        border-color: var(--brand-purple);
    }
    
    /* 인기 태그 (더 큰 폰트 사이즈) */
    .tag-button[data-count="10"],
    .tag-button[data-count="9"],
    .tag-button[data-count="8"],
    .tag-button[data-count="7"] {
        font-size: 15px;
        font-weight: 500;
        background-color: var(--brand-purple-ultra-light);
    }
    
    /* 반응형 스타일 */
    @media (max-width: 992px) {
        .content-sidebar-wrapper {
            flex-direction: column;
        }
        
        .sidebar {
            width: 100%;
            margin-top: 40px;
        }
        
        .sidebar-inner {
            position: static;
        }
        
        /* 태블릿에서 사이드바 두 열 레이아웃 */
        .sidebar-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .sidebar-widget {
            margin-bottom: 0;
        }
        
        /* 태그 클라우드는 전체 너비 */
        .sidebar-widget.tags-cloud {
            grid-column: span 2;
        }
    }
    
    @media (max-width: 768px) {
        .single-container {
            padding: 20px;
        }
        
        .entry-title {
            font-size: 32px;
        }
        
        .entry-content {
            font-size: 17px;
        }
        
        .entry-content h2 {
            font-size: 26px;
            padding: 16px 20px;
            border-radius: 10px;
        }
        
        .entry-content h3 {
            font-size: 22px;
        }
        
        /* 모바일에서 사이드바 한 열 레이아웃으로 돌아감 */
        .sidebar-inner {
            display: block;
        }
        
        .sidebar-widget {
            margin-bottom: 30px;
        }
        
        /* 내비게이션 모바일 스타일 */
        .post-navigation {
            flex-direction: column;
        }
        
        .nav-previous, .nav-next {
            width: 100%;
        }
    }
    
    /* 좋아요 버튼 스타일 */
    .post-likes-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 30px;
        margin: 0;
        height: auto;
        justify-content: center;
        background-color: var(--purple-ultra-light);
        border-radius: 10px;
        text-align: center;
    }
    
    .like-button {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px 25px;
        background-color: white;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        color: #444;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .like-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(110, 69, 226, 0.2);
    }
    
    .like-button.liked {
        background-color: var(--purple-base);
        color: white;
    }
    
    .like-icon {
        fill: #ccc;
        margin-right: 8px;
        transition: fill 0.3s ease, transform 0.3s ease;
    }
    
    .liked .like-icon {
        fill: white;
        transform: scale(1.2);
    }
    
    .like-button:hover .like-icon {
        fill: var(--purple-base);
    }
    
    .liked:hover .like-icon {
        fill: white;
    }
    
    .like-count {
        margin-right: 5px;
    }
    
    .like-message {
        margin-top: 10px;
        font-size: 14px;
        color: var(--purple-base);
        height: 20px;
    }
</style>

<script>
jQuery(document).ready(function($) {
    // 좋아요 버튼 클릭 이벤트
    $('#like-button').on('click', function() {
        var button = $(this);
        var postId = button.data('post-id');
        var nonce = button.data('nonce');
        var likeCount = button.find('.like-count');
        var message = $('.like-message');
        
        // AJAX 요청
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            data: {
                action: 'post_like',
                post_id: postId,
                nonce: nonce
            },
            success: function(response) {
                if(response.success) {
                    // 좋아요 수 업데이트
                    likeCount.text(response.data.likes);
                    
                    // 버튼 상태 변경
                    if(response.data.liked) {
                        button.addClass('liked');
                        message.text('감사합니다! 소중한 의견이 반영되었습니다.');
                    } else {
                        button.removeClass('liked');
                        message.text('좋아요가 취소되었습니다.');
                    }
                    
                    // 쿠키 설정
                    if(response.data.liked) {
                        document.cookie = 'post_liked_' + postId + '=1; path=/; max-age=31536000'; // 1년
                    } else {
                        document.cookie = 'post_liked_' + postId + '=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT';
                    }
                    
                    // 메시지 자동 숨김
                    setTimeout(function() {
                        message.text('');
                    }, 3000);
                } else {
                    message.text('오류가 발생했습니다. 다시 시도해주세요.');
                }
            },
            error: function() {
                message.text('서버 오류가 발생했습니다. 다시 시도해주세요.');
            }
        });
    });
});
</script>

<?php
get_footer();
?>
