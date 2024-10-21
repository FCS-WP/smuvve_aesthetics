<?php
/**
 * Plugin support: QuickCal
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if plugin is installed and activated
if ( !function_exists( 'trx_addons_exists_quickcal' ) ) {
	function trx_addons_exists_quickcal() {
		return class_exists( 'quickcal_plugin' );
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_quickcal_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_quickcal_importer_required_plugins', 10, 2 );
	function trx_addons_quickcal_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'quickcal')!==false && !trx_addons_exists_quickcal() )
			$not_installed .= '<br>' . esc_html__('QuickCal', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_quickcal_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options', 'trx_addons_quickcal_importer_set_options', 10, 1 );
	function trx_addons_quickcal_importer_set_options($options=array()) {
		if ( trx_addons_exists_quickcal() && in_array( 'quickcal', $options['required_plugins'] ) ) {
			$options['additional_options'][] = 'quickcal_%';			// Add slugs to export options of this plugin
			$options['additional_options'][] = 'booked_%';				// Attention! QuickCal use Booked plugin options
		}
		return $options;
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_quickcal_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_addons_filter_importer_import_row', 'trx_addons_quickcal_importer_check_row', 9, 4);
	function trx_addons_quickcal_importer_check_row($flag, $table, $row, $list) {
		if ( $flag || strpos( $list, 'quickcal' ) === false ) {
			return $flag;
		}
		if ( trx_addons_exists_quickcal() || ( function_exists( 'trx_addons_exists_booked' ) && trx_addons_exists_booked() ) ) {
			if ( $table == 'posts' ) {
				$flag = in_array( $row['post_type'], array( 'quickcal_appointments', 'booked_appointments' ) );
			}
		}
		return $flag;
	}
}


// VC support
//------------------------------------------------------------------------

// Add [cff] in the VC shortcodes list
if (!function_exists('trx_addons_sc_quickcal_add_in_vc')) {
	function trx_addons_sc_quickcal_add_in_vc() {

		if (!trx_addons_exists_visual_composer() || !trx_addons_exists_quickcal()) return;
		
		vc_lean_map( "quickcal-appointments", 'trx_addons_sc_quickcal_add_in_vc_params_ba');
		class WPBakeryShortCode_QuickCal_Appointments extends WPBakeryShortCode {}

		vc_lean_map( "quickcal-calendar", 'trx_addons_sc_quickcal_add_in_vc_params_bc');
		class WPBakeryShortCode_QuickCal_Calendar extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_quickcal_add_in_vc', 20);
}



// Params for QuickCal Appointments
if (!function_exists('trx_addons_sc_quickcal_add_in_vc_params_ba')) {
	function trx_addons_sc_quickcal_add_in_vc_params_ba() {
		return array(
				"base" => "quickcal-appointments",
				"name" => esc_html__("QuickCal Appointments", "trx_addons"),
				"description" => esc_html__("Display the currently logged in user's upcoming appointments", "trx_addons"),
				"category" => esc_html__('Content', 'trx_addons'),
				'icon' => 'icon_trx_sc_quickcal_appointments',
				"class" => "trx_sc_single trx_sc_quickcal_appointments",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array()
			);
	}
}
			
// Params for QuickCal Calendar
if (!function_exists('trx_addons_sc_quickcal_add_in_vc_params_bc')) {
	function trx_addons_sc_quickcal_add_in_vc_params_bc() {
		return array(
				"base" => "quickcal-calendar",
				"name" => esc_html__("QuickCal Calendar", "trx_addons"),
				"description" => esc_html__("Insert quickcal calendar", "trx_addons"),
				"category" => esc_html__('Content', 'trx_addons'),
				'icon' => 'icon_trx_sc_quickcal_calendar',
				"class" => "trx_sc_single trx_sc_quickcal_calendar",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "calendar",
						"heading" => esc_html__("Calendar", "trx_addons"),
						"description" => esc_html__("Select quickcal calendar to display", "trx_addons"),
						"admin_label" => true,
						"std" => "0",
						"value" => array_flip(trx_addons_array_merge(array(0 => esc_html__('- Select calendar -', 'trx_addons')), trx_addons_get_list_terms(false, 'booked_custom_calendars'))),
						"type" => "dropdown"
					),
					array(
						"param_name" => "year",
						"heading" => esc_html__("Year", "trx_addons"),
						"description" => esc_html__("Year to display on calendar by default", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-6',
						"admin_label" => true,
						"std" => date("Y"),
						"value" => date("Y"),
						"type" => "textfield"
					),
					array(
						"param_name" => "month",
						"heading" => esc_html__("Month", "trx_addons"),
						"description" => esc_html__("Month to display on calendar by default", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-6',
						"admin_label" => true,
						"std" => date("m"),
						"value" => date("m"),
						"type" => "textfield"
					)
				)
			);
	}
}

// Elementor Widgets
//------------------------------------------------------

// Params for QuickCal Appointments
if (!function_exists('trx_addons_sc_quickcal_add_in_elementor_ba')) {
    add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_quickcal_add_in_elementor_ba' );
    function trx_addons_sc_quickcal_add_in_elementor_ba() {

        if (!trx_addons_exists_quickcal()) return;

        class TRX_Addons_Elementor_Widget_QuickCal_Appontments extends TRX_Addons_Elementor_Widget {

            /**
             * Retrieve widget name.
             *
             * @since 1.6.41
             * @access public
             *
             * @return string Widget name.
             */
            public function get_name() {
                return 'trx_sc_quickcal_appointments';
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
                return __( 'QuickCal Appointments', 'trx_addons' );
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
                return 'eicon-checkbox';
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
                return ['trx_addons-support'];
            }

            // Return widget's layout
            public function render() {
                if (shortcode_exists('quickcal-appointments')) {
                    trx_addons_show_layout(do_shortcode('[quickcal-appointments]'));
                } else {
                    $this->shortcode_not_exists('quickcal-appointments', 'QuickCal Appointment');
                }
            }
        }



        // Register widget
        \Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_QuickCal_Appontments() );
    }
}


// Params for QuickCal Profile
if (!function_exists('trx_addons_sc_quickcal_add_in_elementor_bp')) {
    add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_quickcal_add_in_elementor_bp' );
    function trx_addons_sc_quickcal_add_in_elementor_bp() {

        if (!trx_addons_exists_quickcal()) return;

        class TRX_Addons_Elementor_Widget_QuickCal_Profile extends TRX_Addons_Elementor_Widget {

            /**
             * Retrieve widget name.
             *
             * @since 1.6.41
             * @access public
             *
             * @return string Widget name.
             */
            public function get_name() {
                return 'trx_sc_quickcal_profile';
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
                return __( 'QuickCal Profile', 'trx_addons' );
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
                return 'eicon-lock-user';
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
                return ['trx_addons-support'];
            }

            // Return widget's layout
            public function render() {
                if (shortcode_exists('quickcal-profile')) {
                    trx_addons_show_layout(do_shortcode('[quickcal-profile]'));
                } else {
                    $this->shortcode_not_exists('quickcal-profile', 'QuickCal Profile');
                }
            }
        }

        // Register widget
        \Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_QuickCal_Profile() );
    }
}


// Params for QuickCal Calendar
if (!function_exists('trx_addons_sc_quickcal_add_in_elementor_bc')) {
    add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_quickcal_add_in_elementor_bc' );
    function trx_addons_sc_quickcal_add_in_elementor_bc() {

        if (!trx_addons_exists_quickcal()) return;

        class TRX_Addons_Elementor_Widget_QuickCal_Calendar extends TRX_Addons_Elementor_Widget {

            /**
             * Retrieve widget name.
             *
             * @since 1.6.41
             * @access public
             *
             * @return string Widget name.
             */
            public function get_name() {
                return 'trx_sc_quickcal_calendar';
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
                return __( 'QuickCal Calendar', 'trx_addons' );
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
                return 'eicon-apps';
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
                return ['trx_addons-support'];
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
                    'section_sc_quickcal',
                    [
                        'label' => __( 'ThemeREX QuickCal Calendar', 'trx_addons' ),
                    ]
                );

                $this->add_control(
                    'style',
                    [
                        'label' => __( 'Layout', 'trx_addons' ),
                        'label_block' => false,
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => [
                            'calendar' => esc_html__('Calendar', 'trx_addons'),
                            'list' => esc_html__('List', 'trx_addons')
                        ],
                        'default' => 'calendar'
                    ]
                );

                $this->add_control(
                    'calendar',
                    [
                        'label' => __( 'Calendar', 'trx_addons' ),
                        'label_block' => false,
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => trx_addons_array_merge(array(0 => esc_html__('- Select calendar -', 'trx_addons')), trx_addons_get_list_terms(false, 'booked_custom_calendars')),
                        'default' => '0'
                    ]
                );

                $this->add_control(
                    'month',
                    [
                        'label' => __( 'Month', 'trx_addons' ),
                        'label_block' => false,
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => trx_addons_array_merge(array(0 => esc_html__('- Current month -', 'trx_addons')), trx_addons_get_list_months()),
                        'default' => '0'
                    ]
                );

                $this->add_control(
                    'year',
                    [
                        'label' => __( 'Year', 'trx_addons' ),
                        'label_block' => false,
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => trx_addons_array_merge(array(0 => esc_html__('- Current year -', 'trx_addons')), trx_addons_get_list_range(date('Y'), date('Y')+25)),
                        'default' => '0'
                    ]
                );

                $this->end_controls_section();
            }

            // Return widget's layout
            public function render() {
                if (shortcode_exists('quickcal-calendar')) {
                    $atts = $this->sc_prepare_atts($this->get_settings(), $this->get_sc_name());
                    trx_addons_show_layout(do_shortcode(sprintf('[quickcal-calendar style="%1$s" calendar="%2$s" month="%3$s" year="%4$s"]',
                        $atts['style'],
                        $atts['calendar'],
                        $atts['month'],
                        $atts['year']
                    )));
                } else {
                    $this->shortcode_not_exists('quickcal-calendar', 'QuickCal Calendar');
                }
            }
        }

        // Register widget
        \Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_QuickCal_Calendar() );
    }
}

if ( ! function_exists( 'trx_addons_quickcal_export_options' ) ) {
	add_filter( 'trx_addons_filter_export_options', 'trx_addons_quickcal_export_options' );

	function trx_addons_quickcal_export_options( $options ) {
		$options['quickcal_welcome_screen'] = false;
		//$options['booked_welcome_screen'] = false;          // Attention! QuickCal use Booked plugin options
		return $options;
	}
 }
 
?>