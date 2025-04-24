<?php
/**
 * ==================================================================================
 * ⚠️ 경고: 이 파일은 현재 프로덕션에서 사용 중인 완성된 버전입니다!
 * 🚫 직접 수정하지 마세요!
 * 
 * 최종 수정일: 2024-04-18
 * 버전: 1.0.0
 * 
 * 새로운 스토리 그리드 템플릿이 필요한 경우:
 * 1. 이 파일을 복사하여 새로운 이름으로 저장 (예: story-grid-custom.php)
 * 2. 새로운 파일에서 작업을 진행해 주세요
 * ==================================================================================
 */

/**
 * 미혼맘 스토리 그리드 템플릿
 */

// 현재 페이지 번호 가져오기
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// 화면 크기에 따른 포스트 수 조정 (3의 배수로 맞춤)
$posts_per_page = ($paged === 1) ? 6 : 6; // 첫 페이지와 이후 페이지 모두 6개로 통일

// 쿼리 아규먼트 설정
$query_args = array(
    'post_type' => 'post',
    'posts_per_page' => $posts_per_page,
    'paged' => $paged,
    'category_name' => 'mom-story',
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish'
);

// WP Query 실행
$stories_query = new WP_Query($query_args);

if ($stories_query->have_posts()) :
?>
<div class="grid-container">
    <div class="stories-grid">
        <?php 
        // Featured post section (첫 페이지에만 표시)
        if ($paged === 1 && $stories_query->have_posts()) : 
            $stories_query->the_post();
            $thumbnail_id = get_post_thumbnail_id();
            if ($thumbnail_id) :
                $thumbnail_metadata = wp_get_attachment_metadata($thumbnail_id);
                $is_portrait = false;
                
                if ($thumbnail_metadata) {
                    $width = $thumbnail_metadata['width'];
                    $height = $thumbnail_metadata['height'];
                    $ratio = $width / $height;
                    $is_portrait = $ratio < 1; // 세로 이미지 판단
                }
                
                $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'large');
                if ($thumbnail_url) :
        ?>
            <div class="featured-section">
                <article class="tile-3up has-gradient-secondary <?php echo $is_portrait ? 'portrait-image' : ''; ?>">
                    <a href="<?php the_permalink(); ?>" class="post-link">
                        <div class="viewport-picture">
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'story-thumb')); ?>" 
                                 alt="<?php the_title_attribute(); ?>"
                                 loading="lazy">
                        </div>
                    </a>
                    <div class="tile_gradient-secondary"></div>
                    <div class="tile_description">
                        <h3 class="title"><?php the_title(); ?></h3>
                    </div>
                </article>
            </div>
        <?php 
                endif;
            endif;
        endif;
        
        // Regular posts grid
        while ($stories_query->have_posts()) : $stories_query->the_post();
            // 첫 페이지의 첫 번째 글은 이미 featured section에 표시되었으므로 건너뜀
            if ($paged === 1 && $stories_query->current_post === 0) continue;
            
            $thumbnail_id = get_post_thumbnail_id();
            if (!$thumbnail_id) continue;
            
            $thumbnail_metadata = wp_get_attachment_metadata($thumbnail_id);
            $is_portrait = false;
            
            if ($thumbnail_metadata) {
                $width = $thumbnail_metadata['width'];
                $height = $thumbnail_metadata['height'];
                $ratio = $width / $height;
                $is_portrait = $ratio < 1; // 세로 이미지 판단
            }
            
            $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'large');
            if (!$thumbnail_url) continue;
        ?>
            <article class="tile-3up has-gradient-secondary <?php echo $is_portrait ? 'portrait-image' : ''; ?>">
                <a href="<?php the_permalink(); ?>" class="post-link">
                    <div class="viewport-picture">
                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'story-thumb')); ?>" 
                             alt="<?php the_title_attribute(); ?>"
                             loading="lazy">
                    </div>
                    <div class="tile_gradient-secondary"></div>
                    <div class="tile_description">
                        <h3 class="title"><?php the_title(); ?></h3>
                    </div>
                </a>
            </article>
        <?php endwhile; ?>
    </div>

    <?php 
    // 페이지네이션
    get_template_part('template-parts/pagination', null, array(
        'query' => $stories_query
    ));
    ?>
</div>

<?php
else:
    echo '<div class="grid-container"><p>아직 등록된 스토리가 없습니다.</p></div>';
endif;

wp_reset_postdata();
?> 

<style>
.tile-3up .viewport-picture {
    position: relative;
    width: 100%;
    aspect-ratio: 3/4;
    display: block;
    overflow: hidden;
}

.tile-3up .viewport-picture img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    object-position: center;
    transform-origin: center;
    transition: transform 0.5s cubic-bezier(0.42, 0, 0.58, 1);
}
</style>
?> 