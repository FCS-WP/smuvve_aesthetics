<?php
/**
 * The template to show mobile menu
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr(accalia_get_theme_option('menu_mobile_fullscreen') > 0 ? 'fullscreen' : 'narrow'); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close icon-cancel"></a><?php

		// Logo
		set_query_var('accalia_logo_args', array('type' => 'inverse'));
		get_template_part( 'templates/header-logo' );
		set_query_var('accalia_logo_args', array());

		// Mobile menu
		$accalia_menu_mobile = accalia_get_nav_menu('menu_mobile');
		if (empty($accalia_menu_mobile)) {
			$accalia_menu_mobile = apply_filters('accalia_filter_get_mobile_menu', '');
			if (empty($accalia_menu_mobile)) $accalia_menu_mobile = accalia_get_nav_menu('menu_main');
			if (empty($accalia_menu_mobile)) $accalia_menu_mobile = accalia_get_nav_menu();
		}
		if (!empty($accalia_menu_mobile)) {
			if (!empty($accalia_menu_mobile))
				$accalia_menu_mobile = str_replace(
					array('menu_main', 'id="menu-', 'sc_layouts_menu_nav', 'sc_layouts_hide_on_mobile', 'hide_on_mobile'),
					array('menu_mobile', 'id="menu_mobile-', '', '', ''),
					$accalia_menu_mobile
					);
			if (strpos($accalia_menu_mobile, '<nav ')===false)
				$accalia_menu_mobile = sprintf('<nav class="menu_mobile_nav_area">%s</nav>', $accalia_menu_mobile);
			accalia_show_layout(apply_filters('accalia_filter_menu_mobile_layout', $accalia_menu_mobile));
		}

		// Search field
		do_action('accalia_action_search', 'normal', 'search_mobile', false);
		
		?>
	</div>
</div>
