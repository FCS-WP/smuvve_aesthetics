<?php
/**
 * ThemeREX Addons Layouts: WPBakery Page Builder utilities
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Init VC support
if (!function_exists('trx_addons_cpt_layouts_vc_init')) {
	add_action( 'init', 'trx_addons_cpt_layouts_vc_init' );
	function trx_addons_cpt_layouts_vc_init() {
		// Row type
		$param = array(
			"param_name" => "row_type",
			"heading" => esc_html__("Row type", 'trx_addons'),
			"description" => wp_kses_data( __("Select row type to decorate header widgets. Attention! Use this parameter to decorate custom layouts only!", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			'edit_field_class' => 'vc_col-sm-4',
			"admin_label" => true,
			"value" => array(
				esc_html__('Inherit', 'trx_addons') => 'inherit',
				esc_html__('Narrow', 'trx_addons') => 'narrow',
				esc_html__('Compact', 'trx_addons') => 'compact',
				esc_html__('Normal', 'trx_addons') => 'normal'
			),
			"std" => "inherit",
			"type" => "dropdown"
		);
		vc_add_param("vc_row", $param);
		vc_add_param("vc_row_inner", $param);

		// Delimiter after the row
		$param = array(
			"param_name" => "row_delimiter",
			"heading" => esc_html__("Delimiter", 'trx_addons'),
			"description" => wp_kses_data( __("Show delimiter after the row.", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			'edit_field_class' => 'vc_col-sm-4',
			"admin_label" => true,
			"std" => "0",
			"value" => array(esc_html__("Show delimiter", 'trx_addons') => "1" ),
			"type" => "checkbox"
		);
		vc_add_param("vc_row", $param);
		vc_add_param("vc_row_inner", $param);

		// Fix row when scroll
		$param = array(
			"param_name" => "row_fixed",
			"heading" => esc_html__("Fix this row when scroll", 'trx_addons'),
			"description" => wp_kses_data( __("Fix this row to the top of the window when scrolling down", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			'edit_field_class' => 'vc_col-sm-4',
			"admin_label" => true,
			"std" => "0",
			"value" => array(esc_html__("Fix this row", 'trx_addons') => "1" ),
			"type" => "checkbox"
		);
		vc_add_param("vc_row", $param);

		// Hide row on tablets
		$param = array(
			"param_name" => "hide_on_tablet",
			"heading" => esc_html__("Hide on tablets", 'trx_addons'),
			"description" => wp_kses_data( __("Hide this item on tablets", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			'edit_field_class' => 'vc_col-sm-4',
			"std" => "0",
			"value" => array(esc_html__("Hide on tablets", 'trx_addons') => "1" ),
			"type" => "checkbox"
		);
		vc_add_param("vc_row", $param);

		// Hide row on mobile
		$param = array(
			"param_name" => "hide_on_mobile",
			"heading" => esc_html__("Hide on mobile devices", 'trx_addons'),
			"description" => wp_kses_data( __("Hide this item on mobile devices", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			'edit_field_class' => 'vc_col-sm-4',
			"std" => "0",
			"value" => array(esc_html__("Hide on mobile devices", 'trx_addons') => "1" ),
			"type" => "checkbox"
		);
		vc_add_param("vc_row", $param);

		// Hide row on front page
		$param = array(
			"param_name" => "hide_on_frontpage",
			"heading" => esc_html__("Hide on the Frontpage", 'trx_addons'),
			"description" => wp_kses_data( __("Hide this item on the Frontpage", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			'edit_field_class' => 'vc_col-sm-4',
			"std" => "0",
			"value" => array(esc_html__("Hide on the Frontpage", 'trx_addons') => "1" ),
			"type" => "checkbox"
		);
		vc_add_param("vc_row", $param);

		// Alignment inner items in the column
		$param = array(
			"param_name" => "column_align",
			"heading" => esc_html__("Column alignment", 'trx_addons'),
			"description" => wp_kses_data( __("Select alignment of the inner widgets in this column. Attention! Use this parameter to decorate custom layouts only!", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			"admin_label" => true,
			"value" => array(
				esc_html__('Inherit', 'trx_addons') => 'inherit',
				esc_html__('Left', 'trx_addons') => 'left',
				esc_html__('Center', 'trx_addons') => 'center',
				esc_html__('Right', 'trx_addons') => 'right'
			),
			"std" => "inherit",
			"type" => "dropdown"
		);
		vc_add_param("vc_column", $param);
		vc_add_param("vc_column_inner", $param);

		// Icon's position in the inner items
		$param = array(
			"param_name" => "icons_position",
			"heading" => esc_html__("Icons position", 'trx_addons'),
			"description" => wp_kses_data( __("Select icons position of the inner widgets 'Layouts: xxx' in this column. Attention! Use this parameter to decorate custom layouts only!", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			"admin_label" => true,
			"value" => array(
				esc_html__('Left', 'trx_addons') => 'left',
				esc_html__('Right', 'trx_addons') => 'right'
			),
	        'save_always' => true,
			"type" => "dropdown"
		);
		vc_add_param("vc_column", $param);
		vc_add_param("vc_column_inner", $param);

		// Allow insert our container elements to the inner columns
		vc_map_update('vc_column_inner', array('allowed_container_element' => true));
	}
}

// Add params to the standard VC shortcodes
if ( !function_exists( 'trx_addons_cpt_layouts_vc_add_params_classes' ) ) {
	add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'trx_addons_cpt_layouts_vc_add_params_classes', 10, 3 );
	function trx_addons_cpt_layouts_vc_add_params_classes($classes, $sc, $atts) {
		if (in_array($sc, array('vc_row', 'vc_row_inner'))) {
			if (!empty($atts['row_type']) && !trx_addons_is_inherit($atts['row_type']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_row sc_layouts_row_type_' . $atts['row_type'];
			if (!empty($atts['row_delimiter']) && !trx_addons_is_inherit($atts['row_delimiter']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_row_delimiter';
			if ($sc == 'vc_row' && !empty($atts['row_fixed']) && !trx_addons_is_inherit($atts['row_fixed']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_row_fixed';
			if ($sc == 'vc_row' && !empty($atts['hide_on_tablet']) && !trx_addons_is_inherit($atts['hide_on_tablet']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_hide_on_tablet';
			if ($sc == 'vc_row' && !empty($atts['hide_on_mobile']) && !trx_addons_is_inherit($atts['hide_on_mobile']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_hide_on_mobile';
			if ($sc == 'vc_row' && !empty($atts['hide_on_frontpage']) && !trx_addons_is_inherit($atts['hide_on_frontpage']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_hide_on_frontpage';
		} else if (in_array($sc, array('vc_column', 'vc_column_inner'))) {
			if (!empty($atts['column_align']) && !trx_addons_is_inherit($atts['column_align']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_column sc_layouts_column_align_' . $atts['column_align'];
			if (!empty($atts['icons_position']) && !trx_addons_is_inherit($atts['icons_position']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_column_icons_position_' . $atts['icons_position'];
		}
		return $classes;
	}
}

// Shortcodes utilities
// -----------------------------------------------------------------

// Generate content to show layout
if ( !function_exists( 'trx_addons_cpt_layouts_vc_layout_content' ) ) {
    add_filter( 'trx_addons_filter_sc_layout_content', 'trx_addons_cpt_layouts_vc_layout_content', 11, 2 );
    function trx_addons_cpt_layouts_vc_layout_content($content, $id)
    {
            global $TRX_ADDONS_STORAGE;
            $TRX_ADDONS_STORAGE['inside_cpt_layouts'] = true;

            if (! empty( $content) &&  strpos($content, '[vc_row') !== false) {
                // In WordPress 4.9 post content wrapped with <p>...</p>
                // and shortcode_unautop() not remove it - do it manual
                if (strpos($content, '<p>[vc_row') !== false || strpos($content, '<p>[vc_section') !== false) {
                    $content = str_replace(
                        array('<p>[vc_row', '[/vc_row]</p>', '<p>[vc_section', '[/vc_section]</p>'),
                        array('[vc_row', '[/vc_row]', '[vc_section', '[/vc_section]'),
                        $content);
                }
                trx_addons_show_layout(do_shortcode(str_replace(array('{{Y}}', '{Y}'), date('Y'),$content)));
            }
            $TRX_ADDONS_STORAGE['inside_cpt_layouts'] = false;
            // Add VC custom styles to the inline CSS
            $vc_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
            if ( !empty( $vc_custom_css ) ) trx_addons_add_inline_css(strip_tags($vc_custom_css));
        }
}

// Add params to the ThemeREX Addons shortcode's atts
if ( !function_exists( 'trx_addons_cpt_layouts_sc_atts' ) ) {
	add_filter( 'trx_addons_sc_atts', 'trx_addons_cpt_layouts_sc_atts', 10, 2);
	function trx_addons_cpt_layouts_sc_atts($atts, $sc) {

		// Param 'scheme'
		if (in_array($sc, array('trx_sc_button', 'trx_sc_socials'))) {
			$atts['hide_on_tablet'] = '0';
			$atts['hide_on_mobile'] = '0';
		}
		return $atts;
	}
}

// Add params into ThemeREX Addons shortcodes VC map
if ( !function_exists( 'trx_addons_cpt_layouts_sc_map' ) ) {
	add_filter( 'trx_addons_sc_map', 'trx_addons_cpt_layouts_sc_map', 10, 2);
	function trx_addons_cpt_layouts_sc_map($params, $sc) {

		// Param 'hide_on_mobile'
		if (in_array($sc, array('trx_sc_button', 'trx_sc_socials')))
			$params['params'] = array_merge($params['params'], trx_addons_vc_add_hide_param());
		return $params;
	}
}

// Add params into ThemeREX Addons shortcode's output
if ( !function_exists( 'trx_addons_cpt_layouts_sc_output' ) ) {
	add_filter( 'trx_addons_sc_output', 'trx_addons_cpt_layouts_sc_output', 10, 4);
	function trx_addons_cpt_layouts_sc_output($output, $sc, $atts, $content) {

		// Param 'hide_on_mobile'
		if (in_array($sc, array('trx_sc_button'))) {
			if (!empty($atts['hide_on_tablet']) && !trx_addons_is_inherit($atts['hide_on_tablet']))
				$output = str_replace('class="sc_button ', 'class="sc_button hide_on_tablet ', $output);
			if (!empty($atts['hide_on_mobile']) && !trx_addons_is_inherit($atts['hide_on_mobile']))
				$output = str_replace('class="sc_button ', 'class="sc_button hide_on_mobile ', $output);
		} else if (in_array($sc, array('trx_sc_socials'))) {
			if (!empty($atts['hide_on_tablet']) && !trx_addons_is_inherit($atts['hide_on_tablet']))
				$output = str_replace('class="sc_socials ', 'class="sc_socials hide_on_tablet ', $output);
			if (!empty($atts['hide_on_mobile']) && !trx_addons_is_inherit($atts['hide_on_mobile']))
				$output = str_replace('class="sc_socials ', 'class="sc_socials hide_on_mobile ', $output);
		}
		return $output;
	}
}

if (!defined('TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES')) define('TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES', TRX_ADDONS_PLUGIN_CPT.'layouts/shortcodes/');

// Include shortcodes for the Layouts builder
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "iconed_text/iconed_text.php")) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "logo/logo.php")) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "login/login.php")) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "search/search.php")) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "cart/cart.php")) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "menu/menu.php")) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "title/title.php")) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "featured/featured.php")) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "currency/currency.php")) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "language/language.php")) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "widgets/widgets.php")) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "container/container.php")) != '') { include_once $fdir; }
?>