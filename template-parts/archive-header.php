<?php
/**
 * 아카이브 헤더 템플릿
 */
?>
<header class="archive-header">
    <div class="archive-header__content">
        <h1 class="archive-title">
            <?php
            if (is_category()) {
                single_cat_title();
            } elseif (is_tag()) {
                single_tag_title();
            } elseif (is_author()) {
                the_author();
            } elseif (is_date()) {
                if (is_year()) {
                    echo get_the_date('Y년');
                } elseif (is_month()) {
                    echo get_the_date('Y년 n월');
                } elseif (is_day()) {
                    echo get_the_date('Y년 n월 j일');
                }
            }
            ?>
        </h1>
        
        <?php
        // 설명 표시
        $description = '';
        if (is_category()) {
            $description = category_description();
        } elseif (is_tag()) {
            $description = tag_description();
        }
        if ($description) : ?>
            <div class="archive-description">
                <?php echo $description; ?>
            </div>
        <?php endif; ?>

        <?php if (is_category() || is_tag()) : ?>
            <div class="view-options">
                <button class="view-option" data-style="card">
                    <span class="dashicons dashicons-grid-view"></span>
                </button>
                <button class="view-option" data-style="list">
                    <span class="dashicons dashicons-list-view"></span>
                </button>
                <button class="view-option" data-style="image">
                    <span class="dashicons dashicons-format-gallery"></span>
                </button>
            </div>
        <?php endif; ?>
    </div>
</header> 