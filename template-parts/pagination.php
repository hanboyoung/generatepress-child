<?php
/**
 * 페이지네이션 템플릿
 * 
 * 사용 방법:
 * get_template_part('template-parts/pagination', null, array(
 *     'query' => $custom_query, // WP_Query 객체
 *     'style' => 'minimal' // 스타일 (옵션)
 * ));
 */

// 전달받은 쿼리 확인
$query = isset($args['query']) ? $args['query'] : $GLOBALS['wp_query'];
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
?>

<div class="pagination-status">
    <?php if ($paged > 1) : ?>
        <a href="<?php echo get_pagenum_link($paged - 1); ?>" class="pagination-arrow prev">
            <span class="arrow-icon"></span>
        </a>
    <?php else : ?>
        <span class="pagination-arrow prev disabled">
            <span class="arrow-icon"></span>
        </span>
    <?php endif; ?>

    <div class="pagination-numbers">
        <span class="current-page"><?php echo $paged; ?></span>
        <span class="page-separator">of</span>
        <span class="total-pages"><?php echo $query->max_num_pages; ?></span>
    </div>

    <?php if ($paged < $query->max_num_pages) : ?>
        <a href="<?php echo get_pagenum_link($paged + 1); ?>" class="pagination-arrow next">
            <span class="arrow-icon"></span>
        </a>
    <?php else : ?>
        <span class="pagination-arrow next disabled">
            <span class="arrow-icon"></span>
        </span>
    <?php endif; ?>
</div> 