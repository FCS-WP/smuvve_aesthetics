<?php
// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Theme init
if (!function_exists('trx_addons_importer_theme_setup')) {
	add_action( 'after_setup_theme', 'trx_addons_importer_theme_setup' );
	function trx_addons_importer_theme_setup() {
		if (is_admin() && current_user_can('import')) {
			if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_IMPORTER . 'class.importer.php')) != '') { include_once $fdir; }
			new trx_addons_demo_data_importer();
		}
	}
}

if (!function_exists('trx_addons_importer_localize_script_admin')) {
	add_action( 'trx_addons_localize_script_admin', 'trx_addons_importer_localize_script_admin' );
	function trx_addons_importer_localize_script_admin($vars) {
		$vars['msg_importer_error'] = esc_html__('Errors that occurred during the import process:', 'trx_addons');
		return $vars;
	}
}
?>