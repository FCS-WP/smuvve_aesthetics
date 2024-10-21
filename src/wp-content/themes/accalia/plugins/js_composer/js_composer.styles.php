<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'accalia_vc_get_css' ) ) {
	add_filter( 'accalia_filter_get_css', 'accalia_vc_get_css', 10, 4 );
	function accalia_vc_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
.vc_pagination-color-white.vc_pagination-style-outline .vc_pagination-item .vc_pagination-trigger,			
.vc_message_box p,
.vc_tta-style-classic .vc_tta-tab .vc_tta-title-text,
.vc_tta.vc_tta-accordion .vc_tta-panel-title .vc_tta-title-text {
	{$fonts['h1_font-family']}
}


CSS;
		}

		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Row and columns */
.scheme_self.vc_section,
.scheme_self.wpb_row,
.scheme_self.wpb_column > .vc_column-inner > .wpb_wrapper,
.scheme_self.wpb_text_column {
	color: {$colors['text']};
}
.scheme_self.vc_section[data-vc-full-width="true"],
.scheme_self.wpb_row[data-vc-full-width="true"],
.scheme_self.wpb_column > .vc_column-inner > .wpb_wrapper,
.scheme_self.wpb_text_column {
	background-color: {$colors['bg_color']};
}
.scheme_self.vc_row.vc_parallax[class*="scheme_"] .vc_parallax-inner:before {
	background-color: {$colors['bg_color_08']};
}

/* Accordion */
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon {
	color: {$colors['text']};
	background-color: {$colors['text_link']};
}
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon:before,
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon:after {
	border-color: {$colors['text']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a {
	color: {$colors['text_dark']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover {
	color: {$colors['text_link']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover .vc_tta-controls-icon {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon:before,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon:after {
	border-color: {$colors['text']};
}
.wpb-js-composer .vc_tta-color-white.vc_tta-style-classic .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::after, 
.wpb-js-composer .vc_tta-color-white.vc_tta-style-classic .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::before, 
.wpb-js-composer .vc_tta-color-white.vc_tta-style-classic .vc_tta-controls-icon::after, 
.wpb-js-composer .vc_tta-color-white.vc_tta-style-classic .vc_tta-controls-icon::before
 {
	border-color: {$colors['text']};
}

.scheme_alternative.wpb-js-composer .vc_tta-color-white.vc_tta-style-classic .vc_tta-controls-icon::before{
 border-color: {$colors['text_link3']}!important;
}

/* Tabs */
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab > a {
	color: {$colors['alter_bd_color']};
	background-color: {$colors['alter_bg_color']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab > a:hover,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab.vc_active > a {
	color: {$colors['alter_bd_color']};
	background-color: {$colors['text_link']};
}

/* Separator */
.vc_separator.vc_sep_color_grey .vc_sep_line {
	border-color: {$colors['bd_color']};
}

/* Progress bar */
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar {
	background-color: {$colors['alter_bg_color']};
}
.vc_progress_bar.vc_progress_bar_narrow.vc_progress-bar-color-bar_red .vc_single_bar .vc_bar {
	background-color: {$colors['alter_link']};
}
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label {
	color: {$colors['alter_bd_color']};
}
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label .vc_label_units {
	color: {$colors['alter_bd_color']};
}
.wpb-js-composer .vc_tta.vc_general.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
.wpb-js-composer .vc_tta.vc_general.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading {
	background-color: {$colors['alter_bg_color']};
}
.wpb-js-composer .vc_row-has-fill .vc_tta.vc_general.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
.wpb-js-composer .vc_row-has-fill .vc_tta.vc_general.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading {
	background-color: {$colors['bg_color']};
}

.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title>a,
.wpb-js-composer .vc_tta-color-white.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title>a {
    color: {$colors['alter_bd_color']};
}

.vc_progress_bar.vc_progress_bar_narrow[class*="vc_custom"] .vc_single_bar .vc_label,
.vc_progress_bar.vc_progress_bar_narrow[class*="vc_custom"] .vc_single_bar .vc_label .vc_label_units {
	color: {$colors['bg_color']};
}
.vc_progress_bar.vc_progress_bar_narrow[class*="vc_custom"] .vc_single_bar {
	background-color: {$colors['bg_color_02']};
}
.vc_pagination-color-white.vc_pagination-style-outline .vc_pagination-item .vc_pagination-trigger {
    background-color: #d3dce5;
      color: {$colors['alter_text']};
}
.vc_pagination-color-white.vc_pagination-style-outline .vc_pagination-item.vc_active .vc_pagination-trigger {
	background-color: {$colors['bg_color']};
	  color: {$colors['alter_text']};
}
CSS;
		}
		
		return $css;
	}
}
?>