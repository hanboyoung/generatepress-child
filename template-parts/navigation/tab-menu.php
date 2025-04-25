<?php
/**
 * 카테고리 태그 메뉴 템플릿
 * 
 * @package GeneratePress-child
 */

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

<style>
/* 탭 메뉴 스타일 */
.tab-navigation {
    margin-bottom: 30px;
}

.tab-container {
    background-color: #f5f5f7;
    border-radius: 8px;
    padding: 5px;
}

.tab-menu {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.tab-item {
    display: inline-block;
    padding: 8px 16px;
    font-size: 14px;
    color: #333;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.tab-item:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.tab-item.active {
    background-color: #fff;
    font-weight: 600;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.post-count {
    display: inline-block;
    margin-left: 5px;
    font-size: 13px;
    font-weight: 600;
    color: #6B46C1;
    background-color: rgba(107, 70, 193, 0.1);
    padding: 2px 6px;
    border-radius: 12px;
}

.tab-item.active .post-count {
    background-color: rgba(107, 70, 193, 0.15);
}

@media (max-width: 768px) {
    .tab-navigation {
        margin: 0 -20px 30px;
    }
    
    .tab-container {
        overflow-x: auto;
        border-radius: 0;
    }
    
    .tab-menu {
        flex-wrap: nowrap;
        padding: 5px 20px;
        width: max-content;
    }
    
    .tab-item {
        white-space: nowrap;
    }
}
</style> 