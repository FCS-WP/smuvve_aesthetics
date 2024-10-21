<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

// Header sidebar
$accalia_header_name = accalia_get_theme_option('header_widgets');
$accalia_header_present = !accalia_is_off($accalia_header_name) && is_active_sidebar($accalia_header_name);
if ($accalia_header_present) { 
	accalia_storage_set('current_sidebar', 'header');
	$accalia_header_wide = accalia_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($accalia_header_name) ) {
		dynamic_sidebar($accalia_header_name);
	}
	$accalia_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($accalia_widgets_output)) {
		$accalia_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $accalia_widgets_output);
		$accalia_need_columns = strpos($accalia_widgets_output, 'columns_wrap')===false;
		if ($accalia_need_columns) {
			$accalia_columns = max(0, (int) accalia_get_theme_option('header_columns'));
			if ($accalia_columns == 0) $accalia_columns = min(6, max(1, substr_count($accalia_widgets_output, '<aside ')));
			if ($accalia_columns > 1)
				$accalia_widgets_output = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($accalia_columns).' widget ', $accalia_widgets_output);
			else
				$accalia_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($accalia_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$accalia_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($accalia_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'accalia_action_before_sidebar' );
				accalia_show_layout($accalia_widgets_output);
				do_action( 'accalia_action_after_sidebar' );
				if ($accalia_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$accalia_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>