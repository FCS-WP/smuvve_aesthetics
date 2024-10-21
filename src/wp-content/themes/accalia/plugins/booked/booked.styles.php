<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('accalia_booked_get_css')) {
	add_filter('accalia_filter_get_css', 'accalia_booked_get_css', 10, 4);
	function accalia_booked_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS

.booked-calendar-wrap .booked-appt-list .timeslot .timeslot-people button,
body #booked-profile-page input[type="submit"],
body #booked-profile-page button,
body .booked-list-view input[type="submit"],
body .booked-list-view button,
body table.booked-calendar input[type="submit"],
body table.booked-calendar button,
body .booked-modal input[type="submit"],
body .booked-modal button {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}

body div.booked-calendar-wrap div.booked-calendar .bc-head .bc-row .bc-col .monthName,
body div.booked-calendar-wrap div.booked-calendar .bc-head .bc-row.days .bc-col,
.booked-calendar-wrap .booked-appt-list .timeslot .timeslot-time {
    {$fonts['h6_font-family']}
}

CSS;
		}
		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Calendar */
table.booked-calendar th .monthName a,
body div.booked-calendar-wrap div.booked-calendar .bc-head .bc-row .bc-col .monthName a {
	color: {$colors['extra_link']};
}
table.booked-calendar th .monthName a:hover,
body div.booked-calendar-wrap div.booked-calendar .bc-head .bc-row .bc-col .monthName a:hover {
	color: {$colors['extra_hover']};
}
.booked-calendar-wrap .booked-appt-list h2 {
	color: {$colors['text_dark']};
}
.booked-calendar-wrap .booked-appt-list .timeslot .timeslot-title {
	color: {$colors['text_link']};
}
.booked-calendar-wrap .booked-appt-list .timeslot .timeslot-time {
	color: {$colors['text_dark']};
}
.booked-calendar-wrap .booked-appt-list .timeslot .spots-available {
	color: {$colors['text']};
}

/* Form fields */
#booked-page-form {
	color: {$colors['text']};
	border-color: {$colors['bd_color']};
}

#booked-profile-page .booked-profile-header {
	background-color: {$colors['bg_color']} !important;
	border-color: transparent !important;
	color: {$colors['text']};
}
#booked-profile-page .booked-user h3 {
	color: {$colors['text_dark']};
}
#booked-profile-page .booked-profile-header .booked-logout-button:hover {
	color: {$colors['text_link']};
}

#booked-profile-page .booked-tabs {
	border-color: {$colors['alter_bd_color']} !important;
}

.booked-modal .bm-window p.booked-title-bar {
	background-color: {$colors['alter_dark']} !important;
}

.booked-calendarSwitcher.calendar,
.booked-calendarSwitcher.calendar select,
#booked-profile-page .booked-tabs {
	background-color: {$colors['alter_bg_color']} !important;
}
#booked-profile-page .booked-tabs li a {
	background-color: {$colors['extra_bg_hover']};
	color: {$colors['extra_dark']};
}
table.booked-calendar thead,
table.booked-calendar thead th,
table.booked-calendar tr.days,
table.booked-calendar tr.days th,
#booked-profile-page .booked-tabs li.active a,
#booked-profile-page .booked-tabs li.active a:hover,
#booked-profile-page .booked-tabs li a:hover {
	color: {$colors['extra_dark']} !important;
	background-color: {$colors['extra_bg_color']} !important;
}
body div.booked-calendar-wrap div.booked-calendar .bc-head,
body div.booked-calendar-wrap div.booked-calendar .bc-head .bc-row.top .bc-col,
body div.booked-calendar-wrap div.booked-calendar .bc-head .bc-row.days .bc-col {
    color: {$colors['extra_dark']} !important;
	background-color: {$colors['extra_bg_color']} !important;
}
body div.booked-calendar-wrap div.booked-calendar .bc-head .bc-row.days .bc-col + .bc-col {
  border-color: {$colors['extra_bd_color']} !important;
}
.scheme_alternative .booked-calendar-shortcode-wrap table.booked-calendar thead tr:not(.days) th{
    background-color: {$colors['text_link']} !important;
}
.scheme_alternative .booked-calendar-shortcode-wrap table.booked-calendar thead tr.days th{
    background-color: {$colors['extra_bd_color']} !important;
}
.scheme_alternative .booked-calendar-shortcode-wrap table.booked-calendar thead tr.days th{
    color: {$colors['text_dark']}!important;
}
.scheme_default table.booked-calendar thead th {
    border-color: {$colors['extra_bg_color']} !important;
}
table.booked-calendar tr.days,
table.booked-calendar tr.days th {
	border-color: {$colors['extra_bd_color']} !important;
}
table.booked-calendar thead th i {
	color: {$colors['extra_dark']} !important;
}


body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.entryBlock,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col.active .date,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col.today .date,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col.today:hover .date span {
	color: {$colors['text_link3']};
	background-color: {$colors['text_link']};
}

body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col:hover .date span{
	color: {$colors['inverse_hover']} !important;
}

body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col:hover .date,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col.today .date:hover{
	color: {$colors['inverse_hover']} !important;
	background-color: {$colors['text_link_blend']} !important;
}
table.booked-calendar td:hover .date span {
	color: {$colors['text_dark']} !important;
}
table.booked-calendar td.today:hover .date span {
	background-color: {$colors['text_link']} !important;
	color: {$colors['inverse_link']} !important;
}
#booked-profile-page .booked-tab-content {
	background-color: {$colors['bg_color']};
	border-color: {$colors['alter_bd_color']};
}
body table.booked-calendar td:first-child,
table.booked-calendar td,
table.booked-calendar td+td,
 
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col {
	border-color: {$colors['bd_color']};
}

body .booked-modal .bm-window .booked-scrollable{
	background-color: {$colors['bg_color']};
}

CSS;
		}

		return $css;
	}
}
?>