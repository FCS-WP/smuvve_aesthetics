<?php
/* Tribe Events Calendar support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if (!function_exists('accalia_tribe_events_theme_setup1')) {
	add_action( 'after_setup_theme', 'accalia_tribe_events_theme_setup1', 1 );
	function accalia_tribe_events_theme_setup1() {
		add_filter( 'accalia_filter_list_sidebars', 'accalia_tribe_events_list_sidebars' );
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('accalia_tribe_events_theme_setup3')) {
	add_action( 'after_setup_theme', 'accalia_tribe_events_theme_setup3', 3 );
	function accalia_tribe_events_theme_setup3() {
		if (accalia_exists_tribe_events()) {
		
			// Section 'Tribe Events'
			accalia_storage_merge_array('options', '', array_merge(
				array(
					'events' => array(
						"title" => esc_html__('Events', 'accalia'),
						"desc" => wp_kses_data( __('Select parameters to display the events pages', 'accalia') ),
						"type" => "section"
						)
				),
				accalia_options_get_list_cpt_options('events')
			));
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('accalia_tribe_events_theme_setup9')) {
	add_action( 'after_setup_theme', 'accalia_tribe_events_theme_setup9', 9 );
	function accalia_tribe_events_theme_setup9() {
		
		if (accalia_exists_tribe_events()) {
			add_action( 'wp_enqueue_scripts', 								'accalia_tribe_events_frontend_scripts', 1100 );
			add_filter( 'accalia_filter_merge_styles',						'accalia_tribe_events_merge_styles' );
			add_filter( 'accalia_filter_post_type_taxonomy',				'accalia_tribe_events_post_type_taxonomy', 10, 2 );
			if (!is_admin()) {
				add_filter( 'accalia_filter_detect_blog_mode',				'accalia_tribe_events_detect_blog_mode' );
				add_filter( 'accalia_filter_get_post_categories', 			'accalia_tribe_events_get_post_categories');
				add_filter( 'accalia_filter_get_post_date',		 			'accalia_tribe_events_get_post_date');
			} else {
				add_action( 'admin_enqueue_scripts',						'accalia_tribe_events_admin_scripts' );
			}
		}
		if (is_admin()) {
			add_filter( 'accalia_filter_tgmpa_required_plugins',			'accalia_tribe_events_tgmpa_required_plugins' );
		}

	}
}


// Remove 'Tribe Events' section from Customizer
if (!function_exists('accalia_tribe_events_customizer_register_controls')) {
	add_action( 'customize_register', 'accalia_tribe_events_customizer_register_controls', 100 );
	function accalia_tribe_events_customizer_register_controls( $wp_customize ) {
		$wp_customize->remove_panel( 'tribe_customizer');
	}
}


// Check if Tribe Events is installed and activated
if ( !function_exists( 'accalia_exists_tribe_events' ) ) {
	function accalia_exists_tribe_events() {
		return class_exists( 'Tribe__Events__Main' );
	}
}

// Return true, if current page is any tribe_events page
if ( !function_exists( 'accalia_is_tribe_events_page' ) ) {
	function accalia_is_tribe_events_page() {
		$rez = false;
		if (accalia_exists_tribe_events())
			if (!is_search()) $rez = tribe_is_event() || tribe_is_event_query() || tribe_is_event_category() || tribe_is_event_venue() || tribe_is_event_organizer();
		return $rez;
	}
}

// Detect current blog mode
if ( !function_exists( 'accalia_tribe_events_detect_blog_mode' ) ) {
	function accalia_tribe_events_detect_blog_mode($mode='') {
		if (accalia_is_tribe_events_page())
			$mode = 'events';
		return $mode;
	}
}

// Return taxonomy for current post type
if ( !function_exists( 'accalia_tribe_events_post_type_taxonomy' ) ) {
	function accalia_tribe_events_post_type_taxonomy($tax='', $post_type='') {
		if (accalia_exists_tribe_events() && $post_type == Tribe__Events__Main::POSTTYPE)
			$tax = Tribe__Events__Main::TAXONOMY;
		return $tax;
	}
}

// Show categories of the current event
if ( !function_exists( 'accalia_tribe_events_get_post_categories' ) ) {
	function accalia_tribe_events_get_post_categories($cats='') {
		if (get_post_type() == Tribe__Events__Main::POSTTYPE)
			$cats = accalia_get_post_terms(', ', get_the_ID(), Tribe__Events__Main::TAXONOMY);
		return $cats;
	}
}

// Return date of the current event
if ( !function_exists( 'accalia_tribe_events_get_post_date' ) ) {
	function accalia_tribe_events_get_post_date($dt='') {
		if (get_post_type() == Tribe__Events__Main::POSTTYPE) {
			$dt = tribe_get_start_date(null, true, 'Y-m-d');
			$dt = sprintf($dt < date('Y-m-d') 
								? esc_html__('Started on %s', 'accalia') 
								: esc_html__('Starting %s', 'accalia'),
								date(get_option('date_format'), strtotime($dt)));
		}
		return $dt;
	}
}
	
// Enqueue Tribe Events admin scripts and styles
if ( !function_exists( 'accalia_tribe_events_admin_scripts' ) ) {
	function accalia_tribe_events_admin_scripts() {
		//Uncomment next line if you want disable custom UI styles from Tribe Events plugin


		$events_styles = '';
	}
}

// Enqueue Tribe Events custom scripts and styles
if ( !function_exists( 'accalia_tribe_events_frontend_scripts' ) ) {
	function accalia_tribe_events_frontend_scripts() {
		if (accalia_is_tribe_events_page()) {

			if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('plugins/the-events-calendar/the-events-calendar.css')!='')
				wp_enqueue_style( 'accalia-the-events-calendar',  accalia_get_file_url('plugins/the-events-calendar/the-events-calendar.css'), array(), null );
				wp_enqueue_style( 'accalia-the-events-calendar-images',  accalia_get_file_url('css/the-events-calendar.css'), array(), null );
		}
	}
}

// Merge custom styles
if ( !function_exists( 'accalia_tribe_events_merge_styles' ) ) {
	function accalia_tribe_events_merge_styles($list) {
		$list[] = 'plugins/the-events-calendar/the-events-calendar.css';
		$list[] = 'css/the-events-calendar.css';
		return $list;
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'accalia_tribe_events_tgmpa_required_plugins' ) ) {
	function accalia_tribe_events_tgmpa_required_plugins($list=array()) {
		if (in_array('the-events-calendar', accalia_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> esc_html__('Tribe Events Calendar', 'accalia'),
					'slug' 		=> 'the-events-calendar',
					'required' 	=> false
				);
		return $list;
	}
}



// Add Tribe Events specific items into lists
//------------------------------------------------------------------------

// Add sidebar
if ( !function_exists( 'accalia_tribe_events_list_sidebars' ) ) {
	function accalia_tribe_events_list_sidebars($list=array()) {
		$list['tribe_events_widgets'] = array(
											'name' => esc_html__('Tribe Events Widgets', 'accalia'),
											'description' => esc_html__('Widgets to be shown on the Tribe Events pages', 'accalia')
											);
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (accalia_exists_tribe_events()) { require_once ACCALIA_THEME_DIR . 'plugins/the-events-calendar/the-events-calendar.styles.php'; }
?>