<?php
/**
 * Plugin support: Contact Form 7
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */


// Check if Contact Form 7 installed and activated
if ( !function_exists( 'trx_addons_exists_cf7' ) ) {
	function trx_addons_exists_cf7() {
		return class_exists('WPCF7') && class_exists('WPCF7_ContactForm');
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_cf7_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_cf7_importer_required_plugins', 10, 2 );
	function trx_addons_cf7_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'contact-form-7')!==false && !trx_addons_exists_cf7() )
			$not_installed .= '<br>' . esc_html__('Contact Form 7', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_cf7_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_cf7_importer_set_options' );
	function trx_addons_cf7_importer_set_options($options=array()) {
		if ( trx_addons_exists_cf7() && in_array('contact-form-7', $options['required_plugins']) ) {
			$options['additional_options'][] = 'wpcf7';
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_cf7_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_cf7_importer_show_params', 10, 1 );
	function trx_addons_cf7_importer_show_params($importer) {
		if ( trx_addons_exists_cf7() && in_array('contact-form-7', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'contact-form-7',
				'title' => esc_html__('Import Contact Form 7', 'trx_addons'),
				'part' => 1
			));
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_cf7_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_addons_filter_importer_import_row', 'trx_addons_cf7_importer_check_row', 9, 4);
	function trx_addons_cf7_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'contact-form-7')===false) return $flag;
		if ( trx_addons_exists_cf7() ) {
			if ($table == 'posts')
				$flag = $row['post_type']==WPCF7_ContactForm::post_type;
		}
		return $flag;
	}
}

// Load required scripts and styles
//------------------------------------------------------------------------


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_cf7_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_cf7_load_scripts_front', 11);
	function trx_addons_cf7_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-contact-form-7', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'contact-form-7/contact-form-7.css'), array(), null );
			wp_enqueue_script( 'trx_addons-contact-form-7', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'contact-form-7/contact-form-7.js'), array('jquery'), null, true );
		}
	}
}

	
// Merge specific styles into single stylesheet
if ( !function_exists( 'trx_addons_cf7_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_cf7_merge_styles');
	function trx_addons_cf7_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_API . 'contact-form-7/contact-form-7.css';
		return $list;
	}
}

	
// Merge specific scripts into single file
if ( !function_exists( 'trx_addons_cf7_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_cf7_merge_scripts', 11);
	function trx_addons_cf7_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_API . 'contact-form-7/contact-form-7.js';
		return $list;
	}
}
?>