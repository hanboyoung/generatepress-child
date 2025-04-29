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
<style>
/* 탭 메뉴 스타일 */
.category-tab-menu {
    margin-bottom: 40px;
    border-bottom: 1px solid var(--border-color, #eee);
}
.category-tab-menu .tab-menu-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.category-tab-menu .tab-menu-list {
    list-style: none;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 0;
    padding: 0;
}
.category-tab-menu .tab-menu-item {
    margin: 0;
}
.category-tab-menu .tab-menu-link {
    display: inline-block;
    padding: 12px 24px;
    color: var(--text-secondary, #666);
    text-decoration: none;
    border-radius: 6px 6px 0 0;
    transition: all 0.3s ease;
    background-color: transparent;
}
.category-tab-menu .tab-menu-item.active .tab-menu-link {
    color: var(--primary-color, #4A90E2);
    background-color: var(--background-secondary, #f8f9fa);
    font-weight: 600;
    border-bottom: none;
    pointer-events: none;
}
.category-tab-menu .tab-menu-link:hover {
    color: var(--primary-color, #4A90E2);
    background-color: var(--background-hover, #f0f2f5);
}
.category-tab-menu .post-count {
    display: inline-block;
    margin-left: 8px;
    font-size: 0.9em;
    color: var(--text-tertiary, #999);
    background-color: rgba(107, 70, 193, 0.1);
    padding: 2px 6px;
    border-radius: 12px;
}
.category-tab-menu .tab-menu-item.active .post-count {
    background-color: rgba(107, 70, 193, 0.15);
}
@media (max-width: 768px) {
    .category-tab-menu {
        margin: 0 -20px 30px;
        border-bottom: none;
    }
    .category-tab-menu .tab-menu-container {
        padding: 0 20px;
    }
    .category-tab-menu .tab-menu-list {
        justify-content: center;
    }
    .category-tab-menu .tab-menu-link {
        padding: 10px 16px;
        font-size: 14px;
    }
}
@media (max-width: 480px) {
    .category-tab-menu .tab-menu-list {
        flex-wrap: wrap;
    }
    .category-tab-menu .tab-menu-link {
        width: 100%;
        text-align: center;
    }
}
</style>
<!-- 탭 메뉴 -->
<nav class="category-tab-menu">
    <div class="tab-menu-container">
        <ul class="tab-menu-list">
            <!-- 전체보기 탭 -->
            <li class="tab-menu-item <?php echo ($current_category == $parent_category) ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(get_category_link($parent_category)); ?>" class="tab-menu-link">
                    전체보기 <span class="post-count"><?php echo get_category($parent_category)->count; ?></span>
                </a>
            </li>
            <?php foreach ($categories as $category) : 
                $is_active = ($current_category == $category->term_id) ? 'active' : '';
            ?>
                <li class="tab-menu-item <?php echo esc_attr($is_active); ?>">
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="tab-menu-link">
                        <?php echo esc_html($category->name); ?> <span class="post-count"><?php echo $category->count; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav> 
