<?php
/**
 * The style "default" of the Widgets
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.19
 */

$args = get_query_var('trx_addons_args_sc_layouts_widgets');

if (!empty($args['widgets']) && is_active_sidebar($args['widgets'])) { 
	ob_start();
	dynamic_sidebar($args['widgets']);
	$trx_addons_out = trim(ob_get_contents());
	ob_end_clean();
	if (trim(strip_tags($trx_addons_out)) != '') {
		$trx_addons_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $trx_addons_out);
		$trx_addons_need_columns = true;	//or check: strpos($trx_addons_out, 'columns_wrap')===false;
		if ($trx_addons_need_columns) {
			$args['columns'] = max(0, (int) $args['columns']);
			if ($args['columns'] == 0) $args['columns'] = min(6, max(1, substr_count($trx_addons_out, '<aside ')));
			if ((int) $args['columns'] > 1)
				$trx_addons_out = preg_replace("/class=\"widget /", "class=\"".esc_attr(trx_addons_get_column_class(1, $args['columns'])).' widget ', $trx_addons_out);
			else
				$trx_addons_need_columns = false;
		}
		?><div<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> class="sc_layouts_widgets widget_area<?php
				if (!empty($args['hide_on_tablet'])) echo ' hide_on_tablet';
				if (!empty($args['hide_on_mobile'])) echo ' hide_on_mobile';
				if (!empty($args['class'])) echo ' '.esc_attr($args['class']); 
			?>"<?php
			if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"'; ?>><?php
			?><div class="sc_layouts_widgets_inner widget_area_inner"><?php 
				if ($trx_addons_need_columns) {
					?><div class="sc_layouts_widgets_columns_wrap <?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?>"><?php
				}
				do_action( 'trx_addons_action_before_sidebar', $args['widgets'] );
				trx_addons_show_layout($trx_addons_out);
				do_action( 'trx_addons_action_after_sidebar', $args['widgets'] );
				if ($trx_addons_need_columns) {
					?></div><!-- /.sc_layouts_widgets_columns_wrap --><?php
				}
				?>
			</div><!-- /.sc_layouts_widgets_inner -->
		</div><!-- /.sc_layouts_widgets -->
		<?php
	}
}
?>