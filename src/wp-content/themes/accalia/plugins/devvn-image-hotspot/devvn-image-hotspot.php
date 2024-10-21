<?php
/* devvn-image-hotspot support functions
------------------------------------------------------------------------------- */

// Filter to add in the required plugins list
if ( !function_exists( 'accalia_devvn_image_hotspot_tgmpa_required_plugins' ) ) {
    function accalia_devvn_image_hotspot_tgmpa_required_plugins($list=array()) {
        if (in_array('devvn-image-hotspot', accalia_storage_get('required_plugins')))
            $list[] = array(
                'name' 		=> esc_html__('Image Hotspot by DevVN', 'accalia'),
                'slug' 		=> 'devvn-image-hotspot',
                'required' 	=> false
            );

        return $list;
    }
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('accalia_devvn_image_hotspot_theme_setup9')) {
    add_action( 'after_setup_theme', 'accalia_devvn_image_hotspot_theme_setup9', 9 );
    function accalia_devvn_image_hotspot_theme_setup9() {
        if (accalia_exists_devvn_image_hotspot()) {
            add_filter( 'accalia_filter_merge_styles',			'accalia_devvn_image_hotspot_merge_styles' );
            add_action( 'wp_enqueue_scripts', 						'accalia_devvn_image_hotspot_frontend_scripts', 1100 );
        }
        if (is_admin()) {
            add_filter( 'accalia_filter_tgmpa_required_plugins','accalia_devvn_image_hotspot_tgmpa_required_plugins' );
        }
    }
}

// Check if Devvn Image Hotspot installed and activated
if ( !function_exists( 'accalia_exists_devvn_image_hotspot' ) ) {
    function accalia_exists_devvn_image_hotspot() {
        return function_exists('devvn_ihotspot_meta_box');
    }
}

// Enqueue Devvn Image Hotspot custom styles
if ( !function_exists( 'accalia_devvn_image_hotspot_frontend_scripts' ) ) {
    function accalia_devvn_image_hotspot_frontend_scripts() {
        if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('plugins/devvn-image-hotspot/devvn-image-hotspot.css')!='')
            wp_enqueue_style( 'accalia-devvn-image-hotspot',  accalia_get_file_url('plugins/devvn-image-hotspot/devvn-image-hotspot.css'), array(), null );
    }
}

// Merge custom styles
if ( !function_exists( 'accalia_devvn_image_hotspot_merge_styles' ) ) {
    function accalia_devvn_image_hotspot_merge_styles($list) {
        $list[] = 'plugins/devvn-image-hotspot/devvn-image-hotspot.css';
        return $list;
    }
}

