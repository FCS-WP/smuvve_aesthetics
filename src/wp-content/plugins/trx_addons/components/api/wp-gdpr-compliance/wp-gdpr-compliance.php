<?php
/**
 * Plugin support: WP GDPR Compliance (Importer support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since 1.6.29.1
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_wp_gdpr_compliance' ) ) {
	function trx_addons_exists_wp_gdpr_compliance() {
        return defined( 'WP_GDPR_C_ROOT_FILE' ) || defined( 'WPGDPRC_ROOT_FILE' );
	}
}


// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_wp_gdpr_compliance_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_wp_gdpr_compliance_importer_required_plugins', 10, 2 );
	function trx_addons_wp_gdpr_compliance_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'wp-gdpr-compliance')!==false && !trx_addons_exists_wp_gdpr_compliance() )
			$not_installed .= '<br>' . esc_html__('Cookie Information', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_wp_gdpr_compliance_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'trx_addons_wp_gdpr_compliance_importer_set_options' );
	function trx_addons_wp_gdpr_compliance_importer_set_options($options=array()) {
		if ( trx_addons_exists_wp_gdpr_compliance() && in_array('wp-gdpr-compliance', $options['required_plugins']) ) {
			if (is_array($options)) {
				$options['additional_options'][] = 'wpgdprc_%';
			}
		}
		return $options;
	}
}

