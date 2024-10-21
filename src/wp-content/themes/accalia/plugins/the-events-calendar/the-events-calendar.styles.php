<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'accalia_tribe_events_get_css' ) ) {
	add_filter( 'accalia_filter_get_css', 'accalia_tribe_events_get_css', 10, 4 );
	function accalia_tribe_events_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
			
.tribe-events-list .tribe-events-list-event-title {
	{$fonts['h3_font-family']}
}

#tribe-events .tribe-events-button,
.tribe-events-button,
.tribe-events-cal-links a,
.tribe-events-sub-nav li a {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}
#tribe-bar-form button, #tribe-bar-form a,
.tribe-events-read-more {
	{$fonts['button_font-family']}
	{$fonts['button_letter-spacing']}
}
.tribe-events-list .tribe-events-list-separator-month,
.tribe-events-calendar thead th,
.tribe-events-schedule, .tribe-events-schedule h2 {
	{$fonts['h5_font-family']}
}
#tribe-bar-form input, #tribe-events-content.tribe-events-month,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title,
#tribe-mobile-container .type-tribe_events,
.tribe-events-list-widget ol li .tribe-event-title {
	{$fonts['p_font-family']}
}


/* Updated Calendar Designs Styles */
.tribe-events *,
.tribe-events p {
	{$fonts['p_font-family']}
	{$fonts['p_line-height']}
	{$fonts['p_text-decoration']}
	{$fonts['p_letter-spacing']}
}
.tribe-common .tribe-common-h1,
.tribe-common .tribe-common-h1 * {
	{$fonts['h1_font-family']}
	{$fonts['h1_font-style']}
	{$fonts['h1_line-height']}
	{$fonts['h1_font-weight']}
	{$fonts['h1_text-decoration']}
	{$fonts['h1_text-transform']}
	{$fonts['h1_letter-spacing']}
}
.tribe-common .tribe-common-h2,
.tribe-common .tribe-common-h2 * {
	{$fonts['h2_font-family']}
	{$fonts['h2_font-style']}
	{$fonts['h2_line-height']}
	{$fonts['h2_font-weight']}
	{$fonts['h2_text-decoration']}
	{$fonts['h2_text-transform']}
	{$fonts['h2_letter-spacing']}
}
.tribe-common .tribe-common-h3,
.tribe-common .tribe-common-h3 * {
	{$fonts['h3_font-family']}
	{$fonts['h3_font-style']}
	{$fonts['h3_line-height']}
	{$fonts['h3_font-weight']}
	{$fonts['h3_text-decoration']}
	{$fonts['h3_text-transform']}
	{$fonts['h3_letter-spacing']}
}
.tribe-common .tribe-common-h4,
.tribe-common .tribe-common-h4 * {
	{$fonts['h4_font-family']}
	{$fonts['h4_font-style']}
	{$fonts['h4_line-height']}
	{$fonts['h4_font-weight']}
	{$fonts['h4_text-decoration']}
	{$fonts['h4_text-transform']}
	{$fonts['h4_letter-spacing']}
}
.tribe-events-calendar-month .tribe-events-calendar-month__day-date .tribe-events-calendar-month__day-date-daynum,
.tribe-events-calendar-month .tribe-events-calendar-month__day-date .tribe-events-calendar-month__day-date-daynum *,
.tribe-events .tribe-events-header .tribe-events-c-top-bar__datepicker-button,
.tribe-events .tribe-events-header .tribe-events-c-top-bar__datepicker-button *,
.tribe-common .tribe-common-h5,
.tribe-common .tribe-common-h5 * {
	{$fonts['h5_font-family']}
	{$fonts['h5_font-style']}
	{$fonts['h5_line-height']}
	{$fonts['h5_font-weight']}
	{$fonts['h5_text-decoration']}
	{$fonts['h5_text-transform']}
	{$fonts['h5_letter-spacing']}
}
.tribe-common .tribe-common-h6,
.tribe-common .tribe-common-h7,
.tribe-common .tribe-common-h8,
.tribe-common .tribe-common-h6 *,
.tribe-common .tribe-common-h7 *,
.tribe-common .tribe-common-h8 *  {
	{$fonts['h6_font-family']}
	{$fonts['h6_font-style']}
	{$fonts['h6_line-height']}
	{$fonts['h6_font-weight']}
	{$fonts['h6_text-decoration']}
	{$fonts['h6_text-transform']}
	{$fonts['h6_letter-spacing']}
}

.tribe-events .tribe-events-c-ical__link {
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

			
			$rad = accalia_get_border_radius();
			$css['fonts'] .= <<<CSS

#tribe-bar-form .tribe-bar-submit input[type="submit"], #tribe-bar-form button, #tribe-bar-form a,
#tribe-events .tribe-events-button,
#tribe-bar-views .tribe-bar-views-list,
.tribe-events-button,
.tribe-events-cal-links a,
.tribe-events-sub-nav li a {
	-webkit-border-radius: {$rad};
	    -ms-border-radius: {$rad};
			border-radius: {$rad};
}


/* Updated Calendar Designs Styles */
.tooltipster-base.tribe-events-tooltip-theme {
	-webkit-border-radius: {$rad};
	    -ms-border-radius: {$rad};
			border-radius: {$rad};
}
.tribe-events .tribe-events-c-ical__link {
	-webkit-border-radius: {$rad};
	    -ms-border-radius: {$rad};
			border-radius: {$rad};
}

CSS;
		}


		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Filters bar */
#tribe-bar-form {
	color: {$colors['text_dark']};
}
#tribe-bar-form input[type="text"] {
	color: {$colors['text_dark']};
	border-color: {$colors['text_dark']};
}
.tribe-bar-views-list {
	background-color: {$colors['text_link']};
}

.datepicker thead tr:first-child th:hover, .datepicker tfoot tr th:hover {
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}

/* Content */
.tribe-events-calendar thead th {
	color: {$colors['bg_color']};
	background: {$colors['text_dark']} !important;
	border-color: {$colors['text_dark']} !important;
}
.tribe-events-calendar thead th + th:before {
	background: {$colors['bg_color']};
}
#tribe-events-content .tribe-events-calendar td {
	border-color: {$colors['bd_color']} !important;
}
.tribe-events-calendar td div[id*="tribe-events-daynum-"],
.tribe-events-calendar td div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_dark']};
}
.tribe-events-calendar td.tribe-events-othermonth {
	color: {$colors['alter_light']};
	background: {$colors['alter_bg_color']} !important;
}
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"] > a {
	color: {$colors['alter_light']};
}
.tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_light']};
}
.tribe-events-calendar td.tribe-events-present:before {
	border-color: {$colors['text_link']};
}
.tribe-events-calendar .tribe-events-has-events:after {
	background-color: {$colors['text']};
}
.tribe-events-calendar .mobile-active.tribe-events-has-events:after {
	background-color: {$colors['bg_color']};
}
#tribe-events-content .tribe-events-calendar td,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a {
	color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a:hover {
	color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active,
#tribe-events-content .tribe-events-calendar td.mobile-active:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active div[id*="tribe-events-daynum-"] {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*="tribe-events-daynum-"] a,
.tribe-events-calendar .mobile-active div[id*="tribe-events-daynum-"] a {
	background-color: transparent;
	color: {$colors['bg_color']};
}

/* Tooltip */
.recurring-info-tooltip,
.tribe-events-calendar .tribe-events-tooltip,
.tribe-events-week .tribe-events-tooltip,
.tribe-events-tooltip .tribe-events-arrow {
	color: {$colors['alter_text']};
	background: {$colors['alter_bg_color']};
}
#tribe-events-content .tribe-events-tooltip h3,
#tribe-events-content .tribe-events-tooltip h4 { 
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}
.tribe-events-tooltip .tribe-event-duration {
	color: {$colors['text_light']};
}


/* Events list */
.tribe-events-list-separator-month {
	color: {$colors['text_dark']};
}
.tribe-events-list-separator-month:after {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .type-tribe_events + .type-tribe_events,
.tribe-events-day .tribe-events-day-time-slot + .tribe-events-day-time-slot + .tribe-events-day-time-slot {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .tribe-events-event-cost span {
	color: {$colors['bg_color']};
	border-color: {$colors['text_dark']};
	background: {$colors['text_dark']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['alter_bg_color']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a {
	color: {$colors['alter_link']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a:hover {
	color: {$colors['alter_hover']};
}
.tribe-mobile .tribe-events-list .tribe-events-venue-details {
	border-color: {$colors['alter_bd_color']};
}

/* Events day */
.tribe-events-day .tribe-events-day-time-slot h5 {
	color: {$colors['bg_color']};
	background: {$colors['text_dark']};
}

/* Single Event */
.single-tribe_events .tribe-events-venue-map {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_hover']};
}
.single-tribe_events .tribe-events-schedule .tribe-events-cost {
	color: {$colors['text_dark']};
}
.single-tribe_events .type-tribe_events {
	border-color: {$colors['bd_color']};
}


/* Updated Calendar Designs Styles */
.tribe-events .tribe-events-calendar-month__day-cell,
.tribe-events .tribe-events-calendar-month__day-cell:hover,
.tooltipster-base.tribe-events-tooltip-theme .tooltipster-content,
.tribe-events .tribe-events-c-top-bar__nav li,
.tribe-events .tribe-events-c-top-bar__nav li:hover,
.tribe-events .tribe-events-c-top-bar__nav li button,
.tribe-events .tribe-events-c-top-bar__nav li button:hover,
.tribe-events .tribe-events-c-top-bar__nav li button:focus,
.tribe-events .tribe-events-c-nav__list li,
.tribe-events .tribe-events-c-nav__list li:hover,
.tribe-events .tribe-events-c-nav__list li button,
.tribe-events .tribe-events-c-nav__list li button:hover,
.tribe-events .tribe-events-c-nav__list li button:focus,
.tribe-events .tribe-events-header .datepicker th,
.tribe-events .tribe-events-header .datepicker th:hover,
.tribe-events .tribe-events-header .datepicker td,
.tribe-events .tribe-events-header .datepicker td:hover,
.tribe-events .tribe-events-header .tribe-events-c-top-bar__datepicker-button:hover,
.tribe-events .tribe-events-header .tribe-events-c-top-bar__datepicker-button:focus,
.tribe-events .tribe-events-header .tribe-events-c-top-bar__datepicker-button {
	background: transparent !important;
}
.tribe-events .tribe-events-calendar-month__mobile-events-icon--event,
.tribe-events .tribe-events-c-view-selector__button::before,
.tribe-events .datepicker .day.active,
.tribe-events .datepicker .day.active.focused,
.tribe-events .datepicker .day.active:focus,
.tribe-events .datepicker .day.active:hover,
.tribe-events .datepicker .month.active,
.tribe-events .datepicker .month.active.focused,
.tribe-events .datepicker .month.active:focus,
.tribe-events .datepicker .month.active:hover,
.tribe-events .datepicker .year.active,
.tribe-events .datepicker .year.active.focused,
.tribe-events .datepicker .year.active:focus,
.tribe-events .datepicker .year.active:hover {
	background-color: {$colors['text_link']} !important;
}
.tribe-events .tribe-events-calendar-month__day-cell--selected .tribe-events-calendar-month__day-date,
.tribe-events .tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-date,
.tribe-events .tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-date-link {
	color: {$colors['text_link']};
}
.tribe-events .tribe-events-calendar-month__multiday-event-bar-inner {
	background-color: {$colors['alter_bg_color']};
}


.tribe-events .tribe-events-c-ical__link:hover .tribe-events-c-ical__link-icon-svg path {
    stroke: {$colors['inverse_hover']};
}

.tribe-common .tribe-common-anchor-thin-alt:focus,
.tribe-common .tribe-common-anchor-thin-alt:hover {
	color: {$colors['alter_link3']};
}

.tribe-common-c-btn-border.tribe-events-c-subscribe-dropdown__button {
    color: {$colors['text_link3']};
    background-color: {$colors['text_link']};
    border-color: {$colors['text_link']};
}
.tribe-common-c-btn-border.tribe-events-c-subscribe-dropdown__button button,
.tribe-common-c-btn-border.tribe-events-c-subscribe-dropdown__button svg {
    color: inherit !important;
    background: transparent !important;
}
.tribe-common-c-btn-border.tribe-events-c-subscribe-dropdown__button:focus-within,
.tribe-common-c-btn-border.tribe-events-c-subscribe-dropdown__button:hover,
.tribe-common-c-btn-border.tribe-events-c-subscribe-dropdown__button:focus,
.tribe-common-c-btn-border.tribe-events-c-subscribe-dropdown__button.tribe-events-c-subscribe-dropdown__button--active {
    color: {$colors['text_link3']};
    background-color: {$colors['text_hover']};
    border-color: {$colors['text_hover']};
}

/*Featured*/
.tribe-common--breakpoint-medium.tribe-events .tribe-events-calendar-list__event-datetime-featured-text,
.tribe-common--breakpoint-medium.tribe-events .tribe-events-calendar-day__event-datetime-featured-text {
    color: {$colors['alter_link']};
}
.tribe-events .tribe-events-calendar-list__event-row--featured .tribe-events-calendar-list__event-date-tag-datetime::after,
.tribe-events .tribe-events-calendar-day__event--featured::after {
    background-color: {$colors['alter_link']};
}

.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-description,
.tribe-common .tribe-events-calendar-list__event-description p,
.tribe-common .tribe-events-calendar-day__event-description p{
	color: {$colors['text']};
}

.tribe-events .tribe-events-calendar-month__day-date-daynum,
.tribe-common a:not(.tribe-common-anchor--unstyle),
.tribe-common a:not(.tribe-common-anchor--unstyle):visited,
.tribe-events .tribe-events-c-nav__today,
.tribe-events .tribe-events-calendar-day__type-separator > span,
.tribe-events .tribe-events-calendar-list__month-separator time,
.tribe-events .tribe-events-calendar-list__event-date-tag-datetime > span,
.tribe-events .tribe-events-calendar-month-mobile-events__mobile-event-title-link:visited,
.tribe-events .tribe-events-calendar-month__day-date-link,
.tribe-events .tribe-events-calendar-list__event-venue,
.tribe-events .tribe-events-calendar-day__event-venue,
.tribe-events .tribe-events-calendar-day__event-datetime,
.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-datetime,
.tribe-events .tribe-events-calendar-list__event-datetime,
.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-title a,
.tribe-events .datepicker .month, 
.tribe-events .datepicker .year,
.tribe-events .datepicker .datepicker-switch,
.tribe-events .datepicker .day, 
.tribe-events .datepicker .dow,
.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-title-link,
.tribe-events .tribe-events-calendar-list__event-title-link,
.tribe-events .tribe-events-calendar-day__event-title-link{
	color: {$colors['text_dark']};
}

.tribe-common a:not(.tribe-common-anchor--unstyle):active, 
.tribe-common a:not(.tribe-common-anchor--unstyle):focus, 
.tribe-common a:not(.tribe-common-anchor--unstyle):hover,
.tribe-events-event-meta a,
.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-title-link:hover,
.tribe-events .tribe-events-calendar-list__event-title-link:hover,
.tribe-events .tribe-events-calendar-day__event-title-link:hover{
	color: {$colors['text_link']};
}

.tribe-events .tribe-events-c-nav__today:hover,
.tribe-events-event-meta a:visited,
.tribe-events-event-meta a:focus, 
.tribe-events-event-meta a:hover{
	color: {$colors['text_hover']};
}

.tribe-events .datepicker .past{
	color: {$colors['text_light']};
}


CSS;
		}
		
		return $css;
	}
}
