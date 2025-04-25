<?php
/**
 * 카테고리 태그 메뉴 템플릿
 * 
 * @package GeneratePress-child
 */

// 현재 URL 체크 - 카테고리 페이지에서만 적용
if (!is_category()) {
    return;
}

$current_category = isset($args['current_category']) ? $args['current_category'] : '';
$parent_category = isset($args['parent_category']) ? $args['parent_category'] : '';

// 상위 카테고리의 하위 카테고리들 가져오기
$categories = get_categories(array(
    'parent' => $parent_category,
    'hide_empty' => true,
));

?>
<!-- 탭 메뉴 -->
<div class="tab-navigation">
    <div class="tab-container">
        <div class="tab-menu">
            <!-- 전체보기 탭 -->
            <a href="<?php echo esc_url(get_category_link($parent_category)); ?>" 
               class="tab-item <?php echo ($current_category == $parent_category) ? 'active' : ''; ?>">
                전체보기
                <?php $post_count = get_category($parent_category)->count; ?>
                <span class="post-count"><?php echo $post_count; ?></span>
            </a>
            
            <?php foreach ($categories as $category) : 
                $is_active = ($current_category == $category->term_id) ? 'active' : '';
            ?>
                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                   class="tab-item <?php echo esc_attr($is_active); ?>">
                    <?php echo esc_html($category->name); ?>
                    <span class="post-count"><?php echo $category->count; ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div> 