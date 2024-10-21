<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('accalia_booked_theme_setup9')) {
	add_action( 'after_setup_theme', 'accalia_booked_theme_setup9', 9 );
	function accalia_booked_theme_setup9() {
		if (accalia_exists_booked()) {
			add_action( 'wp_enqueue_scripts', 							'accalia_booked_frontend_scripts', 1100 );
			add_filter( 'accalia_filter_merge_styles',					'accalia_booked_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'accalia_filter_tgmpa_required_plugins',		'accalia_booked_tgmpa_required_plugins' );
		}
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'accalia_exists_booked' ) ) {
	function accalia_exists_booked() {
		return class_exists('booked_plugin');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'accalia_booked_tgmpa_required_plugins' ) ) {
	function accalia_booked_tgmpa_required_plugins($list=array()) {
		if (in_array('booked', accalia_storage_get('required_plugins'))) {
			$path = accalia_get_file_dir('plugins/booked/booked.zip');
			$list[] = array(
					'name' 		=> esc_html__('Booked Appointments', 'accalia'),
					'slug' 		=> 'booked',
					'source' 	=> !empty($path) ? $path : 'upload://booked.zip',
					'required' 	=> false
			);
		}
		return $list;
	}
}
	
// Enqueue plugin's custom styles
if ( !function_exists( 'accalia_booked_frontend_scripts' ) ) {
	function accalia_booked_frontend_scripts() {
		if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('plugins/booked/booked.css')!='')
			wp_enqueue_style( 'accalia-booked',  accalia_get_file_url('plugins/booked/booked.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'accalia_booked_merge_styles' ) ) {
	function accalia_booked_merge_styles($list) {
		$list[] = 'plugins/booked/booked.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (accalia_exists_booked()) { require_once ACCALIA_THEME_DIR . 'plugins/booked/booked.styles.php'; }
?>