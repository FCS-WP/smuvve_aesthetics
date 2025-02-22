<?php
/**
 * Shortcode: Price block
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_price_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_price_load_scripts_front');
	function trx_addons_sc_price_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_price', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'price/price.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_price_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_sc_price_merge_styles');
	function trx_addons_sc_price_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'price/price.css';
		return $list;
	}
}



// trx_sc_price
//-------------------------------------------------------------
/*
[trx_sc_price id="unique_id" title="Our plan" link="#" link_text="Buy now"]Description[/trx_sc_price]
*/
if ( !function_exists( 'trx_addons_sc_price' ) ) {
	function trx_addons_sc_price($atts, $content = ''){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_price', $atts, array(
			// Individual params
			"type" => 'default',
			"columns" => "",
			"slider" => 0,
			"slider_pagination" => "none",
			"slider_controls" => "none",
			"slides_space" => 0,
			"prices" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_image" => '',
			"link_text" => esc_html__('Learn more', 'trx_addons'),
			"title_align" => "left",
			"title_style" => "default",
			"title_tag" => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		if (function_exists('vc_param_group_parse_atts'))
			$atts['prices'] = (array) vc_param_group_parse_atts( $atts['prices'] );
		if (!is_array($atts['prices']) || count($atts['prices']) == 0) return '';

		if (empty($atts['columns'])) $atts['columns'] = count($atts['prices']);
		$atts['columns'] = max(1, min(count($atts['prices']), $atts['columns']));
		$atts['slider'] = $atts['slider'] > 0 && count($atts['prices']) > $atts['columns'];
		$atts['slides_space'] = max(0, (int) $atts['slides_space']);
		if ($atts['slider'] > 0 && (int) $atts['slider_pagination'] > 0) $atts['slider_pagination'] = 'bottom';

		foreach ($atts['prices'] as $k=>$v)
			if (!empty($v['description'])) $atts['prices'][$k]['description'] = preg_replace( '/\\[(.*)\\]/', '<b>$1</b>', vc_value_from_safe( $v['description'] ) );

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_SHORTCODES . 'price/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_SHORTCODES . 'price/tpl.default.php'
										),
                                        'trx_addons_args_sc_price',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_price', $atts, $content);
	}
}


// Add [trx_sc_price] in the VC shortcodes list
if (!function_exists('trx_addons_sc_price_add_in_vc')) {
	function trx_addons_sc_price_add_in_vc() {
		
		if (!trx_addons_exists_visual_composer()) return;
		
		add_shortcode("trx_sc_price", "trx_addons_sc_price");
		
		vc_lean_map("trx_sc_price", 'trx_addons_sc_price_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Price extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_price_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_price_add_in_vc_params')) {
	function trx_addons_sc_price_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_price",
				"name" => esc_html__("Price", 'trx_addons'),
				"description" => wp_kses_data( __("Add block with prices", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_price',
				"class" => "trx_sc_price",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"std" => "default",
							"value" => apply_filters('trx_addons_sc_type', array_flip(trx_addons_components_get_allowed_layouts('sc', 'price')), 'trx_sc_price' ),
							"type" => "dropdown"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", 'trx_addons'),
							"description" => wp_kses_data( __("Specify number of columns for icons. If empty - auto detect by items number", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							'type' => 'param_group',
							'param_name' => 'prices',
							'heading' => esc_html__( 'Prices', 'trx_addons' ),
							"description" => wp_kses_data( __("Select icon, specify price, title and/or description for each item", 'trx_addons') ),
							'value' => urlencode( json_encode( apply_filters('trx_addons_sc_param_group_value', array(
											array(
												'title' => esc_html__( 'One', 'trx_addons' ),
												'subtitle' => '',
												'description' => '',
												'details' => '',
												'link' => '',
												'link_text' => '',
												'label' => '',
												'price' => '',
												'before_price' => '',
												'after_price' => '',
												'image' => '',
												'bg_color' => '',
												'bg_image' => '',
												'icon' => '',
												'icon_fontawesome' => 'empty',
												'icon_openiconic' => 'empty',
												'icon_typicons' => 'empty',
												'icon_entypo' => 'empty',
												'icon_linecons' => 'empty'
											),
										), 'trx_sc_action') ) ),
							'params' => apply_filters('trx_addons_sc_param_group_params', array_merge(array(
									array(
										'param_name' => 'title',
										'heading' => esc_html__( 'Title', 'trx_addons' ),
										'description' => esc_html__( 'Title of the price', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-4',
										'admin_label' => true,
										'type' => 'textfield',
									),
									array(
										'param_name' => 'subtitle',
										'heading' => esc_html__( 'Subtitle', 'trx_addons' ),
										'description' => esc_html__( 'Subtitle of the price', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-4',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'label',
										'heading' => esc_html__( 'Label', 'trx_addons' ),
										'description' => esc_html__( 'If not empty - colored band with this text is showed at the top corner of price block', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-4',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'description',
										'heading' => esc_html__( 'Description', 'trx_addons' ),
										'description' => esc_html__( 'Price description', 'trx_addons' ),
										'type' => 'textfield',
									),
									array(
										'param_name' => 'before_price',
										'heading' => esc_html__( 'Before price', 'trx_addons' ),
										'description' => esc_html__( 'Any text before the price value', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-4 vc_new_row',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'price',
										'heading' => esc_html__( 'Price', 'trx_addons' ),
										'description' => esc_html__( 'Price value', 'trx_addons' ),
										'admin_label' => true,
										'edit_field_class' => 'vc_col-sm-4',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'after_price',
										'heading' => esc_html__( 'After price', 'trx_addons' ),
										'description' => esc_html__( 'Any text after the price value', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-4',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'details',
										'heading' => esc_html__( 'Details', 'trx_addons' ),
										'description' => esc_html__( 'Price details', 'trx_addons' ),
										'type' => 'textarea',
									),
									array(
										'param_name' => 'link',
										'heading' => esc_html__( 'Link', 'trx_addons' ),
										'description' => esc_html__( 'Specify URL for the button under decription', 'trx_addons' ),
										'admin_label' => true,
										'edit_field_class' => 'vc_col-sm-6 vc_new_row',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'link_text',
										'heading' => esc_html__( 'Link text', 'trx_addons' ),
										'description' => esc_html__( 'Specify text for the button under decription', 'trx_addons' ),
										'dependency' => array(
											'element' => 'link',
											'not_empty' => true,
										),
										'edit_field_class' => 'vc_col-sm-6',
										'admin_label' => true,
										'type' => 'textfield',
									),
									array(
										"param_name" => "image",
										"heading" => esc_html__("Image", 'trx_addons'),
										"description" => wp_kses_data( __("Select or upload image to display it at top of this item", 'trx_addons') ),
										'edit_field_class' => 'vc_col-sm-4 vc_new_row',
										"type" => "attach_image"
									),
									array(
										"param_name" => "bg_image",
										"heading" => esc_html__("Background image", 'trx_addons'),
										"description" => wp_kses_data( __("Select or upload image to use it as background of this item", 'trx_addons') ),
										'edit_field_class' => 'vc_col-sm-4',
										"type" => "attach_image"
									),
									array(
										'param_name' => 'bg_color',
										'heading' => esc_html__( 'Background Color', 'trx_addons' ),
										'description' => esc_html__( 'Select custom background color of this item', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-4',
										'type' => 'colorpicker'
									),
								),
								trx_addons_vc_add_icon_param('')
							), 'trx_sc_price')
						)
					),
					trx_addons_vc_add_slider_param(),
					trx_addons_vc_add_title_param(),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_price' );
	}
}
?>