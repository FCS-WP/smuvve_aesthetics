<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('accalia_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'accalia_revslider_theme_setup9', 9 );
	function accalia_revslider_theme_setup9() {
		if (accalia_exists_revslider()) {
			add_action( 'wp_enqueue_scripts', 					'accalia_revslider_frontend_scripts', 1100 );
			add_filter( 'accalia_filter_merge_styles',			'accalia_revslider_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'accalia_filter_tgmpa_required_plugins','accalia_revslider_tgmpa_required_plugins' );
		}
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'accalia_exists_revslider' ) ) {
	function accalia_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'accalia_revslider_tgmpa_required_plugins' ) ) {
	function accalia_revslider_tgmpa_required_plugins($list=array()) {
		if (in_array('revslider', accalia_storage_get('required_plugins'))) {
			$path = accalia_get_file_dir('plugins/revslider/revslider.zip');
			$list[] = array(
					'name' 		=> esc_html__('Revolution Slider', 'accalia'),
					'slug' 		=> 'revslider',
					'version'	=> '6.7.14',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'required' 	=> false
			);
		}
		return $list;
	}
}
	
// Enqueue custom styles
if ( !function_exists( 'accalia_revslider_frontend_scripts' ) ) {
	function accalia_revslider_frontend_scripts() {
		if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('plugins/revslider/revslider.css')!='')
			wp_enqueue_style( 'accalia-revslider',  accalia_get_file_url('plugins/revslider/revslider.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'accalia_revslider_merge_styles' ) ) {
	function accalia_revslider_merge_styles($list) {
		$list[] = 'plugins/revslider/revslider.css';
		return $list;
	}
}
?>