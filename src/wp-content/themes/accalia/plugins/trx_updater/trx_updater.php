<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'accalia_trx_updater_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'accalia_trx_updater_theme_setup9', 9 );
	function accalia_trx_updater_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'accalia_filter_tgmpa_required_plugins', 'accalia_trx_updater_tgmpa_required_plugins', 8 );
		}
	}
}


// Filter to add in the required plugins list
if ( !function_exists( 'accalia_trx_updater_tgmpa_required_plugins' ) ) {
    function accalia_trx_updater_tgmpa_required_plugins($list=array()) {
        if (in_array('trx_updater', accalia_storage_get('required_plugins'))) {
            $path = accalia_get_file_dir('plugins/trx_updater/trx_updater.zip');
            $list[] = array(
                'name' 		=> esc_html__('ThemeREX Updater', 'accalia'),
                'slug'     => 'trx_updater',
                'version'  => '2.1.4',
                'source'	=> !empty($path) ? $path : 'upload://trx_updater.zip',
                'required' => false,
            );
        }
        return $list;
    }
}

// Check if plugin installed and activated
if ( ! function_exists( 'accalia_exists_trx_updater' ) ) {
	function accalia_exists_trx_updater() {
		return defined( 'TRX_UPDATER_VERSION' );
	}
}
