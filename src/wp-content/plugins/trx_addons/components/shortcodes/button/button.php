<?php
/**
 * Shortcode: Button
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_button_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_button_load_scripts_front');
	function trx_addons_sc_button_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_button', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'button/button.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_button_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_sc_button_merge_styles');
	function trx_addons_sc_button_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'button/button.css';
		return $list;
	}
}



// trx_sc_button
//-------------------------------------------------------------
/*
[trx_sc_button id="unique_id" type="default" title="Block title" subtitle="" link="#" icon="icon-cog" image="path_to_image"]
*/
if (!function_exists('trx_addons_sc_button')) {	
	function trx_addons_sc_button($atts, $content = ''){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_button', $atts, array(
			// Individual params
			"type" => "default",
			"size" => "normal",
			"align" => "none",
			"text_align" => "none",
			"bg_image" => "",
			"back_image" => "",		// Alter name for bg_image in VC (it broke bg_image)
			"image" => "",
			"icon_position" => "left",
			"icon" => "",
			"icon_type" => "",
			"icon_fontawesome" => "",
			"icon_openiconic" => "",
			"icon_typicons" => "",
			"icon_entypo" => "",
			"icon_linecons" => "",
			"title" => "",
			"subtitle" => "",
			"link" => '',
			"popup" => 0,
			"new_window" => 0,
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
	
		$output = '';
		if (!empty($atts['link'])) {
			if (empty($atts['icon'])) {
				$atts['icon'] = isset( $atts['icon_' . $atts['icon_type']] ) && $atts['icon_' . $atts['icon_type']] != 'empty' 
									? $atts['icon_' . $atts['icon_type']] 
									: '';
				trx_addons_load_icons($atts['icon_type']);
			}
	
			if (empty($atts['bg_image'])) $atts['bg_image'] = $atts['back_image'];
			$atts['bg_image'] = trx_addons_get_attachment_url($atts['bg_image'], trx_addons_get_thumb_size('masonry'));
			$atts['image'] = trx_addons_get_attachment_url($atts['image'], trx_addons_get_thumb_size('masonry'));
	
			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'button/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'button/tpl.default.php'
											),
                                            'trx_addons_args_sc_button', 
                                            $atts
                                        );
			$output = ob_get_contents();
			ob_end_clean();
		}
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_button', $atts, $content);
	}
}



// Add [trx_sc_button] in the VC shortcodes list
if (!function_exists('trx_addons_sc_button_add_in_vc')) {
	function trx_addons_sc_button_add_in_vc() {
		
		if (!trx_addons_exists_visual_composer()) return;

		add_shortcode("trx_sc_button", "trx_addons_sc_button");

		vc_lean_map("trx_sc_button", 'trx_addons_sc_button_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Button extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_button_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_button_add_in_vc_params')) {
	function trx_addons_sc_button_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
			"base" => "trx_sc_button",
			"name" => esc_html__("Button", 'trx_addons'),
			"description" => wp_kses_data( __("Insert button", 'trx_addons') ),
			"category" => esc_html__('ThemeREX', 'trx_addons'),
			'icon' => 'icon_trx_sc_button',
			"class" => "trx_sc_button",
			'content_element' => true,
			'is_container' => false,
			"show_settings_on_create" => true,
			"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
							"admin_label" => true,
					        'save_always' => true,
							'edit_field_class' => 'vc_col-sm-6',
							"std" => "default",
							"value" => apply_filters('trx_addons_sc_type', array_flip(trx_addons_components_get_allowed_layouts('sc', 'button')), 'trx_sc_button' ),
							"type" => "dropdown"
						),
						array(
							"param_name" => "size",
							"heading" => esc_html__("Size", 'trx_addons'),
							"description" => wp_kses_data( __("Size of the button", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => array(
								esc_html__('Normal', 'trx_addons') => 'normal',
								esc_html__('Small', 'trx_addons') => 'small',
								esc_html__('Large', 'trx_addons') => 'large'
							),
							"std" => "normal",
							"type" => "dropdown"
						),
						array(
							"param_name" => "link",
							"heading" => esc_html__("Button URL", 'trx_addons'),
							"description" => wp_kses_data( __("Link URL for the button", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "new_window",
							"heading" => esc_html__("Open in the new tab", 'trx_addons'),
							"description" => wp_kses_data( __("Open this link in the new browser's tab", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"std" => 0,
							"value" => array(esc_html__("Open in the new tab", 'trx_addons') => 1 ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "title",
							"heading" => esc_html__("Title", 'trx_addons'),
							"description" => wp_kses_data( __("Title of the button.", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "subtitle",
							"heading" => esc_html__("Subtitle", 'trx_addons'),
							"description" => wp_kses_data( __("Subtitle for the button", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "align",
							"heading" => esc_html__("Button alignment", 'trx_addons'),
							"description" => wp_kses_data( __("Select button alignment", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => array(
								esc_html__('Default', 'trx_addons') => 'none',
								esc_html__('Left', 'trx_addons') => 'left',
								esc_html__('Center', 'trx_addons') => 'center',
								esc_html__('Right', 'trx_addons') => 'right'
							),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "text_align",
							"heading" => esc_html__("Text alignment", 'trx_addons'),
							"description" => wp_kses_data( __("Select text alignment", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => array(
								esc_html__('Default', 'trx_addons') => 'none',
								esc_html__('Left', 'trx_addons') => 'left',
								esc_html__('Center', 'trx_addons') => 'center',
								esc_html__('Right', 'trx_addons') => 'right'
							),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "back_image",		// Alter name for bg_image in VC (it broke bg_image)
							"heading" => esc_html__("Button's background image", 'trx_addons'),
							"description" => wp_kses_data( __("Select the image from the library for this button's background", 'trx_addons') ),
							'dependency' => array(
								'element' => 'type',
								'value' => 'default'
							),
							"type" => "attach_image"
						)
					),
					trx_addons_vc_add_icon_param(),
					array(
						array(
							"param_name" => "image",
							"heading" => esc_html__("or select an image", 'trx_addons'),
							"description" => wp_kses_data( __("Select the image instead the icon (if need)", 'trx_addons') ),
							"group" => esc_html__('Icons', 'trx_addons'),
							"type" => "attach_image"
						),
						array(
							"param_name" => "icon_position",
							"heading" => esc_html__("Icon position", 'trx_addons'),
							"description" => wp_kses_data( __("Place the image to the left or to the right or to the top of the button", 'trx_addons') ),
							"group" => esc_html__('Icons', 'trx_addons'),
					        'save_always' => true,
							"value" => array(
								esc_html__('Left', 'trx_addons') => 'left',
								esc_html__('Right', 'trx_addons') => 'right',
								esc_html__('Top', 'trx_addons') => 'top'
							),
							"std" => "left",
							"type" => "dropdown"
						),
					),
					trx_addons_vc_add_id_param()
			)

		), 'trx_sc_button' );
	}
}


// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_button_add_in_elementor')) {
    add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_button_add_in_elementor' );
    function trx_addons_sc_button_add_in_elementor() {
        class TRX_Addons_Elementor_Widget_Button extends TRX_Addons_Elementor_Widget {

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
                    'height' => 'size'
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
                return 'trx_sc_button';
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
                return __( 'Button', 'trx_addons' );
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
                return 'eicon-button';
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
                return ['trx_addons-elements'];
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
                    'section_sc_button',
                    [
                        'label' => __( 'Button', 'trx_addons' ),
                    ]
                );

                $this->add_control(
                    'type',
                    [
                        'label' => __( 'Layout', 'trx_addons' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'button'), 'trx_sc_button'),
                        'default' => 'default',
                    ]
                );

                $this->add_control(
                    'size',
                    [
                        'label' => __( 'Size', 'trx_addons' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => trx_addons_get_list_sc_button_sizes(),
                        'default' => 'normal',
                    ]
                );

                $this->add_control(
                    'link',
                    [
                        'label' => __( 'Button URL', 'trx_addons' ),
                        'type' => \Elementor\Controls_Manager::URL,
                        'label_block' => false,
                        'placeholder' => __( 'http://your-link.com', 'trx_addons' ),
                        'default' => [
                            'url' => '#'
                        ]
                    ]
                );

                $this->add_control(
                    'title',
                    [
                        'label' => __( 'Title', 'trx_addons' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'label_block' => false,
                        'placeholder' => __( "Title", 'trx_addons' ),
                        'default' => __('Button', 'trx_addons')
                    ]
                );

                $this->add_control(
                    'subtitle',
                    [
                        'label' => __( 'Subtitle', 'trx_addons' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'label_block' => false,
                        'placeholder' => __( "Subtitle", 'trx_addons' ),
                        'default' => ''
                    ]
                );

                $this->add_control(
                    'align',
                    [
                        'label' => __( 'Button alignment', 'trx_addons' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => trx_addons_get_list_sc_aligns(),
                        'default' => 'none',
                    ]
                );

                $this->add_control(
                    'text_align',
                    [
                        'label' => __( 'Text alignment', 'trx_addons' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => trx_addons_get_list_sc_aligns(),
                        'default' => 'none',
                    ]
                );

                $this->add_control(
                    'bg_image',
                    [
                        'label' => __( 'Background Image', 'trx_addons' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => [
                            'url' => '',
                        ],
                    ]
                );

                $this->add_icon_param();

                $this->add_control(
                    'image',
                    [
                        'label' => __( 'or select an image', 'trx_addons' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => [
                            'url' => '',
                        ],
                    ]
                );

                $this->add_control(
                    'icon_position',
                    [
                        'label' => __( 'Icon position', 'trx_addons' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => trx_addons_get_list_sc_icon_positions(),
                        'default' => 'left',
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
                trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "button/tpe.button.php",
                    'trx_addons_args_sc_button',
                    array('element' => $this)
                );
            }

        }

        // Register widget
        \Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Button() );
    }
}



?>