<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('accalia_trx_addons_my_get_css')) {
	add_filter('accalia_filter_get_css', 'accalia_trx_addons_my_get_css', 10, 4);
	function accalia_trx_addons_my_get_css($css, $colors, $fonts, $scheme='') {


        if (isset($css['fonts']) && $fonts) {
            $css['fonts'] .= <<<CSS
            
.sc_price_item_price_before,
.trx_addons_audio_player .audio_author{
    {$fonts['p_font-family']}
}
.sc_events_item_start,
.sc_services_light .sc_services_item_number,
.sc_testimonials .sc_testimonials_item_content,
.wpb_text_column big,
.elementor-widget-text-editor big,
.sc_countdown .sc_countdown_label,
.sc_countdown_default .sc_countdown_digits, .sc_countdown_default .sc_countdown_separator,
.sc_skills_pie.sc_skills_compact_off .sc_skills_item_title,
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label,
.widget_area .post_item .post_info,
.widget .post_item .post_info {
	{$fonts['h1_font-family']}
}


CSS;
        }

		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS
.trx_addons_accent_bg {
    color: {$colors['bg_color']};
    background-color: {$colors['text_hover2']};
}
.trx_addons_tooltip {
    color: {$colors['text']};
    border-color: {$colors['text']};
}
.trx_addons_tooltip:before {
    background-color: {$colors['text_link2']};
}
.trx_addons_tooltip:after {
    border-top-color: {$colors['text_link2']};
}
ol[class*="trx_addons_list"],
ul[class*="trx_addons_list"] {
    color: {$colors['text_dark']};
}
ul.trx_addons_list_dot[class*="trx_addons_list"] > li:before {
    color: {$colors['text_hover2']};
}
ol[class*="trx_addons_list"] > li:before {
    color: {$colors['text_hover2']};
}
ul[class*="trx_addons_list"]>li:before {
}
.sc_button_icon {
    color: {$colors['text_dark']};
    background-color: {$colors['alter_bg_color']};
}
.sc_layouts_item_details_line1,
.sc_layouts_row_type_normal .sc_layouts_item a,
.scheme_self.sc_layouts_row_type_normal .sc_layouts_item a {
    color: {$colors['alter_text']};
}
.sc_layouts_row_type_normal .sc_layouts_column_align_right .sc_layouts_item + .sc_layouts_item:before {
    border-color: {$colors['bd_color']};
}
.sc_layouts_item_icon {
    color: {$colors['text_hover2']};
}

/* Menu */
.sc_layouts_menu_nav > li > a {
	color: {$colors['alter_text']};
}
.sc_layouts_menu_nav > li > a:hover,
.sc_layouts_menu_nav > li.sfHover > a {
	color: {$colors['text_hover2']} !important;
}
.sc_layouts_menu_nav > li.current-menu-item > a,
.sc_layouts_menu_nav > li.current-menu-parent > a,
.sc_layouts_menu_nav > li.current-menu-ancestor > a {
	color: {$colors['text_hover2']} !important;
}
.sc_layouts_menu_nav .menu-collapse > a:before {
	color: {$colors['alter_text']};
}
.sc_layouts_menu_nav .menu-collapse > a:after {
	background-color: {$colors['alter_bg_color']};
}
.sc_layouts_menu_nav .menu-collapse > a:hover:before {
	color: {$colors['text_hover2']};
}
.sc_layouts_menu_nav .menu-collapse > a:hover:after {
	background-color: {$colors['alter_bg_hover']};
}

/* Submenu */
.sc_layouts_menu_nav > li > ul:before,
.sc_layouts_menu_popup .sc_layouts_menu_nav,
.sc_layouts_menu_nav > li ul {
	background-color: {$colors['alter_bg_hover']};
}
.sc_layouts_menu_popup .sc_layouts_menu_nav > li > a,
.sc_layouts_menu_nav > li li > a {
	color: {$colors['alter_text']} !important;
}
.sc_layouts_menu_popup .sc_layouts_menu_nav > li > a:hover,
.sc_layouts_menu_popup .sc_layouts_menu_nav > li.sfHover > a,
.sc_layouts_menu_nav > li li > a:hover,
.sc_layouts_menu_nav > li li.sfHover > a {
	color: {$colors['bg_color']} !important;
	background-color: {$colors['text_hover2']};
}
.sc_layouts_menu_nav li[class*="columns-"] li.menu-item-has-children > a:hover,
.sc_layouts_menu_nav li[class*="columns-"] li.menu-item-has-children.sfHover > a {
	color: {$colors['bg_color']} !important;
	background-color: transparent;
}
.sc_layouts_menu_nav > li li[class*="icon-"]:before {
	color: {$colors['extra_hover']};
}
.sc_layouts_menu_nav > li li[class*="icon-"]:hover:before,
.sc_layouts_menu_nav > li li[class*="icon-"].shHover:before {
	color: {$colors['extra_hover']};
}
.sc_layouts_menu_nav > li li.current-menu-item > a,
.sc_layouts_menu_nav > li li.current-menu-parent > a,
.sc_layouts_menu_nav > li li.current-menu-ancestor > a {
	color: {$colors['text_hover2']} !important;
}
.sc_layouts_menu_nav > li li.current-menu-item:before,
.sc_layouts_menu_nav > li li.current-menu-parent:before,
.sc_layouts_menu_nav > li li.current-menu-ancestor:before {
	color: {$colors['text_hover2']} !important;
}
.sc_layouts_menu_nav > li li.current-menu-item > a:hover,
.sc_layouts_menu_nav > li li.current-menu-parent > a:hover,
.sc_layouts_menu_nav > li li.current-menu-ancestor > a:hover,
.sc_layouts_menu_nav > li li.current-menu-item.sfHover > a,
.sc_layouts_menu_nav > li li.current-menu-parent.sfHover > a,
.sc_layouts_menu_nav > li li.current-menu-ancestor.sfHover > a {
	color: {$colors['bg_color']} !important;
}
.socials_wrap .social_item .social_icon {
    background-color: {$colors['alter_bg_hover']};
}
.socials_wrap .social_item .social_icon,
.socials_wrap .social_item .social_icon i {
    color: {$colors['text_hover2']};
}
.socials_wrap .social_item:hover .social_icon,
.socials_wrap .social_item:hover .social_icon i {
    color: {$colors['bg_color']};
}
.socials_wrap .social_item:hover .social_icon {
     background-color: {$colors['text_hover2']};
}

.footer_wrap .custom_color .socials_wrap .social_item .social_icon{
    background-color: {$colors['alter_hover3']};
    color: {$colors['bg_color']};
}

.footer_wrap .socials_wrap .social_item .social_icon,
.scheme_self.footer_wrap .socials_wrap .social_item .social_icon {
    color: {$colors['text_hover']};
    background-color: {$colors['extra_bg_color_008']};
}
.footer_wrap .socials_wrap .social_item:hover .social_icon,
.scheme_self.footer_wrap .socials_wrap .social_item:hover .social_icon {
    color: {$colors['text_dark']};
    background-color: {$colors['text_hover']};
}
.sc_skills .sc_skills_total {
    color: {$colors['text']};
}
.sc_countdown_default .sc_countdown_digits span {
    color: {$colors['text_link']};
}
.sc_countdown_default .sc_countdown_separator {
    color: {$colors['bg_color_0']};
}
.sc_countdown .sc_countdown_label {
    color: {$colors['bg_color']};
}
.slider_swiper .slider_pagination_wrap .swiper-pagination-bullet,
.slider_swiper_outer .slider_pagination_wrap .swiper-pagination-bullet,
.swiper-pagination-custom .swiper-pagination-button,
.slider_swiper .swiper-pagination-bullet,
.slider_swiper_outer .swiper-pagination-bullet {
  background-color: #d3dce5;
}
.swiper-pagination-custom .swiper-pagination-button.swiper-pagination-button-active,
.slider_swiper .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active,
.slider_swiper_outer .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active,
.slider_swiper .slider_pagination_wrap .swiper-pagination-bullet:hover,
.slider_swiper_outer .slider_pagination_wrap .swiper-pagination-bullet:hover,
.slider_swiper .swiper-pagination-bullet.swiper-pagination-bullet-active,
.slider_swiper_outer .swiper-pagination-bullet.swiper-pagination-bullet-active {
  background-color: {$colors['bg_color']};
}
.slider_swiper .swiper-pagination-bullet:before,
.slider_swiper_outer .swiper-pagination-bullet:before {
  color: {$colors['alter_text']};
}
/* Price */
.sc_price_item {
	color: {$colors['text']};
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['alter_bg_color']};
}
.sc_price_item:hover {
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['alter_bg_color']};
}
.sc_price_item .sc_price_item_icon {
	color: {$colors['extra_link']};
}
.sc_price_item:hover .sc_price_item_icon {
	color: {$colors['extra_hover']};
}
.sc_price_item .sc_price_item_label {
	background-color: {$colors['extra_link']};
	color: {$colors['inverse_text']};
}
.sc_price_item:hover .sc_price_item_label {
	background-color: {$colors['extra_hover']};
	color: {$colors['inverse_text']};
}
.sc_price_item .sc_price_item_subtitle {
	color: {$colors['extra_dark']};
}
.sc_price_item:hover .sc_price_item_title,
.sc_price_item:hover .sc_price_item_title a,
.sc_price_item .sc_price_item_title,
.sc_price_item .sc_price_item_title a {
	color: {$colors['alter_dark']};
}
.sc_price_item:hover .sc_price_item_title a:hover {
	color: {$colors['text_link']};
}
.sc_price_item .sc_price_item_price {
	color: {$colors['alter_dark']};
}
.sc_price_item .sc_price_item_description,
.sc_price_item .sc_price_item_details {
	color: {$colors['text']};
}
.sc_price_item_price {
	background-color: {$colors['text_link']};
}
.sc_price_item_details ul li {
	border-color: {$colors['bd_color']};
}
.sc_item_subtitle {
	color: {$colors['text_hover2']};
}
.sc_services_default .sc_services_item {
	color: {$colors['text']};
    background-color: {$colors['bg_color']};
}
.sc_services_default .sc_services_item_subtitle a {
	color: {$colors['text_hover2']};
}
.sc_services_default .sc_services_item_title,
.sc_services_default .sc_services_item_title a {
	color: {$colors['alter_dark']};
}
.sc_services_default .sc_services_item_title a:hover {
	color: {$colors['text_hover2']};
}
.sc_services_list .sc_services_item_title,
.sc_services_list .sc_services_item_title a {
	color: {$colors['alter_text']};
}
.scheme_dark.sc_services_list .sc_services_item_title,
.scheme_dark.sc_services_list .sc_services_item_title a,
.scheme_alternative .sc_services_light .sc_services_item_number{
	color: {$colors['bg_color']};
}


.sc_services_list .sc_services_item_title a:hover {
	color: {$colors['text_hover2']};
}
.sc_services_default .sc_services_item_featured_left .sc_services_item_icon,
.sc_services_default .sc_services_item_featured_right .sc_services_item_icon,
.sc_services_list .sc_services_item_icon {
    color: {$colors['text']};
    background-color: {$colors['bg_color']};
}
.scheme_alternative .sc_services_list .sc_services_item_featured_left:hover .sc_services_item_icon,
.scheme_alternative .sc_services_list .sc_services_item_icon{
    background-color: {$colors['text_link']};
}
.sc_services_default .sc_services_item_featured_left:hover .sc_services_item_icon,
.sc_services_default .sc_services_item_featured_right:hover .sc_services_item_icon,
.sc_services_list .sc_services_item_featured_left:hover .sc_services_item_icon,
.sc_services_list .sc_services_item_featured_right:hover .sc_services_item_icon {
    color: {$colors['text']};
    background-color: {$colors['bg_color']};
}

h5.sc_item_title {
	color: {$colors['alter_dark']};
}
.scheme_dark .sc_item_subtitle {
	color: {$colors['text_hover2']};
}
.sc_testimonials_item_author_title {
	color: {$colors['text_dark']};
}
.sc_team_featured .sc_team_item {
    background-color: {$colors['alter_bg_color']};
}
.sc_services_light .sc_services_item_number {
    color: {$colors['alter_text']};
    background-color: {$colors['text_link']};
}

.elementor-element .sc_team_featured .sc_team_item,
.vc_row.vc_row-has-fill .sc_team_featured .sc_team_item {
    background-color: {$colors['bg_color']};
}
.sc_team .sc_team_item_thumb .sc_team_item_socials .social_item .social_icon {
    color: {$colors['bg_color']};
    background-color: {$colors['text_link2']};
}
.sc_team .sc_team_item_thumb .sc_team_item_socials .social_item:hover .social_icon {
    color: {$colors['bg_color']};
    background-color: {$colors['text_hover2']};
}
.sc_events_default_item_date {
    color: {$colors['text_hover2']};
}
.sc_events_default_item_time {
    color: {$colors['alter_light']};
}
.sc_events_default .sc_events_default_item_title,
.sc_events_default .sc_events_default_item_title a {
    color: {$colors['alter_bd_color']};
}
.sc_events_default .sc_events_default_item_title a:hover {
    color: {$colors['text_hover2']};
}
.sc_events_default .sc_events_item {
    background-color: {$colors['bg_color']};
}
.sc_events_default .sc_events_item + .sc_events_item {
    border-color: {$colors['bd_color']};
}
.sc_skills_pie.sc_skills_compact_off .sc_skills_item_title {
    color: {$colors['alter_text']};
}
.tooltipster-content {
    background-color: {$colors['alter_bg_color']};
}
.tooltipster-content a {
    color: {$colors['text_hover2']};
}
.tooltipster-content h6 {
    color: {$colors['alter_text']};
}
.sc_recent_news .post_item .post_date,
.sc_recent_news .post_item .post_date:hover {
    color: {$colors['text_link']};
}
.sc_recent_news .post_item:not(.post_layout_news-magazine ):not(.post_layout_news-excerpt ) .post_title,
.sc_recent_news .post_item:not(.post_layout_news-magazine):not(.post_layout_news-excerpt ) .post_title a {
    color: {$colors['bg_color']};
}
.sc_recent_news .post_item:not(.post_layout_news-magazine):not(.post_layout_news-excerpt ) .post_title a:hover,
.sc_recent_news .post_item .post_title a:hover {
    color: {$colors['text_link']};
}


CSS;
		}

		return $css;
	}
}
?>