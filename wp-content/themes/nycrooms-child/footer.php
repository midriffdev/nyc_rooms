<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package zakra
 */

?>

	<?php
	/**
	 * Hook - zakra_action_after_content.
	 *
	 * @hooked zakra_content_end - 10
	 * @hooked zakra_main_end - 15
	 */
	do_action( 'zakra_action_after_content' );
	?>

	<?php
	/**
	 * Hook - zakra_action_before_footer
	 *
	 * @hooked zakra_footer_start - 10
	 */
	do_action( 'zakra_action_before_footer' );
	?>

		<?php
		/**
		 * Hook - zakra_action_footer_widgets
		 *
		 * @hooked zakra_footer_widgets - 10
		 */
		do_action( 'zakra_action_footer_widgets' );
		?>

		<?php
		/**
		 * Hook - zakra_action_footer_bottom_bar
		 *
		 * @hooked zakra_footer_bottom_bar - 10
		 */
		do_action( 'zakra_action_footer_bottom_bar' );
		?>

	<?php
		/**
		 * Hook - zakra_action_after_footer
		 *
		 * @hooked zakra_footer_end - 10
		 * @hooked zakra_mobile_navigation - 15
		 * @hooked zakra_scroll_to_top - 20
		 */
		do_action( 'zakra_action_after_footer' );
	?>

<?php
/**
 * Hook - zakra_action_after
 *
 * @hooked zakra_page_end- 10
 */
do_action( 'zakra_action_after' );
?>

<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/jquery-migrate-3.1.0.min.js"></script>

<?php wp_footer(); ?>
<!-- Scripts
================================================== -->

<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/chosen.min.js"></script>
<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/magnific-popup.min.js"></script>
<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/owl.carousel.min.js"></script>
<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/rangeSlider.js"></script>
<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/sticky-kit.min.js"></script>
<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/slick.min.js"></script>
<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/masonry.min.js"></script>
<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/mmenu.min.js"></script>
<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/tooltips.min.js"></script>
<script type="text/javascript" src="http://localhost/nycrooms/wp-content/themes/nycrooms-child/scripts/custom.js"></script>



</body>
</html>
