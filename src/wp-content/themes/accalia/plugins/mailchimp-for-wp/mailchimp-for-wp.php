<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('accalia_mailchimp_theme_setup9')) {
	add_action( 'after_setup_theme', 'accalia_mailchimp_theme_setup9', 9 );
	function accalia_mailchimp_theme_setup9() {
		if (accalia_exists_mailchimp()) {
			add_action( 'wp_enqueue_scripts',							'accalia_mailchimp_frontend_scripts', 1100 );
			add_filter( 'accalia_filter_merge_styles',					'accalia_mailchimp_merge_styles');
		}
		if (is_admin()) {
			add_filter( 'accalia_filter_tgmpa_required_plugins',		'accalia_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'accalia_exists_mailchimp' ) ) {
	function accalia_exists_mailchimp() {
		return function_exists('__mc4wp_load_plugin') || defined('MC4WP_VERSION');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'accalia_mailchimp_tgmpa_required_plugins' ) ) {
	function accalia_mailchimp_tgmpa_required_plugins($list=array()) {
		if (in_array('mailchimp-for-wp', accalia_storage_get('required_plugins')))
			$list[] = array(
				'name' 		=> esc_html__('MailChimp for WP', 'accalia'),
				'slug' 		=> 'mailchimp-for-wp',
				'required' 	=> false
			);
		return $list;
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue custom styles
if ( !function_exists( 'accalia_mailchimp_frontend_scripts' ) ) {
	function accalia_mailchimp_frontend_scripts() {
		if (accalia_exists_mailchimp()) {
			if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('plugins/mailchimp-for-wp/mailchimp-for-wp.css')!='')
				wp_enqueue_style( 'accalia-mailchimp-for-wp',  accalia_get_file_url('plugins/mailchimp-for-wp/mailchimp-for-wp.css'), array(), null );
		}
	}
}
	
// Merge custom styles
if ( !function_exists( 'accalia_mailchimp_merge_styles' ) ) {
	function accalia_mailchimp_merge_styles($list) {
		$list[] = 'plugins/mailchimp-for-wp/mailchimp-for-wp.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (accalia_exists_mailchimp()) { require_once ACCALIA_THEME_DIR . 'plugins/mailchimp-for-wp/mailchimp-for-wp.styles.php'; }
?>