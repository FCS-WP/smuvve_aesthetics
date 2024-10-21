<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('accalia_quickcal_theme_setup9')) {
	add_action( 'after_setup_theme', 'accalia_quickcal_theme_setup9', 9 );
	function accalia_quickcal_theme_setup9() {
		if (accalia_exists_quickcal()) {
			add_action( 'wp_enqueue_scripts', 							'accalia_quickcal_frontend_scripts', 1100 );
			add_filter( 'accalia_filter_merge_styles',					'accalia_quickcal_merge_styles' );
		}

		if (is_admin()) {
			add_filter( 'accalia_filter_tgmpa_required_plugins',		'accalia_quickcal_tgmpa_required_plugins' );
		}
	}
}


// Check if plugin installed and activated
if ( !function_exists( 'accalia_exists_quickcal' ) ) {
	function accalia_exists_quickcal() {
		return class_exists( 'quickcal_plugin' );
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'accalia_quickcal_tgmpa_required_plugins' ) ) {
	function accalia_quickcal_tgmpa_required_plugins($list=array()) {
		if (in_array('quickcal', accalia_storage_get('required_plugins'))) {
			$path = accalia_get_file_dir('plugins/quickcal/quickcal.zip');
			$list[] = array(
					'name' 		=> esc_html__('QuickCal', 'accalia'),
					'slug' 		=> 'quickcal',
					'version'	=> '1.0.12',
					'source' 	=> !empty($path) ? $path : 'upload://quickcal.zip',
					'required' 	=> false
			);
		}
		return $list;
	}
}
	
// Enqueue plugin's custom styles
if ( !function_exists( 'accalia_quickcal_frontend_scripts' ) ) {
	
	function accalia_quickcal_frontend_scripts() {
		if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('plugins/quickcal/quickcal.css')!='')
			wp_enqueue_style( 'accalia-quickcal',  accalia_get_file_url('plugins/quickcal/quickcal.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'accalia_quickcal_merge_styles' ) ) {
	
	function accalia_quickcal_merge_styles($list) {
		$list[] = 'plugins/quickcal/quickcal.css';
		return $list;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if (accalia_exists_quickcal()) { require_once ACCALIA_THEME_DIR . 'plugins/quickcal/quickcal.styles.php'; }
?>