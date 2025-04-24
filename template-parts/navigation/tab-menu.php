<?php
/**
 * 카테고리 탭 메뉴 템플릿
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

if (!empty($categories)) : ?>
<div class="category-tab-menu">
    <div class="tab-menu-container">
        <ul class="tab-menu-list">
            <?php foreach ($categories as $category) : 
                $is_active = ($current_category === $category-saving-life-guide) ? 'active' : '';
            ?>
                <li class="tab-menu-item <?php echo esc_attr($is_active); ?>">
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                       class="tab-menu-link"
                       data-category="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                        <span class="post-count"><?php echo esc_html($category->count); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?> 