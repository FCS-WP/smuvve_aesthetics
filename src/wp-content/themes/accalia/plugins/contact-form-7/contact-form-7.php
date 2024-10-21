<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('accalia_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'accalia_cf7_theme_setup9', 9 );
	function accalia_cf7_theme_setup9() {
		add_filter('wpcf7_autop_or_not', '__return_false');
		if (is_admin()) {
			add_filter( 'accalia_filter_tgmpa_required_plugins',			'accalia_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'accalia_cf7_tgmpa_required_plugins' ) ) {
	function accalia_cf7_tgmpa_required_plugins($list=array()) {
		if (in_array('contact-form-7', accalia_storage_get('required_plugins'))) {
			// CF7 plugin
			$list[] = array(
					'name' 		=>  esc_html__('Contact Form 7', 'accalia'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
			);
		}
		return $list;
	}
}


// Check if cf7 installed and activated
if ( !function_exists( 'accalia_exists_cf7' ) ) {
	function accalia_exists_cf7() {
		return class_exists('WPCF7');
	}
}
?>