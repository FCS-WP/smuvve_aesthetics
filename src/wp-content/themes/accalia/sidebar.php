<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

if (accalia_sidebar_present()) {
	ob_start();
	$accalia_sidebar_name = accalia_get_theme_option('sidebar_widgets');
	accalia_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($accalia_sidebar_name) ) {
		dynamic_sidebar($accalia_sidebar_name);
	}
	$accalia_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($accalia_out)) {
		$accalia_sidebar_position = accalia_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($accalia_sidebar_position); ?> widget_area<?php if (!accalia_is_inherit(accalia_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(accalia_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'accalia_action_before_sidebar' );
				accalia_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $accalia_out));
				do_action( 'accalia_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>