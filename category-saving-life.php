<?php
/**
 * 생활경제방 카테고리 아카이브 템플릿
 *
 * @package GeneratePress-child
 */

// 카테고리 스타일 로드
wp_enqueue_style('category-style', get_stylesheet_directory_uri() . '/assets/css/category.css', array(), '1.0.0');
wp_enqueue_style('list-style', get_stylesheet_directory_uri() . '/assets/css/list.css', array(), '1.0.0');

get_header(); ?>

<div id="page" class="site apple-newsroom">
    <?php
    // 현재 카테고리 정보 가져오기
    $current_category = get_queried_object();
    
    $is_saving_life_child = false;
    $saving_life_category = get_category_by_slug('saving-life');
    
    if ($saving_life_category) {
        if ($current_category->term_id == $saving_life_category->term_id) {
            $is_saving_life_child = true;
            $main_category = $saving_life_category;
        } else {
            $ancestors = get_ancestors($current_category->term_id, 'category');
            if (in_array($saving_life_category->term_id, $ancestors)) {
                $is_saving_life_child = true;
                $main_category = $saving_life_category;
            }
        }
    }
    ?>
    
    <!-- 카테고리 히어로 섹션 -->
    <section class="category-hero">
        <div class="container">
            <h1 class="category-title"><?php echo esc_html($current_category->name); ?></h1>
            <?php if ($current_category->description) : ?>
                <p class="category-description"><?php echo wp_kses_post($current_category->description); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                <?php
                // 탭 메뉴 표시
                get_template_part('template-parts/navigation/tab-menu', null, array(
                    'current_category' => $current_category->term_id,
                    'parent_category' => $main_category->term_id
                ));

                // 현재 페이지 번호 가져오기
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                
                // WP_Query 인수 설정 - 모든 페이지에서 5개의 포스트로 통일
                $args = array(
                    'cat' => $current_category->term_id,
                    'posts_per_page' => 5, // 한 페이지에 5개의 포스트로 통일
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'paged' => $paged
                );
                
                // 새로운 쿼리 실행
                $custom_query = new WP_Query($args);

                // 리스트형 레이아웃 불러오기
                get_template_part('template-parts/category/style', 'list', array(
                    'category_slug' => 'saving-life',
                    'custom_query' => $custom_query
                ));
                
                // 페이지네이션
                if ($custom_query->max_num_pages > 1) :
                    echo '<div class="pagination">';
                    echo paginate_links(array(
                        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'format' => '?paged=%#%',
                        'current' => max(1, $paged),
                        'total' => $custom_query->max_num_pages,
                        'prev_text' => '',
                        'next_text' => '',
                        'mid_size' => 2,
                        'end_size' => 1,
                    ));
                    echo '</div>';
                endif;

                // 쿼리 초기화
                wp_reset_postdata();
                ?>
            </div>
        </main>
    </div>
</div>

<style>
/* 카테고리 페이지 기본 스타일 개선 */
.category-meta {
    margin-bottom: 16px;
}

.category-label {
    display: inline-block;
    font-size: 16px;
    font-weight: 600;
    color: #6B46C1;
}

/* 컨테이너 스타일 */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* 카테고리 타이틀 개선 */
.category-title {
    font-size: 36px;
    margin-bottom: 16px;
    font-weight: 700;
    color: #1d1d1f;
}

.category-description {
    font-size: 18px; 
    line-height: 1.6;
    color: #6e6e73;
    max-width: 800px;
    margin-bottom: 30px;
}

/* 애플 스타일 적용 - 박스 제거하고 구분선 추가 */
.post-item {
    border: none;
    border-radius: 0;
    border-bottom: 1px solid #e6e6e6;
    margin-bottom: 0;
    padding: 30px 0;
}

.post-item:first-child {
    padding-top: 0;
}

.post-item:last-child {
    border-bottom: none;
}

/* 포스트 리스트 스타일 개선 */
.post-list {
    border-top: none;
    padding-top: 0;
}

.post-item + .post-item {
    margin-top: 0;
}

/* 포스트 제목 폰트 사이즈 증가 */
.post-title {
    font-size: 24px;
    line-height: 1.3;
    font-weight: 600;
    margin-bottom: 12px;
    color: #1d1d1f;
}

/* 포스트 날짜 스타일 */
.post-date {
    font-size: 16px;
    color: #6e6e73;
}

/* 태그 스타일 개선 */
.post-tags {
    margin-bottom: 12px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.post-tag {
    font-size: 14px;
    font-weight: 500;
    padding: 5px 12px;
    border-radius: 20px;
    background-color: var(--purple-ultra-light, #F6F2FF);
    color: var(--purple-base, #6E45E2);
}

/* 태그 추가 표시 */
.post-tag-more {
    font-size: 14px;
    font-weight: 500;
    padding: 5px 12px;
    border-radius: 20px;
    background-color: #f5f5f7;
    color: #6e6e73;
}

/* 포스트 썸네일 크기 조정 */
.post-thumbnail {
    width: 180px;
    height: 120px;
    margin-right: 24px;
    border-radius: 10px;
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* 포스트 링크 호버 효과 */
.post-link:hover .post-title {
    color: var(--purple-base, #6E45E2);
}

/* 페이지네이션 스타일 */
.pagination {
    border-top: 1px solid #e6e6e6;
    padding-top: 30px;
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

.pagination .page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin: 0 5px;
    font-size: 16px;
    font-weight: 500;
    text-decoration: none;
    color: #1d1d1f;
    background-color: #f5f5f7;
    transition: all 0.2s ease;
}

.pagination .page-numbers.current {
    background-color: var(--purple-base, #6E45E2);
    color: white;
}

.pagination .page-numbers:hover:not(.current) {
    background-color: var(--purple-ultra-light, #F6F2FF);
    color: var(--purple-base, #6E45E2);
}

/* 모바일 대응 */
@media (max-width: 768px) {
    .post-thumbnail {
        width: 120px;
        height: 90px;
        margin-right: 16px;
    }
    
    .post-title {
        font-size: 20px;
    }
    
    .post-date {
        font-size: 14px;
    }
    
    .post-item {
        padding: 24px 0;
    }
    
    .category-title {
        font-size: 28px;
    }
    
    .category-description {
        font-size: 16px;
    }
}
</style>

<?php get_footer(); ?> 