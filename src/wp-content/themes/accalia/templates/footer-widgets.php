<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0.10
 */

// Footer sidebar
$accalia_footer_name = accalia_get_theme_option('footer_widgets');
$accalia_footer_present = !accalia_is_off($accalia_footer_name) && is_active_sidebar($accalia_footer_name);
if ($accalia_footer_present) { 
	accalia_storage_set('current_sidebar', 'footer');
	$accalia_footer_wide = accalia_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($accalia_footer_name) ) {
		dynamic_sidebar($accalia_footer_name);
	}
	$accalia_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($accalia_out)) {
		$accalia_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $accalia_out);
		$accalia_need_columns = true;	//or check: strpos($accalia_out, 'columns_wrap')===false;
		if ($accalia_need_columns) {
			$accalia_columns = max(0, (int) accalia_get_theme_option('footer_columns'));
			if ($accalia_columns == 0) $accalia_columns = min(4, max(1, substr_count($accalia_out, '<aside ')));
			if ($accalia_columns > 1)
				$accalia_out = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($accalia_columns).' widget ', $accalia_out);
			else
				$accalia_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($accalia_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row  sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$accalia_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($accalia_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'accalia_action_before_sidebar' );
				accalia_show_layout($accalia_out);
				do_action( 'accalia_action_after_sidebar' );
				if ($accalia_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$accalia_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>