<?php
/* Elementor Builder support functions
------------------------------------------------------------------------------- */

if (!defined('ACCALIA_ELEMENTOR_PADDINGS')) define('ACCALIA_ELEMENTOR_PADDINGS', 15);

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('accalia_elm_theme_setup9')) {
    add_action( 'after_setup_theme', 'accalia_elm_theme_setup9', 9 );
    function accalia_elm_theme_setup9() {

        add_filter( 'accalia_filter_merge_styles',					'accalia_elm_merge_styles' );

        if (accalia_exists_elementor()) {
            add_action( 'wp_enqueue_scripts', 						'accalia_elm_frontend_scripts', 1100 );
            add_action( 'elementor/element/before_section_end',		'accalia_elm_add_color_scheme_control', 10, 3 );
            add_action( 'elementor/element/after_section_end',		'accalia_elm_add_page_options', 10, 3 );
            add_action( 'init',										'accalia_elm_init_once', 3 );
        }
        if (is_admin()) {
            add_filter( 'accalia_filter_tgmpa_required_plugins',	'accalia_elm_tgmpa_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'accalia_elm_tgmpa_required_plugins' ) ) {
    function accalia_elm_tgmpa_required_plugins($list=array()) {
        if (in_array('elementor', accalia_storage_get('required_plugins')))
            $list[] = array(
                'name' 		=> esc_html__('Elementor', 'accalia'),
                'slug' 		=> 'elementor',
                'required' 	=> false
            );

        return $list;
    }
}

// Check if Elementor is installed and activated
if ( !function_exists( 'accalia_exists_elementor' ) ) {
    function accalia_exists_elementor() {
        return class_exists('Elementor\Plugin');
    }
}

// Merge custom styles
if ( !function_exists( 'accalia_elm_merge_styles' ) ) {
    //Handler of the add_filter('accalia_filter_merge_styles', 'accalia_elm_merge_styles');
    function accalia_elm_merge_styles($list) {
        if (accalia_exists_elementor()) {
            $list[] = 'plugins/elementor/elementor.css';
        }
        return $list;
    }
}

// Enqueue ELM custom styles
if ( !function_exists( 'accalia_elm_frontend_scripts' ) ) {
    function accalia_elm_frontend_scripts() {
        if (accalia_exists_elementor()) {
            if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('plugins/elementor/elementor.css')!='')
                wp_enqueue_style( 'accalia-elementor',  accalia_get_file_url('plugins/elementor/elementor.css'), array(), null );
        }
    }
}

// Load required styles and scripts for Elementor Editor mode
if ( !function_exists( 'accalia_elm_editor_load_scripts' ) ) {
    add_action("elementor/editor/before_enqueue_scripts", 'accalia_elm_editor_load_scripts');
    function accalia_elm_editor_load_scripts() {
        // Load font icons
        wp_enqueue_style(  'accalia-icons', accalia_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
    }
}

// Add control to select color scheme in the sections and columns
if (!function_exists('accalia_elm_add_color_scheme_control')) {
    //Handler of the add_action( 'elementor/element/before_section_end', 'accalia_elm_add_color_scheme_control', 10, 3 );
    function accalia_elm_add_color_scheme_control($element, $section_id, $args) {
        if ( is_object($element) ) {
            $el_name = $element->get_name();
            if (apply_filters('accalia_filter_add_scheme_in_elements',
                (in_array($el_name, array('section', 'column')) && $section_id === 'section_advanced')
                || ($el_name === 'common' && $section_id === '_section_style'),
                $element, $section_id, $args)) {
                $element->add_control('scheme', array(
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label' => esc_html__("Color scheme", 'accalia'),
                    'label_block' => true,
                    'options' => accalia_array_merge(array('' => __('Inherit', 'accalia')), accalia_get_list_schemes()),
                    'default' => '',
                    'prefix_class' => 'scheme_'
                ) );
            }
        }
    }
}

// Add tab with Page Options
if (!function_exists('accalia_elm_add_page_options')) {
    //Handler of the add_action( 'elementor/element/after_section_end',		'accalia_elm_add_page_options', 10, 3 );
    function accalia_elm_add_page_options($element, $section_id, $args) {
        if ( is_object($element) ) {
            $el_name = $element->get_name();
            if ( in_array( $el_name, array( 'page-settings', 'post', 'wp-post', 'wp-page' ) ) && 'section_page_style' == $section_id ) {
                $post_id = get_the_ID();
                $post_type = get_post_type($post_id);
                if ($post_id > 0) {
                    $element->start_controls_section(
                        'section_theme_options',
                        [
                            'label' => __('Theme Options', 'accalia'),
                            'tab' => \Elementor\Controls_Manager::TAB_ADVANCED
                        ]
                    );

                    // Roadmap: Add current page options to this section in the near future release

                    $element->end_controls_section();
                }
            }
        }
    }
}

// Set Elementor's options at once
if (!function_exists('accalia_elm_init_once')) {
    //Handler of the add_action( 'init', 'accalia_elm_init_once', 3 );
    function accalia_elm_init_once() {
        if (accalia_exists_elementor() && !get_option('accalia_setup_elementor_options', false)) {
            // Set theme-specific values to the Elementor's options
            update_option('elementor_disable_color_schemes', 'yes');
            update_option('elementor_disable_typography_schemes', 'yes');
            update_option('elementor_container_width', 1170);
            update_option('elementor_space_between_widgets', 0);
            update_option('elementor_stretched_section_container', '.body_wrap');
            update_option('elementor_page_title_selector', '.elementor-widget-trx_sc_layouts_title,.elementor-widget-trx_sc_layouts_featured');
            // Set flag to prevent change Elementor's options again
            update_option('accalia_setup_elementor_options', 1);
        }
    }
}


// Add plugin-specific colors and fonts to the custom CSS
if (accalia_exists_elementor()) { require_once ACCALIA_THEME_DIR . 'plugins/elementor/elementor-styles.php'; }
?>