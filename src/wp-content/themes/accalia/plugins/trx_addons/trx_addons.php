<?php
/* ThemeREX Addons support functions
------------------------------------------------------------------------------- */

// Add theme-specific functions
require_once ACCALIA_THEME_DIR . 'theme-specific/trx_addons.setup.php';

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if (!function_exists('accalia_trx_addons_theme_setup1')) {
	add_action( 'after_setup_theme', 'accalia_trx_addons_theme_setup1', 1 );
	add_action( 'trx_addons_action_save_options', 'accalia_trx_addons_theme_setup1', 8 );
	function accalia_trx_addons_theme_setup1() {
		if (accalia_exists_trx_addons()) {
			add_filter( 'accalia_filter_list_posts_types',	'accalia_trx_addons_list_post_types');
			add_filter( 'accalia_filter_list_header_styles','accalia_trx_addons_list_header_styles');
			add_filter( 'accalia_filter_list_footer_styles','accalia_trx_addons_list_footer_styles');
			add_filter( 'trx_addons_filter_default_layouts','accalia_trx_addons_default_layouts');
			add_filter( 'trx_addons_filter_load_options',	'accalia_trx_addons_default_components');
			add_filter( 'trx_addons_cpt_list_options',		'accalia_trx_addons_cpt_list_options', 10, 2);
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('accalia_trx_addons_theme_setup9')) {
	add_action( 'after_setup_theme', 'accalia_trx_addons_theme_setup9', 9 );
	function accalia_trx_addons_theme_setup9() {
		if (accalia_exists_trx_addons()) {
			add_filter( 'trx_addons_filter_featured_image',				'accalia_trx_addons_featured_image', 10, 2);
			add_filter( 'trx_addons_filter_no_image',					'accalia_trx_addons_no_image' );
			add_filter( 'trx_addons_filter_get_list_icons',				'accalia_trx_addons_get_list_icons', 10, 2 );
			add_action( 'wp_enqueue_scripts', 							'accalia_trx_addons_frontend_scripts', 1100 );
			add_filter( 'accalia_filter_query_sort_order',	 			'accalia_trx_addons_query_sort_order', 10, 3);
			add_filter( 'accalia_filter_merge_scripts',					'accalia_trx_addons_merge_scripts');
			add_filter( 'accalia_filter_prepare_css',					'accalia_trx_addons_prepare_css', 10, 2);
			add_filter( 'accalia_filter_prepare_js',					'accalia_trx_addons_prepare_js', 10, 2);
			add_filter( 'accalia_filter_localize_script',				'accalia_trx_addons_localize_script');
			add_filter( 'accalia_filter_get_post_categories',		 	'accalia_trx_addons_get_post_categories');
			add_filter( 'accalia_filter_get_post_date',		 			'accalia_trx_addons_get_post_date');
			add_filter( 'trx_addons_filter_get_post_date',		 		'accalia_trx_addons_get_post_date_wrap');
			add_filter( 'accalia_filter_post_type_taxonomy',			'accalia_trx_addons_post_type_taxonomy', 10, 2 );
            add_filter( 'accalia_filter_get_translated_layout',         'accalia_trx_addons_filter_get_translated_layout', 10, 1 );
			if (is_admin()) {
				add_filter( 'accalia_filter_allow_override', 			'accalia_trx_addons_allow_override', 10, 2);
				add_filter( 'accalia_filter_allow_theme_icons', 		'accalia_trx_addons_allow_theme_icons', 10, 2);
			} else {
				add_filter( 'trx_addons_filter_theme_logo',				'accalia_trx_addons_theme_logo');
				add_filter( 'trx_addons_filter_post_meta',				'accalia_trx_addons_post_meta', 10, 2);
				add_filter( 'trx_addons_filter_args_related',			'accalia_trx_addons_args_related');
				add_filter( 'accalia_filter_get_mobile_menu',			'accalia_trx_addons_get_mobile_menu');
				add_filter( 'accalia_filter_detect_blog_mode',			'accalia_trx_addons_detect_blog_mode' );
				add_filter( 'accalia_filter_get_blog_title', 			'accalia_trx_addons_get_blog_title');
				add_action( 'accalia_action_login',						'accalia_trx_addons_action_login', 10, 2);
				add_action( 'accalia_action_search',					'accalia_trx_addons_action_search', 10, 3);
				add_action( 'accalia_action_breadcrumbs',				'accalia_trx_addons_action_breadcrumbs');
				add_action( 'accalia_action_show_layout',				'accalia_trx_addons_action_show_layout', 10, 1);
				add_action( 'accalia_action_user_meta',					'accalia_trx_addons_action_user_meta');
			}
		}
		
		// Add this filter any time: if plugin exists - load plugin's styles, if not exists - load layouts.css instead plugin's styles
		add_filter( 'accalia_filter_merge_styles',						'accalia_trx_addons_merge_styles');
		
		if (is_admin()) {
			add_filter( 'accalia_filter_tgmpa_required_plugins',		'accalia_trx_addons_tgmpa_required_plugins' );
			add_action( 'admin_enqueue_scripts', 						'accalia_trx_addons_editor_load_scripts_admin');
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'accalia_trx_addons_tgmpa_required_plugins' ) ) {
	function accalia_trx_addons_tgmpa_required_plugins($list=array()) {
		if (in_array('trx_addons', accalia_storage_get('required_plugins'))) {
			$path = accalia_get_file_dir('plugins/trx_addons/trx_addons.zip');
			$list[] = array(
					'name' 		=> esc_html__('ThemeREX Addons', 'accalia'),
					'slug' 		=> 'trx_addons',
					'version'	=> '1.71.29.15',
					'source'	=> !empty($path) ? $path : 'upload://trx_addons.zip',
					'required' 	=> true
				);
		}
		return $list;
	}
}


/* Add options in the Theme Options Customizer
------------------------------------------------------------------------------- */

if (!function_exists('accalia_trx_addons_cpt_list_options')) {
	function accalia_trx_addons_cpt_list_options($options, $cpt) {
		if (is_array($options)) {
			foreach ($options as $k=>$v) {
				// Store this option in the external (not theme's) storage
				$options[$k]['options_storage'] = 'trx_addons_options';
				// Hide this option from plugin's options (only for overriden options)
				$options[$k]['hidden'] = in_array($cpt, array('cars', 'cars_agents', 'courses', 'dishes', 'properties', 'agents', 'sport'));
			}
		}
		return $options;
	}
}

// Return plugin's specific options for CPT
if (!function_exists('accalia_trx_addons_get_list_cpt_options')) {
	function accalia_trx_addons_get_list_cpt_options($cpt) {
		$options = array();
		if ($cpt == 'cars')
			$options = array_merge(
						trx_addons_cpt_cars_agents_get_list_options(),
						trx_addons_cpt_cars_get_list_options()
						);
		else if ($cpt == 'courses')
			$options = trx_addons_cpt_courses_get_list_options();
		else if ($cpt == 'dishes')
			$options = trx_addons_cpt_dishes_get_list_options();
		else if ($cpt == 'properties')
			$options = array_merge(
						trx_addons_cpt_agents_get_list_options(),
						trx_addons_cpt_properties_get_list_options()
						);
		else if ($cpt == 'sport')
			$options = trx_addons_cpt_sport_get_list_options();
		// Remove parameter 'hidden'
		foreach ($options as $k=>$v) {
			if (!empty($v['hidden']))
				unset($options[$k]['hidden']);
		}
		return $options;
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('accalia_trx_addons_setup3')) {
	add_action( 'after_setup_theme', 'accalia_trx_addons_setup3', 3 );
	function accalia_trx_addons_setup3() {
		
		// Section 'Cars' - settings to show 'Cars' blog archive and single posts
		if (accalia_exists_cars()) {
			accalia_storage_merge_array('options', '', array_merge(
				array(
					'cars' => array(
						"title" => esc_html__('Cars', 'accalia'),
						"desc" => wp_kses_data( __('Select parameters to display the cars pages', 'accalia') ),
						"type" => "section"
						)
				),
				accalia_trx_addons_get_list_cpt_options('cars'),
				accalia_options_get_list_cpt_options('cars'),
				array(
					'related_posts_cars' => array(
						"title" => esc_html__('Related cars', 'accalia'),
						"desc" => wp_kses_data( __('How many related cars should be displayed in the single car page?', 'accalia') ),
						"std" => 3,
						"options" => accalia_get_list_range(0,9),
						"type" => "select"
						),
					'related_columns_cars' => array(
						"title" => esc_html__('Related columns', 'accalia'),
						"desc" => wp_kses_data( __('How many columns should be used to output related cars in the single car page?', 'accalia') ),
						"std" => 3,
						"options" => accalia_get_list_range(1,4),
						"type" => "select"
						)
				)
			));
		}
		
		// Section 'Courses' - settings to show 'Courses' blog archive and single posts
		if (accalia_exists_courses()) {
		
			accalia_storage_merge_array('options', '', array_merge(
				array(
					'courses' => array(
						"title" => esc_html__('Courses', 'accalia'),
						"desc" => wp_kses_data( __('Select parameters to display the courses pages', 'accalia') ),
						"type" => "section"
						)
				),
				accalia_trx_addons_get_list_cpt_options('courses'),
				accalia_options_get_list_cpt_options('courses'),
				array(
					'related_posts_courses' => array(
						"title" => esc_html__('Related courses', 'accalia'),
						"desc" => wp_kses_data( __('How many related courses should be displayed in the single course page?', 'accalia') ),
						"std" => 3,
						"options" => accalia_get_list_range(0,9),
						"type" => "select"
						),
					'related_columns_courses' => array(
						"title" => esc_html__('Related columns', 'accalia'),
						"desc" => wp_kses_data( __('How many columns should be used to output related courses in the single course page?', 'accalia') ),
						"std" => 3,
						"options" => accalia_get_list_range(1,4),
						"type" => "select"
						)
				)
			));
		}
		
		// Section 'Dishes' - settings to show 'Dishes' blog archive and single posts
		if (accalia_exists_dishes()) {

			accalia_storage_merge_array('options', '', array_merge(
				array(
					'dishes' => array(
						"title" => esc_html__('Dishes', 'accalia'),
						"desc" => wp_kses_data( __('Select parameters to display the dishes pages', 'accalia') ),
						"type" => "section"
						)
				),
				accalia_trx_addons_get_list_cpt_options('dishes'),
				accalia_options_get_list_cpt_options('dishes'),
				array(
					'related_posts_dishes' => array(
						"title" => esc_html__('Related dishes', 'accalia'),
						"desc" => wp_kses_data( __('How many related dishes should be displayed in the single course page?', 'accalia') ),
						"std" => 3,
						"options" => accalia_get_list_range(0,9),
						"type" => "select"
						),
					'related_columns_dishes' => array(
						"title" => esc_html__('Related columns', 'accalia'),
						"desc" => wp_kses_data( __('How many columns should be used to output related dishes in the single course page?', 'accalia') ),
						"std" => 3,
						"options" => accalia_get_list_range(1,4),
						"type" => "select"
						)
					)
				)
			);
		}
		
		// Section 'Properties' - settings to show 'Properties' blog archive and single posts
		if (accalia_exists_properties()) {
		
			accalia_storage_merge_array('options', '', array_merge(
				array(
					'properties' => array(
						"title" => esc_html__('Properties', 'accalia'),
						"desc" => wp_kses_data( __('Select parameters to display the properties pages', 'accalia') ),
						"type" => "section"
						)
				),
				accalia_trx_addons_get_list_cpt_options('properties'),
				accalia_options_get_list_cpt_options('properties'),
				array(
					'related_posts_properties' => array(
						"title" => esc_html__('Related properties', 'accalia'),
						"desc" => wp_kses_data( __('How many related properties should be displayed in the single property page?', 'accalia') ),
						"std" => 3,
						"options" => accalia_get_list_range(0,9),
						"type" => "select"
						),
					'related_columns_properties' => array(
						"title" => esc_html__('Related columns', 'accalia'),
						"desc" => wp_kses_data( __('How many columns should be used to output related properties in the single property page?', 'accalia') ),
						"std" => 3,
						"options" => accalia_get_list_range(1,4),
						"type" => "select"
						)
					)
				)
			);
		}
		
		// Section 'Sport' - settings to show 'Sport' blog archive and single posts
		if (accalia_exists_sport()) {
			accalia_storage_merge_array('options', '', array_merge(
				array(
					'sport' => array(
						"title" => esc_html__('Sport', 'accalia'),
						"desc" => wp_kses_data( __('Select parameters to display the sport pages', 'accalia') ),
						"type" => "section"
						)
				),
				accalia_trx_addons_get_list_cpt_options('sport'),
				accalia_options_get_list_cpt_options('sport')
			));
		}
	}
}

// Setup internal plugin's parameters
if (!function_exists('accalia_trx_addons_init_settings')) {
	add_filter( 'trx_addons_init_settings', 'accalia_trx_addons_init_settings');
	function accalia_trx_addons_init_settings($settings) {
		$settings['socials_type']	= accalia_get_theme_setting('socials_type');
		$settings['icons_type']		= accalia_get_theme_setting('icons_type');
		$settings['icons_selector']	= accalia_get_theme_setting('icons_selector');
		return $settings;
	}
}



/* Plugin's support utilities
------------------------------------------------------------------------------- */

// Check if plugin installed and activated
if ( !function_exists( 'accalia_exists_trx_addons' ) ) {
	function accalia_exists_trx_addons() {
		return defined('TRX_ADDONS_VERSION');
	}
}

// Return true if cars is supported
if ( !function_exists( 'accalia_exists_cars' ) ) {
	function accalia_exists_cars() {
		return defined('TRX_ADDONS_CPT_CARS_PT');
	}
}

// Return true if courses is supported
if ( !function_exists( 'accalia_exists_courses' ) ) {
	function accalia_exists_courses() {
		return defined('TRX_ADDONS_CPT_COURSES_PT');
	}
}

// Return true if dishes is supported
if ( !function_exists( 'accalia_exists_dishes' ) ) {
	function accalia_exists_dishes() {
		return defined('TRX_ADDONS_CPT_DISHES_PT');
	}
}

// Return true if layouts is supported
if ( !function_exists( 'accalia_exists_layouts' ) ) {
	function accalia_exists_layouts() {
		return defined('TRX_ADDONS_CPT_LAYOUTS_PT');
	}
}

// Return true if portfolio is supported
if ( !function_exists( 'accalia_exists_portfolio' ) ) {
	function accalia_exists_portfolio() {
		return defined('TRX_ADDONS_CPT_PORTFOLIO_PT');
	}
}

// Return true if properties is supported
if ( !function_exists( 'accalia_exists_properties' ) ) {
	function accalia_exists_properties() {
		return defined('TRX_ADDONS_CPT_PROPERTIES_PT');
	}
}

// Return true if services is supported
if ( !function_exists( 'accalia_exists_services' ) ) {
	function accalia_exists_services() {
		return defined('TRX_ADDONS_CPT_SERVICES_PT');
	}
}

// Return true if sport is supported
if ( !function_exists( 'accalia_exists_sport' ) ) {
	function accalia_exists_sport() {
		return defined('TRX_ADDONS_CPT_COMPETITIONS_PT');
	}
}

// Return true if team is supported
if ( !function_exists( 'accalia_exists_team' ) ) {
	function accalia_exists_team() {
		return defined('TRX_ADDONS_CPT_TEAM_PT');
	}
}


// Return true if it's cars page
if ( !function_exists( 'accalia_is_cars_page' ) ) {
	function accalia_is_cars_page() {
		return function_exists('trx_addons_is_cars_page') && trx_addons_is_cars_page();
	}
}

// Return true if it's courses page
if ( !function_exists( 'accalia_is_courses_page' ) ) {
	function accalia_is_courses_page() {
		return function_exists('trx_addons_is_courses_page') && trx_addons_is_courses_page();
	}
}

// Return true if it's dishes page
if ( !function_exists( 'accalia_is_dishes_page' ) ) {
	function accalia_is_dishes_page() {
		return function_exists('trx_addons_is_dishes_page') && trx_addons_is_dishes_page();
	}
}

// Return true if it's properties page
if ( !function_exists( 'accalia_is_properties_page' ) ) {
	function accalia_is_properties_page() {
		return function_exists('trx_addons_is_properties_page') && trx_addons_is_properties_page();
	}
}

// Return true if it's portfolio page
if ( !function_exists( 'accalia_is_portfolio_page' ) ) {
	function accalia_is_portfolio_page() {
		return function_exists('trx_addons_is_portfolio_page') && trx_addons_is_portfolio_page();
	}
}

// Return true if it's services page
if ( !function_exists( 'accalia_is_services_page' ) ) {
	function accalia_is_services_page() {
		return function_exists('trx_addons_is_services_page') && trx_addons_is_services_page();
	}
}

// Return true if it's team page
if ( !function_exists( 'accalia_is_team_page' ) ) {
	function accalia_is_team_page() {
		return function_exists('trx_addons_is_team_page') && trx_addons_is_team_page();
	}
}

// Return true if it's sport page
if ( !function_exists( 'accalia_is_sport_page' ) ) {
	function accalia_is_sport_page() {
		return function_exists('trx_addons_is_sport_page') && trx_addons_is_sport_page();
	}
}

// Detect current blog mode
if ( !function_exists( 'accalia_trx_addons_detect_blog_mode' ) ) {
	function accalia_trx_addons_detect_blog_mode($mode='') {
		if ( accalia_is_cars_page() )
			$mode = 'cars';
		else if ( accalia_is_courses_page() )
			$mode = 'courses';
		else if ( accalia_is_dishes_page() )
			$mode = 'dishes';
		else if ( accalia_is_properties_page() )
			$mode = 'properties';
		else if ( accalia_is_portfolio_page() )
			$mode = 'portfolio';
		else if ( accalia_is_services_page() )
			$mode = 'services';
		else if ( accalia_is_sport_page() )
			$mode = 'sport';
		else if ( accalia_is_team_page() )
			$mode = 'team';
		return $mode;
	}
}

// Add team, courses, etc. to the supported posts list
if ( !function_exists( 'accalia_trx_addons_list_post_types' ) ) {
	function accalia_trx_addons_list_post_types($list=array()) {
		if (function_exists('trx_addons_get_cpt_list')) {
			$cpt_list = trx_addons_get_cpt_list();
			foreach ($cpt_list as $cpt => $title) {
				if (   
					   (defined('TRX_ADDONS_CPT_CARS_PT') && $cpt == TRX_ADDONS_CPT_CARS_PT)
					|| (defined('TRX_ADDONS_CPT_COURSES_PT') && $cpt == TRX_ADDONS_CPT_COURSES_PT)
					|| (defined('TRX_ADDONS_CPT_DISHES_PT') && $cpt == TRX_ADDONS_CPT_DISHES_PT)
					|| (defined('TRX_ADDONS_CPT_PORTFOLIO_PT') && $cpt == TRX_ADDONS_CPT_PORTFOLIO_PT)
					|| (defined('TRX_ADDONS_CPT_PROPERTIES_PT') && $cpt == TRX_ADDONS_CPT_PROPERTIES_PT)
					|| (defined('TRX_ADDONS_CPT_SERVICES_PT') && $cpt == TRX_ADDONS_CPT_SERVICES_PT)
					|| (defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && $cpt == TRX_ADDONS_CPT_COMPETITIONS_PT)
					)
					$list[$cpt] = $title;
			}
		}
		return $list;
	}
}

// Return taxonomy for current post type
if ( !function_exists( 'accalia_trx_addons_post_type_taxonomy' ) ) {
	function accalia_trx_addons_post_type_taxonomy($tax='', $post_type='') {
		if ( defined('TRX_ADDONS_CPT_CARS_PT') && $post_type == TRX_ADDONS_CPT_CARS_PT )
			$tax = TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER;
		else if ( defined('TRX_ADDONS_CPT_COURSES_PT') && $post_type == TRX_ADDONS_CPT_COURSES_PT )
			$tax = TRX_ADDONS_CPT_COURSES_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_DISHES_PT') && $post_type == TRX_ADDONS_CPT_DISHES_PT )
			$tax = TRX_ADDONS_CPT_DISHES_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_PORTFOLIO_PT') && $post_type == TRX_ADDONS_CPT_PORTFOLIO_PT )
			$tax = TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_PROPERTIES_PT') && $post_type == TRX_ADDONS_CPT_PROPERTIES_PT )
			$tax = TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE;
		else if ( defined('TRX_ADDONS_CPT_SERVICES_PT') && $post_type == TRX_ADDONS_CPT_SERVICES_PT )
			$tax = TRX_ADDONS_CPT_SERVICES_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && $post_type == TRX_ADDONS_CPT_COMPETITIONS_PT )
			$tax = TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_TEAM_PT') && $post_type == TRX_ADDONS_CPT_TEAM_PT )
			$tax = TRX_ADDONS_CPT_TEAM_TAXONOMY;
		return $tax;
	}
}

// Show categories of the team, courses, etc.
if ( !function_exists( 'accalia_trx_addons_get_post_categories' ) ) {
	function accalia_trx_addons_get_post_categories($cats='') {

		if ( defined('TRX_ADDONS_CPT_CARS_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_CARS_PT) {
				$cats = accalia_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE);
			}
		}
		if ( defined('TRX_ADDONS_CPT_COURSES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_COURSES_PT) {
				$cats = accalia_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_COURSES_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_DISHES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_DISHES_PT) {
				$cats = accalia_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_DISHES_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_PORTFOLIO_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_PORTFOLIO_PT) {
				$cats = accalia_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_PROPERTIES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_PROPERTIES_PT) {
				$cats = accalia_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE);
			}
		}
		if ( defined('TRX_ADDONS_CPT_SERVICES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_SERVICES_PT) {
				$cats = accalia_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_SERVICES_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_COMPETITIONS_PT) {
				$cats = accalia_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_TEAM_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_TEAM_PT) {
				$cats = accalia_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_TEAM_TAXONOMY);
			}
		}
		return $cats;
	}
}

// Show post's date with the theme-specific format
if ( !function_exists( 'accalia_trx_addons_get_post_date_wrap' ) ) {
	function accalia_trx_addons_get_post_date_wrap($dt='') {
		return apply_filters('accalia_filter_get_post_date', $dt);
	}
}

// Show date of the courses
if ( !function_exists( 'accalia_trx_addons_get_post_date' ) ) {
	function accalia_trx_addons_get_post_date($dt='') {

		if ( defined('TRX_ADDONS_CPT_COURSES_PT') && get_post_type()==TRX_ADDONS_CPT_COURSES_PT) {
			$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
			$dt = $meta['date'];
			$dt = sprintf($dt < date('Y-m-d') 
					? esc_html__('Started on %s', 'accalia') 
					: esc_html__('Starting %s', 'accalia'), 
					date(get_option('date_format'), strtotime($dt)));

		} else if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && in_array(get_post_type(), array(TRX_ADDONS_CPT_COMPETITIONS_PT, TRX_ADDONS_CPT_ROUNDS_PT, TRX_ADDONS_CPT_MATCHES_PT))) {
			$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
			$dt = $meta['date_start'];
			$dt = sprintf($dt < date('Y-m-d').(!empty($meta['time_start']) ? ' H:i' : '')
					? esc_html__('Started on %s', 'accalia') 
					: esc_html__('Starting %s', 'accalia'), 
					date(get_option('date_format') . (!empty($meta['time_start']) ? ' '.get_option('time_format') : ''), strtotime($dt.(!empty($meta['time_start']) ? ' '.trim($meta['time_start']) : ''))));

		} else if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && get_post_type() == TRX_ADDONS_CPT_PLAYERS_PT) {
			// Uncomment (remove) next line if you want to show player's birthday in the page title block
			if (false) {
				$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
				$dt = !empty($meta['birthday']) ? sprintf(esc_html__('Birthday: %s', 'accalia'), date(get_option('date_format'), strtotime($meta['birthday']))) : '';
			} else
				$dt = '';
		}
		return $dt;
	}
}

// Check if override options is allowed
if (!function_exists('accalia_trx_addons_allow_override')) {
	function accalia_trx_addons_allow_override($allow, $post_type) {
		return $allow
					|| (defined('TRX_ADDONS_CPT_CARS_PT') && in_array($post_type, array(
																				TRX_ADDONS_CPT_CARS_PT,
																				TRX_ADDONS_CPT_CARS_AGENTS_PT
																				)))
					|| (defined('TRX_ADDONS_CPT_COURSES_PT') && $post_type==TRX_ADDONS_CPT_COURSES_PT)
					|| (defined('TRX_ADDONS_CPT_DISHES_PT') && $post_type==TRX_ADDONS_CPT_DISHES_PT)
					|| (defined('TRX_ADDONS_CPT_PORTFOLIO_PT') && $post_type==TRX_ADDONS_CPT_PORTFOLIO_PT) 
					|| (defined('TRX_ADDONS_CPT_PROPERTIES_PT') && in_array($post_type, array(
																				TRX_ADDONS_CPT_PROPERTIES_PT,
																				TRX_ADDONS_CPT_AGENTS_PT
																				)))
					|| (defined('TRX_ADDONS_CPT_RESUME_PT') && $post_type==TRX_ADDONS_CPT_RESUME_PT) 
					|| (defined('TRX_ADDONS_CPT_SERVICES_PT') && $post_type==TRX_ADDONS_CPT_SERVICES_PT) 
					|| (defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && in_array($post_type, array(
																				TRX_ADDONS_CPT_COMPETITIONS_PT,
																				TRX_ADDONS_CPT_ROUNDS_PT,
																				TRX_ADDONS_CPT_MATCHES_PT
																				)))
					|| (defined('TRX_ADDONS_CPT_TEAM_PT') && $post_type==TRX_ADDONS_CPT_TEAM_PT);
	}
}

// Check if theme icons is allowed
if (!function_exists('accalia_trx_addons_allow_theme_icons')) {
	function accalia_trx_addons_allow_theme_icons($allow, $post_type) {
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		return $allow
					|| (defined('TRX_ADDONS_CPT_LAYOUTS_PT') && $post_type==TRX_ADDONS_CPT_LAYOUTS_PT)
					|| (!empty($screen->id) && in_array($screen->id, array(
																		'appearance_page_trx_addons_options',
																		'profile'
																	)
														)
						);
	}
}

// Set related posts and columns for the plugin's output
if (!function_exists('accalia_trx_addons_args_related')) {
	function accalia_trx_addons_args_related($args) {
		if (!empty($args['template_args_name']) && in_array($args['template_args_name'], array('trx_addons_args_sc_cars', 'trx_addons_args_sc_courses', 'trx_addons_args_sc_dishes', 'trx_addons_args_sc_properties'))) {
			$args['posts_per_page'] = accalia_get_theme_option('related_posts');
			$args['columns'] = accalia_get_theme_option('related_columns');
		}
		return $args;
	}
}

// Add layouts to the headers list
if ( !function_exists( 'accalia_trx_addons_list_header_styles' ) ) {
	function accalia_trx_addons_list_header_styles($list=array()) {
		if (accalia_exists_layouts()) {
			$layouts = accalia_get_list_posts(false, array(
							'post_type' => TRX_ADDONS_CPT_LAYOUTS_PT,
							'meta_key' => 'trx_addons_layout_type',
							'meta_value' => 'header',
							'not_selected' => false
							)
						);
			foreach ($layouts as $id=>$title) {
				if ($id != 'none') $list['header-custom-'.intval($id)] = $title;
			}
		}
		return $list;
	}
}

// Add layouts to the footers list
if ( !function_exists( 'accalia_trx_addons_list_footer_styles' ) ) {
	function accalia_trx_addons_list_footer_styles($list=array()) {
		if (accalia_exists_layouts()) {
			$layouts = accalia_get_list_posts(false, array(
							'post_type' => TRX_ADDONS_CPT_LAYOUTS_PT,
							'meta_key' => 'trx_addons_layout_type',
							'meta_value' => 'footer',
							'not_selected' => false
							)
						);
			foreach ($layouts as $id=>$title) {
				if ($id != 'none') $list['footer-custom-'.intval($id)] = $title;
			}
		}
		return $list;
	}
}


// Add theme-specific layouts to the list
if (!function_exists('accalia_trx_addons_default_layouts')) {
	function accalia_trx_addons_default_layouts($default_layouts=array()) {
		if (accalia_storage_isset('trx_addons_default_layouts')) {
			$layouts = accalia_storage_get('trx_addons_default_layouts');
		} else {
			require_once ACCALIA_THEME_DIR . 'theme-specific/trx_addons.layouts.php';
			if (!isset($layouts) || !is_array($layouts))
				$layouts = array();
			accalia_storage_set('trx_addons_default_layouts', $layouts);
		}
		if (count($layouts) > 0)
			$default_layouts = array_merge($default_layouts, $layouts);
		return $default_layouts;
	}
}


// Add theme-specific components to the plugin's options
if (!function_exists('accalia_trx_addons_default_components')) {
	function accalia_trx_addons_default_components($options=array()) {
		if (empty($options['components_present'])) {
			if (accalia_storage_isset('trx_addons_default_components')) {
				$components = accalia_storage_get('trx_addons_default_components');
			} else {
				require_once ACCALIA_THEME_DIR . 'theme-specific/trx_addons.components.php';
				if (!isset($components) || !is_array($components))
					$components = array();
				accalia_storage_set('trx_addons_default_components', $components);
			}
			$options = is_array($options) && count($components) > 0
									? array_merge($options, $components)
									: $components;
		}
		return $options;
	}
}


// Enqueue custom styles
if ( !function_exists( 'accalia_trx_addons_frontend_scripts' ) ) {
	function accalia_trx_addons_frontend_scripts() {
		if (accalia_exists_trx_addons()) {
			if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('plugins/trx_addons/trx_addons.css')!='') {
				wp_enqueue_style( 'accalia-trx-addons',  accalia_get_file_url('plugins/trx_addons/trx_addons.css'), array(), null );
				wp_enqueue_style( 'accalia-trx-addons-editor',  accalia_get_file_url('plugins/trx_addons/trx_addons.editor.css'), array(), null );
			}
			if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('plugins/trx_addons/trx_addons.js')!='')
				wp_enqueue_script( 'accalia-trx-addons', accalia_get_file_url('plugins/trx_addons/trx_addons.js'), array('jquery'), null, true );
		}
		// Load custom layouts from the theme if plugin not exists
		if (!accalia_exists_trx_addons() || accalia_get_theme_option("header_style")=='header-default') {
			if ( accalia_is_on(accalia_get_theme_option('debug_mode')) ) {
				wp_enqueue_style( 'accalia-layouts', accalia_get_file_url('plugins/trx_addons/layouts/layouts.css') );
				wp_enqueue_style( 'accalia-layouts-logo', accalia_get_file_url('plugins/trx_addons/layouts/logo.css') );
				wp_enqueue_style( 'accalia-layouts-menu', accalia_get_file_url('plugins/trx_addons/layouts/menu.css') );
				wp_enqueue_style( 'accalia-layouts-search', accalia_get_file_url('plugins/trx_addons/layouts/search.css') );
				wp_enqueue_style( 'accalia-layouts-title', accalia_get_file_url('plugins/trx_addons/layouts/title.css') );
				wp_enqueue_style( 'accalia-layouts-featured', accalia_get_file_url('plugins/trx_addons/layouts/featured.css') );
			}
		}
	}
}
	
// Merge custom styles
if ( !function_exists( 'accalia_trx_addons_merge_styles' ) ) {
	function accalia_trx_addons_merge_styles($list) {
		// ALWAYS merge custom layouts from the theme
		$list[] = 'plugins/trx_addons/layouts/layouts.css';
		$list[] = 'plugins/trx_addons/layouts/logo.css';
		$list[] = 'plugins/trx_addons/layouts/menu.css';
		$list[] = 'plugins/trx_addons/layouts/search.css';
		$list[] = 'plugins/trx_addons/layouts/title.css';
		$list[] = 'plugins/trx_addons/layouts/featured.css';
		if (accalia_exists_trx_addons()) {
			$list[] = 'plugins/trx_addons/trx_addons.css';
			$list[] = 'plugins/trx_addons/trx_addons.editor.css';
		}
		return $list;
	}
}
	
// Merge custom scripts
if ( !function_exists( 'accalia_trx_addons_merge_scripts' ) ) {
	function accalia_trx_addons_merge_scripts($list) {
		$list[] = 'plugins/trx_addons/trx_addons.js';
		return $list;
	}
}



// WP Editor addons
//------------------------------------------------------------------------

// Load required styles and scripts for admin mode
if ( !function_exists( 'accalia_trx_addons_editor_load_scripts_admin' ) ) {
	function accalia_trx_addons_editor_load_scripts_admin() {
		// Add styles in the WP text editor
		add_editor_style( array(
							accalia_get_file_url('plugins/trx_addons/trx_addons.editor.css')
							)
						 );	
	}
}



// Plugin API - theme-specific wrappers for plugin functions
//------------------------------------------------------------------------

// Debug functions wrappers
if (!function_exists('ddo')) { function ddo($obj, $level=-1) { return var_dump($obj); } }
if (!function_exists('dco')) { function dco($obj, $level=-1) { print_r($obj); } }
if (!function_exists('dcl')) { function dcl($msg, $level=-1) { echo '<br><pre>' . esc_html($msg) . '</pre><br>'; } }
if (!function_exists('dfo')) { function dfo($obj, $level=-1) {} }
if (!function_exists('dfl')) { function dfl($msg, $level=-1) {} }

// Check if URL contain specified string
if (!function_exists('accalia_check_url')) {
	function accalia_check_url($val='', $defa=false) {
		return function_exists('trx_addons_check_url') 
					? trx_addons_check_url($val) 
					: $defa;
	}
}

// Check if layouts components are showed or set new state
if (!function_exists('accalia_sc_layouts_showed')) {
	function accalia_sc_layouts_showed($name, $val=null) {
		if (function_exists('trx_addons_sc_layouts_showed')) {
			if ($val!==null)
				trx_addons_sc_layouts_showed($name, $val);
			else
				return trx_addons_sc_layouts_showed($name);
		} else {
			if ($val!==null)
				return accalia_storage_set_array('sc_layouts_components', $name, $val);
			else
				return accalia_storage_get_array('sc_layouts_components', $name);
		}
	}
}

// Return image size multiplier
if (!function_exists('accalia_get_retina_multiplier')) {
	function accalia_get_retina_multiplier($force_retina=0) {
		static $mult = 0;
		if ($mult == 0) $mult = function_exists('trx_addons_get_retina_multiplier') ? trx_addons_get_retina_multiplier($force_retina) : 1;
		return max(1, $mult);
	}
}

// Return slider layout
if (!function_exists('accalia_get_slider_layout')) {
	function accalia_get_slider_layout($args) {
		return function_exists('trx_addons_get_slider_layout') 
					? trx_addons_get_slider_layout($args) 
					: '';
	}
}

// Return video player layout
if (!function_exists('accalia_get_video_layout')) {
	function accalia_get_video_layout($args) {
		return function_exists('trx_addons_get_video_layout') 
					? trx_addons_get_video_layout($args) 
					: '';
	}
}

// Return theme specific layout of the featured image block
if ( !function_exists( 'accalia_trx_addons_featured_image' ) ) {
	function accalia_trx_addons_featured_image($processed=false, $args=array()) {
		$args['show_no_image'] = true;
		$args['singular'] = false;
		$args['hover'] = isset($args['hover']) && $args['hover']=='' ? '' : accalia_get_theme_option('image_hover');
		accalia_show_post_featured($args);
		return true;
	}
}

// Return theme specific 'no-image' picture
if ( !function_exists( 'accalia_trx_addons_no_image' ) ) {
	function accalia_trx_addons_no_image($no_image='') {
		return accalia_get_no_image($no_image);
	}
}

// Return theme-specific icons
if ( !function_exists( 'accalia_trx_addons_get_list_icons' ) ) {
	function accalia_trx_addons_get_list_icons($list, $prepend_inherit) {
		return accalia_get_list_icons($prepend_inherit);
	}
}

// Return links to the social profiles
if (!function_exists('accalia_get_socials_links')) {
	function accalia_get_socials_links($style='icons') {
		return function_exists('trx_addons_get_socials_links') 
					? trx_addons_get_socials_links($style)
					: '';
	}
}

// Return links to share post
if (!function_exists('accalia_get_share_links')) {
	function accalia_get_share_links($args=array()) {
		return function_exists('trx_addons_get_share_links') 
					? trx_addons_get_share_links($args)
					: '';
	}
}

// Display links to share post
if (!function_exists('accalia_show_share_links')) {
	function accalia_show_share_links($args=array()) {
		if (function_exists('trx_addons_get_share_links')) {
			$args['echo'] = true;
			trx_addons_get_share_links($args);
		}
	}
}


// Return image from the category
if (!function_exists('accalia_get_category_image')) {
	function accalia_get_category_image($term_id=0) {
		return function_exists('trx_addons_get_category_image') 
					? trx_addons_get_category_image($term_id)
					: '';
	}
}

// Return small image (icon) from the category
if (!function_exists('accalia_get_category_icon')) {
	function accalia_get_category_icon($term_id=0) {
		return function_exists('trx_addons_get_category_icon') 
					? trx_addons_get_category_icon($term_id)
					: '';
	}
}

// Return string with counters items
if (!function_exists('accalia_get_post_counters')) {
	function accalia_get_post_counters($counters='views') {
		return function_exists('trx_addons_get_post_counters')
					? str_replace('post_counters_item', 'post_meta_item post_counters_item', trx_addons_get_post_counters($counters))
					: '';
	}
}

// Return list with animation effects
if (!function_exists('accalia_get_list_animations_in')) {
	function accalia_get_list_animations_in() {
		return function_exists('trx_addons_get_list_animations_in') 
					? trx_addons_get_list_animations_in()
					: array();
	}
}

// Return classes list for the specified animation
if (!function_exists('accalia_get_animation_classes')) {
	function accalia_get_animation_classes($animation, $speed='normal', $loop='none') {
		return function_exists('trx_addons_get_animation_classes') 
					? trx_addons_get_animation_classes($animation, $speed, $loop)
					: '';
	}
}

// Return string with the likes counter for the specified comment
if (!function_exists('accalia_get_comment_counters')) {
	function accalia_get_comment_counters($counters = 'likes') {
		return function_exists('trx_addons_get_comment_counters') 
					? trx_addons_get_comment_counters($counters)
					: '';
	}
}

// Display likes counter for the specified comment
if (!function_exists('accalia_show_comment_counters')) {
	function accalia_show_comment_counters($counters = 'likes') {
		if (function_exists('trx_addons_get_comment_counters'))
			trx_addons_get_comment_counters($counters, true);
	}
}

// Add query params to sort posts by views or likes
if (!function_exists('accalia_trx_addons_query_sort_order')) {
	function accalia_trx_addons_query_sort_order($q=array(), $orderby='date', $order='desc') {
		if ($orderby == 'views') {
			$q['orderby'] = 'meta_value_num';
			$q['meta_key'] = 'trx_addons_post_views_count';
		} else if ($orderby == 'likes') {
			$q['orderby'] = 'meta_value_num';
			$q['meta_key'] = 'trx_addons_post_likes_count';
		}
		return $q;
	}
}

// Return theme-specific logo to the plugin
if ( !function_exists( 'accalia_trx_addons_theme_logo' ) ) {
	function accalia_trx_addons_theme_logo($logo) {
		return accalia_get_logo_image();
	}
}

// Return theme-specific post meta to the plugin
if ( !function_exists( 'accalia_trx_addons_post_meta' ) ) {
	function accalia_trx_addons_post_meta($meta, $args=array()) {
		return accalia_show_post_meta(apply_filters('accalia_filter_post_meta_args', $args, 'trx_addons', 1));
	}
}
	
// Redirect action 'get_mobile_menu' to the plugin
// Return stored items as mobile menu
if ( !function_exists( 'accalia_trx_addons_get_mobile_menu' ) ) {
	function accalia_trx_addons_get_mobile_menu($menu) {
		return apply_filters('trx_addons_filter_get_mobile_menu', $menu);
	}
}

// Redirect action 'login' to the plugin
if (!function_exists('accalia_trx_addons_action_login')) {
	function accalia_trx_addons_action_login($link_text='', $link_title='') {
		do_action( 'trx_addons_action_login', $link_text, $link_title );
	}
}

// Redirect action 'search' to the plugin
if (!function_exists('accalia_trx_addons_action_search')) {
	function accalia_trx_addons_action_search($style, $class, $ajax) {
		do_action( 'trx_addons_action_search', $style, $class, $ajax );
	}
}

// Redirect action 'breadcrumbs' to the plugin
if (!function_exists('accalia_trx_addons_action_breadcrumbs')) {
	function accalia_trx_addons_action_breadcrumbs() {
		do_action( 'trx_addons_action_breadcrumbs' );
	}
}

// Redirect action 'show_layout' to the plugin
if (!function_exists('accalia_trx_addons_action_show_layout')) {
	function accalia_trx_addons_action_show_layout($layout_id='') {
		do_action( 'trx_addons_action_show_layout', $layout_id );
	}
}

// Show user meta (socials)
if (!function_exists('accalia_trx_addons_action_user_meta')) {
	function accalia_trx_addons_action_user_meta() {
		do_action( 'trx_addons_action_user_meta' );
	}
}

// Redirect filter 'get_blog_title' to the plugin
if ( !function_exists( 'accalia_trx_addons_get_blog_title' ) ) {
	function accalia_trx_addons_get_blog_title($title='') {
		return apply_filters('trx_addons_filter_get_blog_title', $title);
	}
}

// Redirect filter 'prepare_css' to the plugin
if (!function_exists('accalia_trx_addons_prepare_css')) {
	function accalia_trx_addons_prepare_css($css='', $remove_spaces=true) {
		return apply_filters( 'trx_addons_filter_prepare_css', $css, $remove_spaces );
	}
}

// Redirect filter 'prepare_js' to the plugin
if (!function_exists('accalia_trx_addons_prepare_js')) {
	function accalia_trx_addons_prepare_js($js='', $remove_spaces=true) {
		return apply_filters( 'trx_addons_filter_prepare_js', $js, $remove_spaces );
	}
}

// Add plugin's specific variables to the scripts
if (!function_exists('accalia_trx_addons_localize_script')) {
	function accalia_trx_addons_localize_script($arr) {
		$arr['trx_addons_exists'] = accalia_exists_trx_addons();
		return $arr;
	}
}


// Return text for the "I agree ..." checkbox
if ( ! function_exists( 'accalia_trx_addons_privacy_text' ) ) {
	add_filter( 'trx_addons_filter_privacy_text', 'accalia_trx_addons_privacy_text' );
	function accalia_trx_addons_privacy_text( $text='' ) {
		return accalia_get_privacy_text();
	}
}

// Add theme-specific options to the post's options
if (!function_exists('accalia_trx_addons_override_options')) {
	add_filter( 'trx_addons_filter_override_options', 'accalia_trx_addons_override_options');
	function accalia_trx_addons_override_options($options=array()) {
		return apply_filters('accalia_filter_override_options', $options);
	}
}

// Return id of the custom header or footer for current mode
if ( ! function_exists( 'accalia_get_custom_layout_id' ) ) {
    function accalia_get_custom_layout_id( $type, $layout_style = '' ) {
        $layout_id = 0;
        if ( empty( $layout_style ) ) {
            $layout_style = accalia_get_theme_option( "{$type}_style" );
        }
        if ( strpos( $layout_style, "{$type}-custom-" ) !== false ) {
            $layout_id = str_replace( "{$type}-custom-", '', $layout_style );
            if ( strpos( $layout_id, '_' ) !== false ) {
                $parts = explode( '_', $layout_id );
                $layout_id = $parts[0];
            }
            if ( 0 == (int) $layout_id ) {
                $layout_id = accalia_get_post_id(
                    array(
                        'name'      => $layout_id,
                        'post_type' => defined( 'TRX_ADDONS_CPT_LAYOUTS_PT' ) ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts',
                    )
                );
            } else {
                $layout_id = apply_filters( 'accalia_filter_get_translated_layout', $layout_id );
            }
        }
        return $layout_id;
    }
}

// Redirect filter 'get_translated_layout' to the plugin
if ( ! function_exists( 'accalia_trx_addons_filter_get_translated_layout' ) ) {
    function accalia_trx_addons_filter_get_translated_layout( $layout_id = '' ) {
        return apply_filters( 'trx_addons_filter_get_translated_post', $layout_id );
    }
}

if ( ! function_exists( 'accalia_get_custom_header_id' ) ) {
    function accalia_get_custom_header_id() {
        static $layout_id = -1;
        if ( -1 == $layout_id && accalia_get_theme_option( 'header_type' ) == 'custom' ) {
            $layout_id = accalia_get_custom_layout_id( 'header' );
        }
        return $layout_id;
    }
}

if ( ! function_exists( 'accalia_get_custom_footer_id' ) ) {
    function accalia_get_custom_footer_id() {
        static $layout_id = -1;
        if ( -1 == $layout_id && accalia_get_theme_option( 'footer_type' ) == 'custom' ) {
            $layout_id = accalia_get_custom_layout_id( 'footer' );
        }
        return $layout_id;
    }
}

if ( ! function_exists( 'accalia_get_custom_sidebar_id' ) ) {
    function accalia_get_custom_sidebar_id() {
        static $layout_id = -1;
        if ( -1 == $layout_id && accalia_get_theme_option( 'sidebar_type' ) == 'custom' ) {
            $layout_id = accalia_get_custom_layout_id( 'sidebar' );
        }
        return $layout_id;
    }
}

if ( ! function_exists( 'accalia_get_custom_blog_id' ) ) {
    function accalia_get_custom_blog_id( $style ) {
        static $layout_id = array();
        if ( empty( $layout_id[ $style ] ) ) {
            $layout_id[ $style ] = accalia_get_custom_layout_id( 'blog', $style );
        }
        return $layout_id[ $style ];
    }
}


// Add plugin-specific colors and fonts to the custom CSS
if (accalia_exists_trx_addons()) { require_once ACCALIA_THEME_DIR . 'plugins/trx_addons/trx_addons.styles.php'; }
if (accalia_exists_trx_addons()) { require_once ACCALIA_THEME_DIR . 'plugins/trx_addons/trx_addons.my_styles.php'; }
?>