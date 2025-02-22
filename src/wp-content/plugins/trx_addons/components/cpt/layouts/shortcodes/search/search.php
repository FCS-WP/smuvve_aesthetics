<?php
/**
 * Shortcode: Display Search form
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_layouts_search_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_layouts_search_load_scripts_front');
	function trx_addons_sc_layouts_search_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_layouts_search', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'search/search.css'), array(), null );
		}
	}
}

	
// Merge shortcode specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_layouts_search_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_sc_layouts_search_merge_styles');
	function trx_addons_sc_layouts_search_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'search/search.css';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_sc_layouts_search_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_layouts_search_merge_scripts');
	function trx_addons_sc_layouts_search_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'search/search.js';
		return $list;
	}
}

// Add 'Search' form
if (!function_exists('trx_addons_add_search_form')) {
	add_action('trx_addons_action_search', 'trx_addons_add_search_form', 10, 3);
	function trx_addons_add_search_form($style='normal', $class='', $ajax=true) {

		if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
			wp_enqueue_script( 'trx_addons-sc_layouts_search', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'search/search.js'), array('jquery'), null, true );

		trx_addons_get_template_part('templates/tpl.search-form.php',
   									'trx_addons_args_search',
   									array(
										'style' => $style,
										'class' => $class,
										'ajax' => $ajax
										)
									);
	}
}

// AJAX incremental search
if ( !function_exists( 'trx_addons_callback_ajax_search' ) ) {
	add_action('wp_ajax_ajax_search',			'trx_addons_callback_ajax_search');
	add_action('wp_ajax_nopriv_ajax_search',	'trx_addons_callback_ajax_search');
	function trx_addons_callback_ajax_search() {
		if ( !wp_verify_nonce( trx_addons_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();

		$response = array('error'=>'', 'data' => '');
		
		$s = $_REQUEST['text'];
	
		if (!empty($s)) {
			$args = apply_filters( 'trx_addons_ajax_search_query', array(
				'post_status' => 'publish',
				'orderby' => 'date',
				'order' => 'desc', 
				'posts_per_page' => 4,
				's' => esc_html($s),
				)
			);	

			$query = new WP_Query( $args );

			set_query_var('trx_addons_output_widgets_posts', '');

			$post_number = 0;
			while ( $query->have_posts() ) { $query->the_post();
				$post_number++;
				trx_addons_get_template_part('templates/tpl.posts-list.php',
												'trx_addons_args_widgets_posts', 
												array(
													'show_image' => 1,
													'show_date' => 1,
													'show_author' => 1,
													'show_counters' => 1,
										            'show_categories' => 0
								   	            )
											);
			}
			$response['data'] = get_query_var('trx_addons_output_widgets_posts');
			if (empty($response['data'])) {
				$response['data'] .= '<article class="post_item">' . esc_html__('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'trx_addons') . '</article>';
			} else {
				$response['data'] .= '<article class="post_item"><a href="#" class="post_more search_more">' . esc_html__('More results ...', 'trx_addons') . '</a></article>';
			}
		} else {
			$response['error'] = '<article class="post_item">' . esc_html__('The query string is empty!', 'trx_addons') . '</article>';
		}
		
		echo json_encode($response);
		die();
	}
}



// trx_sc_layouts_search
//-------------------------------------------------------------
/*
[trx_sc_layouts_search id="unique_id" style="normal|expand|fullscreen" ajax="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_layouts_search' ) ) {
	function trx_addons_sc_layouts_search($atts, $content = ''){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_layouts_search', $atts, array(
			// Individual params
			"type" => "default",
			"style" => "normal",
			"ajax" => "1",
			"hide_on_tablet" => "0",
			"hide_on_mobile" => "0",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'search/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'search/tpl.default.php'
										), 
										'trx_addons_args_sc_layouts_search',
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts_search', $atts, $content);
	}
}


// Add [trx_sc_layouts_search] in the VC shortcodes list
if (!function_exists('trx_addons_sc_layouts_search_add_in_vc')) {
	function trx_addons_sc_layouts_search_add_in_vc() {

		if (!trx_addons_exists_visual_composer()) return;
        if (!trx_addons_cpt_layouts_sc_required()) return;

		add_shortcode("trx_sc_layouts_search", "trx_addons_sc_layouts_search");
		
		vc_lean_map("trx_sc_layouts_search", 'trx_addons_sc_layouts_search_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Layouts_Search extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_layouts_search_add_in_vc', 15);
}

// Return params
if (!function_exists('trx_addons_sc_layouts_search_add_in_vc_params')) {
	function trx_addons_sc_layouts_search_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_layouts_search",
				"name" => esc_html__("Layouts: Search form", 'trx_addons'),
				"description" => wp_kses_data( __("Insert search form to the custom layout", 'trx_addons') ),
				"category" => esc_html__('Layouts', 'trx_addons'),
				"icon" => 'icon_trx_sc_layouts_search',
				"class" => "trx_sc_layouts_search",
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
								esc_html__('Default', 'trx_addons') => 'default',
							), 'trx_sc_layouts_search' ),
							"type" => "dropdown"
						),
						array(
							"param_name" => "style",
							"heading" => esc_html__("Style", 'trx_addons'),
							"description" => wp_kses_data( __("Select form's style", 'trx_addons') ),
							"admin_label" => true,
							"std" => "default",
							"value" => apply_filters('trx_addons_sc_style', array(
								esc_html__('Normal', 'trx_addons') => 'normal',
								esc_html__('Expand', 'trx_addons') => 'expand',
								esc_html__('Fullscreen', 'trx_addons') => 'fullscreen',
							), 'trx_sc_layouts_search' ),
							"type" => "dropdown"
						),
						array(
							"param_name" => "ajax",
							"heading" => esc_html__("AJAX search", 'trx_addons'),
							"description" => wp_kses_data( __("Use AJAX incremental search", 'trx_addons') ),
							"admin_label" => true,
							"std" => "0",
							"value" => array(esc_html__("AJAX search", 'trx_addons') => "1" ),
							"type" => "checkbox"
						)
					),
					trx_addons_vc_add_hide_param(),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_layouts_search');
	}
}
?>