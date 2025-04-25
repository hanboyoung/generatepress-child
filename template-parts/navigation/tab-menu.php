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
<div class="apple-tag-menu">
    <div class="tag-menu-container">
        <div class="tag-menu-list">
            <!-- 전체보기 태그 -->
            <a href="<?php echo esc_url(get_category_link($parent_category)); ?>" 
               class="tag-menu-item <?php echo ($current_category == $parent_category) ? 'active' : ''; ?>"
               data-category="all">
                전체보기
            </a>
            
            <?php foreach ($categories as $category) : 
                $is_active = ($current_category == $category->term_id) ? 'active' : '';
            ?>
                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                   class="tag-menu-item <?php echo esc_attr($is_active); ?>"
                   data-category="<?php echo esc_attr($category->slug); ?>">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
:root {
    --tag-bg-color: rgba(0, 0, 0, 0.05);
    --tag-bg-hover: rgba(0, 0, 0, 0.1);
    --tag-bg-active: #000;
    --tag-text-color: #1d1d1f;
    --tag-text-active: #fff;
    --container-width: 1200px;
}

.apple-tag-menu {
    margin: 40px 0;
}

.tag-menu-container {
    max-width: var(--container-width);
    margin: 0 auto;
    padding: 0 20px;
}

.tag-menu-list {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin: 0;
    padding: 0;
}

.tag-menu-item {
    display: inline-block;
    padding: 8px 16px;
    font-size: 15px;
    font-weight: 500;
    color: var(--tag-text-color);
    background-color: var(--tag-bg-color);
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.tag-menu-item:hover {
    background-color: var(--tag-bg-hover);
}

.tag-menu-item.active {
    color: var(--tag-text-active);
    background-color: var(--tag-bg-active);
}

@media (max-width: 768px) {
    .apple-tag-menu {
        margin: 30px 0;
        overflow-x: auto;
    }
    
    .tag-menu-list {
        flex-wrap: nowrap;
        padding-bottom: 10px;
    }
    
    .tag-menu-item {
        white-space: nowrap;
    }
}
</style> 