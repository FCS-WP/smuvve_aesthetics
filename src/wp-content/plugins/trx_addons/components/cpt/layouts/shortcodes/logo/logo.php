<?php
/**
 * Shortcode: Display site Logo
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_layouts_logo_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_layouts_logo_load_scripts_front');
	function trx_addons_sc_layouts_logo_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_layouts_logo', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'logo/logo.css'), array(), null );
		}
	}
}

	
// Merge shortcode specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_layouts_logo_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_layouts_logo_merge_styles');
	add_filter("trx_addons_filter_merge_styles_layouts", 'trx_addons_sc_layouts_logo_merge_styles');
	function trx_addons_sc_layouts_logo_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'logo/logo.css';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_sc_layouts_logo_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_layouts_logo_merge_scripts');
	function trx_addons_sc_layouts_logo_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'logo/logo.js';
		return $list;
	}
}



// trx_sc_layouts_logo
//-------------------------------------------------------------
/*
[trx_sc_layouts_logo id="unique_id" logo="image_url" logo_retina="image_url"]
*/
if ( !function_exists( 'trx_addons_sc_layouts_logo' ) ) {
	function trx_addons_sc_layouts_logo($atts, $content = ''){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_layouts_logo', $atts, array(
			// Individual params
			"type" => "default",
			"logo" => "",
			"logo_retina" => "",
			"logo_text" => "",
			"logo_slogan" => "",
			"hide_on_tablet" => "0",
			"hide_on_mobile" => "0",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
			wp_enqueue_script( 'trx_addons-sc_layouts_logo', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'logo/logo.js'), array('jquery'), null, true );

		// Get logo from current theme (if empty)
		if (empty($atts['logo'])) {
			$logo = apply_filters('trx_addons_filter_theme_logo', '');
			if (is_array($logo)) {
				$atts['logo'] = !empty($logo['logo']) ? $logo['logo'] : '';
				$atts['logo_retina'] = !empty($logo['logo_retina']) ? $logo['logo_retina'] : $atts['logo_retina'];
			} else
				$atts['logo'] = $logo;
		}
		
		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'logo/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'logo/tpl.default.php'
										),
										'trx_addons_args_sc_layouts_logo',
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts_logo', $atts, $content);
	}
}


// Add [trx_sc_layouts_logo] in the VC shortcodes list
if (!function_exists('trx_addons_sc_layouts_logo_add_in_vc')) {
	function trx_addons_sc_layouts_logo_add_in_vc() {
		
		if (!trx_addons_cpt_layouts_sc_required()) return;

		add_shortcode("trx_sc_layouts_logo", "trx_addons_sc_layouts_logo");

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_layouts_logo", 'trx_addons_sc_layouts_logo_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Layouts_logo extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_layouts_logo_add_in_vc', 15);
}

// Return params
if (!function_exists('trx_addons_sc_layouts_logo_add_in_vc_params')) {
	function trx_addons_sc_layouts_logo_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_layouts_logo",
				"name" => esc_html__("Layouts: Logo", 'trx_addons'),
				"description" => wp_kses_data( __("Insert the site logo to the custom layout", 'trx_addons') ),
				"category" => esc_html__('Layouts', 'trx_addons'),
				"icon" => 'icon_trx_sc_layouts_logo',
				"class" => "trx_sc_layouts_logo",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
							"admin_label" => true,
							"std" => "default",
							"value" => apply_filters('trx_addons_sc_type', array(
								esc_html__('Default', 'trx_addons') => 'default'
							), 'trx_sc_layouts_logo' ),
							"type" => "dropdown"
						),
						array(
							"param_name" => "logo",
							"heading" => esc_html__("Logo", 'trx_addons'),
							"description" => wp_kses_data( __("Select or upload image or write URL from other site for site's logo.", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "attach_image"
						),
						array(
							"param_name" => "logo_retina",
							"heading" => esc_html__("Logo Retina", 'trx_addons'),
							"description" => wp_kses_data( __("Select or upload image or write URL from other site: site's logo for the Retina display.", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "attach_image"
						),
						array(
							"param_name" => "logo_text",
							"heading" => esc_html__("Logo text", 'trx_addons'),
							"description" => wp_kses_data( __("Site name (used if logo is empty). If not specified - use blog name", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "logo_slogan",
							"heading" => esc_html__("Logo slogan", 'trx_addons'),
							"description" => wp_kses_data( __("Slogan or description below site name (used if logo is empty). If not specified - use blog description", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						)
					),
					trx_addons_vc_add_hide_param(),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_layouts_logo');
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_layouts_logo_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_layouts_logo_add_in_elementor' );
	function trx_addons_sc_layouts_logo_add_in_elementor() {
		
		if (!class_exists('TRX_Addons_Elementor_Layouts_Widget')) return;	

		class TRX_Addons_Elementor_Widget_Layouts_Logo extends TRX_Addons_Elementor_Layouts_Widget {

			/**
			 * Widget base constructor.
			 *
			 * Initializing the widget base class.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @param array      $data Widget data. Default is an empty array.
			 * @param array|null $args Optional. Widget default arguments. Default is null.
			 */
			public function __construct( $data = [], $args = null ) {
				parent::__construct( $data, $args );
				$this->add_plain_params([
					'logo_height' => 'size+unit',
					'logo' => 'url',
					'logo_retina' => 'url'
				]);
			}

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_layouts_logo';
			}

			/**
			 * Retrieve widget title.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget title.
			 */
			public function get_title() {
				return __( 'Layouts: Logo', 'trx_addons' );
			}

			/**
			 * Retrieve widget icon.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget icon.
			 */
			public function get_icon() {
				return 'eicon-icon-box';
			}

			/**
			 * Retrieve the list of categories the widget belongs to.
			 *
			 * Used to determine where to display the widget in the editor.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return array Widget categories.
			 */
			public function get_categories() {
				return ['trx_addons-layouts'];
			}

			/**
			 * Register widget controls.
			 *
			 * Adds different input fields to allow the user to change and customize the widget settings.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function register_controls() {
				$this->start_controls_section(
					'section_sc_layouts_logo',
					[
						'label' => __( 'Layouts: Logo', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', array(
								'default' => esc_html__('Default', 'trx_addons')
							), 'trx_sc_layouts_logo'),
						'default' => 'default'
					]
				);

				$this->add_control(
					'logo_height',
					[
						'label' => __( 'Max height', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 80,
							'unit' => 'px'
						],
						'size_units' => ['px', 'em'],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 200
							],
							'em' => [
								'min' => 0,
								'max' => 20
							]
						],
						'selectors' => [
							'{{WRAPPER}} .logo_image' => 'max-height: {{SIZE}}{{UNIT}};',
						]
					]
				);

				$this->add_control(
					'logo',
					[
						'label' => __( 'Logo', 'trx_addons' ),
						'description' => wp_kses_data( __("Select or upload image for site's logo. If empty - theme-specific logo is used", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => '',
						]
					]
				);

				$this->add_control(
					'logo_retina',
					[
						'label' => __( 'Logo Retina', 'trx_addons' ),
						'description' => wp_kses_data( __("Select or upload image for site's logo on the Retina displays", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => '',
						]
					]
				);

				$this->add_control(
					'logo_text',
					[
						'label' => __( 'Logo text', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Site name (used if logo is empty). If not specified - use blog name", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->add_control(
					'logo_slogan',
					[
						'label' => __( 'Logo slogan', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Slogan or description below site name (used if logo is empty). If not specified - use blog description", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);
				
				$this->end_controls_section();
			}

			/**
			 * Render widget's template for the editor.
			 *
			 * Written as a Backbone JavaScript template and used to generate the live preview.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function content_template() {
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "logo/tpl.logo.php",
										'trx_addons_args_sc_layouts_logo',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Layouts_Logo() );
	}
}


// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_sc_layouts_logo_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_sc_layouts_logo_black_list' );
	function trx_addons_sc_layouts_logo_black_list($list) {
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Logo';
		return $list;
	}
}
?>