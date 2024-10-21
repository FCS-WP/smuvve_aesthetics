<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

$accalia_header_css = $accalia_header_image = '';
$accalia_header_video = accalia_get_header_video();
if (true || empty($accalia_header_video)) {
	$accalia_header_image = get_header_image();
	if (accalia_is_on(accalia_get_theme_option('header_image_override')) && apply_filters('accalia_filter_allow_override_header_image', true)) {
		if (is_category()) {
			if (($accalia_cat_img = accalia_get_category_image()) != '')
				$accalia_header_image = $accalia_cat_img;
		} else if (is_singular() || accalia_storage_isset('blog_archive')) {
			if (has_post_thumbnail()) {
				$accalia_header_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				if (is_array($accalia_header_image)) $accalia_header_image = $accalia_header_image[0];
			} else
				$accalia_header_image = '';
		}
	}
}

?><header class="top_panel top_panel_default<?php
					echo !empty($accalia_header_image) || !empty($accalia_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($accalia_header_video!='') echo ' with_bg_video';
					if ($accalia_header_image!='') echo ' '.esc_attr(accalia_add_inline_css_class('background-image: url('.esc_url($accalia_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (accalia_is_on(accalia_get_theme_option('header_fullheight'))) echo ' header_fullheight trx-stretch-height';
					?> scheme_<?php echo esc_attr(accalia_is_inherit(accalia_get_theme_option('header_scheme')) 
													? accalia_get_theme_option('color_scheme') 
													: accalia_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($accalia_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (accalia_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );


?></header>