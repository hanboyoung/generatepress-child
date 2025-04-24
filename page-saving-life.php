<?php
/**
 * ==================================================================================
 * ⚠️ 경고: 이 파일은 현재 프로덕션에서 사용 중인 완성된 버전입니다!
 * 🚫 직접 수정하지 마세요!
 * 
 * 최종 수정일: 2024-04-18
 * 버전: 1.0.0
 * 
 * 새로운 페이지 템플릿이 필요한 경우:
 * 1. 이 파일을 복사하여 새로운 이름으로 저장 (예: page-custom.php)
 * 2. 새로운 파일에서 작업을 진행해 주세요
 * ==================================================================================
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
                <?php
                // 현재 페이지의 슬러그 가져오기
                $page_slug = get_post_field('post_name', get_post());
                
                // saving-life-guide 카테고리의 ID 가져오기
                $parent_category = get_category_by_slug('saving-life-guide');
                
                if ($parent_category) {
                    // 하위 카테고리 가져오기
                    $subcategories = get_categories(array(
                        'child_of' => $parent_category->term_id,
                        'hide_empty' => false
                    ));
                    
                    // 현재 선택된 카테고리 확인
                    $current_category = get_query_var('cat');
                    
                    if (!empty($subcategories)) {
                        echo '<div class="apple-tabs">';
                        echo '<ul class="apple-tabs-nav">';
                        
                        // 부모 카테고리 탭 추가
                        $parent_active = empty($current_category) ? ' active' : '';
                        echo '<li><a href="' . get_category_link($parent_category->term_id) . '" class="' . $parent_active . '">' . $parent_category->name . '</a></li>';
                        
                        // 하위 카테고리 탭 추가
                        foreach ($subcategories as $category) {
                            $active = ($current_category == $category->term_id) ? ' active' : '';
                            echo '<li><a href="' . get_category_link($category->term_id) . '" class="' . $active . '">' . $category->name . '</a></li>';
                        }
                        
                        echo '</ul>';
                        echo '</div>';
                    }
                }
                
                // 카드형 레이아웃 불러오기
                get_template_part('template-parts/category/style', 'card', array(
                    'category_slug' => 'saving-life-guide' // 영상편집 카테고리 슬러그 직접 지정
                ));
                ?>
            </div>
        </main>
    </div>
</div>

<?php get_footer(); ?> 