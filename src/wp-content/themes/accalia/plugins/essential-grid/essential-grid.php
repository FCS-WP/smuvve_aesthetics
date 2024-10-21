<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('accalia_essential_grid_theme_setup9')) {
	add_action( 'after_setup_theme', 'accalia_essential_grid_theme_setup9', 9 );
	function accalia_essential_grid_theme_setup9() {
		if (accalia_exists_essential_grid()) {
			add_action( 'wp_enqueue_scripts', 							'accalia_essential_grid_frontend_scripts', 1100 );
			add_filter( 'accalia_filter_merge_styles',					'accalia_essential_grid_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'accalia_filter_tgmpa_required_plugins',		'accalia_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'accalia_exists_essential_grid' ) ) {
	function accalia_exists_essential_grid() {
        return defined('EG_PLUGIN_PATH') || defined( 'ESG_PLUGIN_PATH' );
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'accalia_essential_grid_tgmpa_required_plugins' ) ) {
	function accalia_essential_grid_tgmpa_required_plugins($list=array()) {
		if (in_array('essential-grid', accalia_storage_get('required_plugins'))) {
			$path = accalia_get_file_dir('plugins/essential-grid/essential-grid.zip');
			$list[] = array(
						'name' 		=> esc_html__('Essential Grid', 'accalia'),
						'slug' 		=> 'essential-grid',
						'version'	=> '3.1.3',
						'source'	=> !empty($path) ? $path : 'upload://essential-grid.zip',
						'required' 	=> false
			);
		}
		return $list;
	}
}
	
// Enqueue plugin's custom styles
if ( !function_exists( 'accalia_essential_grid_frontend_scripts' ) ) {
	function accalia_essential_grid_frontend_scripts() {
		if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('plugins/essential-grid/essential-grid.css')!='')
			wp_enqueue_style( 'accalia-essential-grid',  accalia_get_file_url('plugins/essential-grid/essential-grid.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'accalia_essential_grid_merge_styles' ) ) {
	function accalia_essential_grid_merge_styles($list) {
		$list[] = 'plugins/essential-grid/essential-grid.css';
		return $list;
	}
}
?>