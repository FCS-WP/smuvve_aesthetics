<?php
/* WPBakery Page Builder Extensions Bundle support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('accalia_vc_extensions_theme_setup9')) {
	add_action( 'after_setup_theme', 'accalia_vc_extensions_theme_setup9', 9 );
	function accalia_vc_extensions_theme_setup9() {
		if (accalia_exists_visual_composer()) {
			add_action( 'wp_enqueue_scripts', 								'accalia_vc_extensions_frontend_scripts', 1100 );
			add_filter( 'accalia_filter_merge_styles',						'accalia_vc_extensions_merge_styles' );
		}
	
		if (is_admin()) {
			add_filter( 'accalia_filter_tgmpa_required_plugins',		'accalia_vc_extensions_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'accalia_vc_extensions_tgmpa_required_plugins' ) ) {
	function accalia_vc_extensions_tgmpa_required_plugins($list=array()) {
		if (in_array('vc-extensions-bundle', accalia_storage_get('required_plugins'))) {
			$path = accalia_get_file_dir('plugins/vc-extensions-bundle/vc-extensions-bundle.zip');
			$list[] = array(
					'name' 		=> esc_html__('WPBakery Page Builder Extensions Bundle', 'accalia'),
					'slug' 		=> 'vc-extensions-bundle',
					'version'	=> '3.6.6',
					'source'	=> !empty($path) ? $path : 'upload://vc-extensions-bundle.zip',
					'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if VC Extensions installed and activated
if ( !function_exists( 'accalia_exists_vc_extensions' ) ) {
	function accalia_exists_vc_extensions() {
		return class_exists('Vc_Manager') && class_exists('VC_Extensions_CQBundle');
	}
}
	
// Enqueue VC custom styles
if ( !function_exists( 'accalia_vc_extensions_frontend_scripts' ) ) {
	function accalia_vc_extensions_frontend_scripts() {
		if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('plugins/vc-extensions-bundle/vc-extensions-bundle.css')!='')
			wp_enqueue_style( 'accalia-vc-extensions-bundle',  accalia_get_file_url('plugins/vc-extensions-bundle/vc-extensions-bundle.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'accalia_vc_extensions_merge_styles' ) ) {
	function accalia_vc_extensions_merge_styles($list) {
		$list[] = 'plugins/vc-extensions-bundle/vc-extensions-bundle.css';
		return $list;
	}
}
?>