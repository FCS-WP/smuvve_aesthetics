<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'accalia_elm_get_css' ) ) {
	add_filter( 'accalia_filter_get_css', 'accalia_elm_get_css', 10, 4 );
	function accalia_elm_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS

.box_view_html p {
    {$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}


CSS;
		}

		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Shape above and below rows */
.elementor-shape .elementor-shape-fill {
	fill: {$colors['bg_color']};
}

/* Divider */
.elementor-divider-separator {
	border-color: {$colors['bd_color']};
}

/* Elementor Home Styles */

/*Accordion*/

.elementor-accordion-item {
    background-color: {$colors['bg_color']};
}

.elementor-accordion-item h4 a {
    color: {$colors['alter_bd_color']};
}

h4.elementor-tab-title .elementor-accordion-icon-right {
	color: {$colors['text']};
	background-color: {$colors['text_link']};
}

.page_content_wrap .elementor-widget-text-editor a[href*='tel']:hover,
.page_content_wrap .elementor-widget-text-editor a[href*='mailto']:hover {
    color: {$colors['text_hover']}!important;
}

/*Hotspots*/

.elementor-page #powerTip {
    background-color: {$colors['bg_color']};
}

#powerTip.n:before {
    border-top-color: {$colors['bg_color']};
}
#powerTip.s:before {
    border-bottom-color: {$colors['bg_color']};
}
#powerTip.e:before {
    border-right-color: {$colors['bg_color']};
}
#powerTip.w:before {
border-left-color: {$colors['bg_color']};
}

.box_view_html {
background: {$colors['alter_bg_color']};
}

.box_view_html p {
color: {$colors['text_link3']};
}
.box_view_html p span {
    color: {$colors['text_hover2']};
}

CSS;
		}
		
		return $css;
	}
}

?>