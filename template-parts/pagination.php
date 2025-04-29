<?php
/**
 * 커스텀 페이지네이션 템플릿 (최종 수정본)
 */

$query = isset($args['query']) ? $args['query'] : $GLOBALS['wp_query'];
$paged = $query->get('paged') ? $query->get('paged') : 1;
$max_pages = $query->max_num_pages;
?>

<?php if ($max_pages > 1) : ?>
<div class="custom-pagination">
    <div class="pagination-container">
        
        <!-- 이전 버튼 -->
        <?php if ($paged > 1) : ?>
            <a href="<?php echo esc_url(get_pagenum_link($paged - 1)); ?>" class="pagination-arrow prev">←</a>
        <?php else : ?>
            <span class="pagination-arrow prev disabled">←</span>
        <?php endif; ?>

        <!-- 페이지 숫자 -->
        <div class="pagination-numbers">
            <span class="current-page"><?php echo esc_html($paged); ?></span>
            <span class="page-separator">of</span>
            <span class="total-pages"><?php echo esc_html($max_pages); ?></span>
        </div>

        <!-- 다음 버튼 -->
        <?php if ($paged < $max_pages) : ?>
            <a href="<?php echo esc_url(get_pagenum_link($paged + 1)); ?>" class="pagination-arrow next">→</a>
        <?php else : ?>
            <span class="pagination-arrow next disabled">→</span>
        <?php endif; ?>

    </div> <!-- .pagination-container -->
</div> <!-- .custom-pagination -->
<?php endif; ?>

<style>
.custom-pagination {
    margin: 60px auto;
    text-align: center;
}

.pagination-container {
    display: flex;
    flex-direction: row; /* 가로 배치 */
    align-items: center;
    justify-content: center;
    background: #f8f8f8;
    padding: 20px 40px;
    border-radius: 12px;
    gap: 30px; /* 요소 간 거리 */
}

.pagination-arrow {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #f1f1f1;
    color: #333;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    text-decoration: none;
    transition: background 0.3s, color 0.3s;
}

.pagination-arrow:hover {
    background: #ddd;
}

.pagination-arrow.disabled {
    background: #f1f1f1;
    color: #ccc;
    pointer-events: none;
}

.pagination-numbers {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 22px;
    font-weight: bold;
    color: #333;
}

.pagination-numbers .current-page {
    padding: 6px 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
}

.pagination-numbers .page-separator,
.pagination-numbers .total-pages {
    font-weight: normal;
    color: #666;
}
</style>