<?php
/**
 * 깔끔한 Footer 템플릿
 *
 * @package GeneratePress-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // 직접 접근 방지
}
?>

	</div><!-- #content -->
</div><!-- #page -->

<footer id="colophon" class="site-footer">
	<div class="container">
		<p class="footer-text">&copy; <?php echo date('Y'); ?> Han Bo Young. All rights reserved.</p>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>