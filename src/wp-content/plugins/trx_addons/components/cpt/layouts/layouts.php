<?php
/**
 * ThemeREX Addons Custom post type: Layouts
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.06
 */

// Don't load directly
if (!defined('TRX_ADDONS_VERSION')) {
    die('-1');
}

// -----------------------------------------------------------------
// -- Custom post type registration
// -----------------------------------------------------------------

// Define Custom post type and taxonomy constants
if (!defined('TRX_ADDONS_CPT_LAYOUTS_PT')) define('TRX_ADDONS_CPT_LAYOUTS_PT', trx_addons_cpt_param('layouts', 'post_type'));
if (!defined('TRX_ADDONS_CPT_LAYOUTS_TAXONOMY')) define('TRX_ADDONS_CPT_LAYOUTS_TAXONOMY', trx_addons_cpt_param('layouts', 'taxonomy'));

if (!defined('TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES')) define('TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES', TRX_ADDONS_PLUGIN_CPT . 'layouts/shortcodes/');

// Return translated or original post ID
if (!function_exists('trx_addons_cpt_layouts_get_translated_layout')) {
    add_filter('trx_addons_filter_get_translated_layout', 'trx_addons_cpt_layouts_get_translated_layout');
    function trx_addons_cpt_layouts_get_translated_layout($id)
    {
        global $sitepress;
        if (is_object($sitepress)) {
            $trid = $sitepress->get_element_trid($id, 'post_' . TRX_ADDONS_CPT_LAYOUTS_PT);
            $translations = $sitepress->get_element_translations($trid, 'post_' . TRX_ADDONS_CPT_LAYOUTS_PT);
            if (!empty($translations[ICL_LANGUAGE_CODE]))
                $id = $translations[ICL_LANGUAGE_CODE]->element_id;
        }
        return $id;
    }
}

// Register post type and taxonomy (if need)
if (!function_exists('trx_addons_cpt_layouts_init')) {
    add_action('init', 'trx_addons_cpt_layouts_init');
    function trx_addons_cpt_layouts_init()
    {

        if (!trx_addons_exists_page_builder()) return;

        // Add Layouts parameters to the Meta Box support
        global $TRX_ADDONS_STORAGE;
        $TRX_ADDONS_STORAGE['post_types'][] = TRX_ADDONS_CPT_LAYOUTS_PT;
        $TRX_ADDONS_STORAGE['meta_box_' . TRX_ADDONS_CPT_LAYOUTS_PT] = array(
            "layout_type" => array(
                "title" => __('Type', 'trx_addons'),
                "desc" => __("Type of this layout", 'trx_addons'),
                "std" => 'header',
                "options" => apply_filters('trx_addons_filter_layout_types', array(
                    'header' => esc_html__('Header', 'trx_addons'),
                    'footer' => esc_html__('Footer', 'trx_addons'),
                    'custom' => esc_html__('Custom', 'trx_addons')
                )),
                "type" => "select"
            ),
            "margin" => array(
                "title" => __('Margin to content', 'trx_addons'),
                "desc" => __("Specify margin between this layout and page content to override theme's value", 'trx_addons'),
                "dependency" => array(
                    "layout_type" => array('header', 'footer')
                ),
                "std" => '',
                "type" => "text")
        );

        // Register post type and taxonomy
        register_post_type(TRX_ADDONS_CPT_LAYOUTS_PT, array(
                'label' => esc_html__('Layout', 'trx_addons'),
                'description' => esc_html__('Layout Description', 'trx_addons'),
                'labels' => array(
                    'name' => esc_html__('Layouts', 'trx_addons'),
                    'singular_name' => esc_html__('Layout', 'trx_addons'),
                    'menu_name' => esc_html__('Layouts', 'trx_addons'),
                    'parent_item_colon' => esc_html__('Parent Item:', 'trx_addons'),
                    'all_items' => esc_html__('All Layouts', 'trx_addons'),
                    'view_item' => esc_html__('View Layout', 'trx_addons'),
                    'add_new_item' => esc_html__('Add New Layout', 'trx_addons'),
                    'add_new' => esc_html__('Add New', 'trx_addons'),
                    'edit_item' => esc_html__('Edit Layout', 'trx_addons'),
                    'update_item' => esc_html__('Update Layout', 'trx_addons'),
                    'search_items' => esc_html__('Search Layout', 'trx_addons'),
                    'not_found' => esc_html__('Not found', 'trx_addons'),
                    'not_found_in_trash' => esc_html__('Not found in Trash', 'trx_addons'),
                ),
                'taxonomies' => array(TRX_ADDONS_CPT_LAYOUTS_TAXONOMY),
                'supports' => trx_addons_cpt_param('layouts', 'supports'),
                'public' => true,
                'hierarchical' => false,
                'has_archive' => false,
                'can_export' => true,
                'show_in_admin_bar' => true,
                'show_ui' => true,
                'show_in_menu' => true,
					 'show_in_rest' => true,
                'menu_position' => '52.0',
                'menu_icon' => 'dashicons-editor-kitchensink',
                'capability_type' => 'post',
                'rewrite' => array('slug' => trx_addons_cpt_param('layouts', 'post_type_slug'))
            )
        );

        register_taxonomy(TRX_ADDONS_CPT_LAYOUTS_TAXONOMY, TRX_ADDONS_CPT_LAYOUTS_PT, array(
                'post_type' => TRX_ADDONS_CPT_LAYOUTS_PT,
                'hierarchical' => true,
                'labels' => array(
                    'name' => esc_html__('Layouts Group', 'trx_addons'),
                    'singular_name' => esc_html__('Group', 'trx_addons'),
                    'search_items' => esc_html__('Search Groups', 'trx_addons'),
                    'all_items' => esc_html__('All Groups', 'trx_addons'),
                    'parent_item' => esc_html__('Parent Group', 'trx_addons'),
                    'parent_item_colon' => esc_html__('Parent Group:', 'trx_addons'),
                    'edit_item' => esc_html__('Edit Group', 'trx_addons'),
                    'update_item' => esc_html__('Update Group', 'trx_addons'),
                    'add_new_item' => esc_html__('Add New Group', 'trx_addons'),
                    'new_item_name' => esc_html__('New Group Name', 'trx_addons'),
                    'menu_name' => esc_html__('Layout Group', 'trx_addons'),
                ),
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => trx_addons_cpt_param('layouts', 'taxonomy_slug'))
            )
        );

        // Add cpt_layouts to the VC Editor default post_types
        if (!function_exists('trx_addons_cpt_layouts_vc_setup')) {
            add_action('init', 'trx_addons_cpt_layouts_vc_setup', 1000);
            function trx_addons_cpt_layouts_vc_setup()
            {
                if (is_admin() && current_user_can('manage_options') && function_exists('vc_editor_set_post_types')) {
                    $list = vc_editor_post_types();
                    if (is_array($list) && !in_array(TRX_ADDONS_CPT_LAYOUTS_PT, $list)) {
                        $list[] = TRX_ADDONS_CPT_LAYOUTS_PT;
                        vc_editor_set_post_types($list);
                    }
                }
            }
        }

        // Create theme specific layouts on first load or after activate VC
        if (is_admin() && get_option('trx_addons_cpt_layouts_created', false) === false) {
            trx_addons_cpt_layouts_create(true);
            update_option('trx_addons_cpt_layouts_created', 1);
        }
    }
}

// Add 'Layouts' parameters in the ThemeREX Addons Options
if (!function_exists('trx_addons_cpt_layouts_options')) {
    add_filter('trx_addons_filter_options', 'trx_addons_cpt_layouts_options');
    function trx_addons_cpt_layouts_options($options)
    {

        trx_addons_array_insert_after($options, 'theme_specific_section', array(
            // Layouts settings
            'layouts_info' => array(
                "title" => esc_html__('Custom Layouts', 'trx_addons'),
                "desc" => wp_kses_data(__('Create theme-specific custom layouts (headers, footers, etc.)', 'trx_addons')),
                "type" => "info"
            ),
            'layouts_create' => array(
                "title" => esc_html__('Create Layouts', 'trx_addons'),
                "desc" => wp_kses_data(__('Press button above to create set of layouts, prepared with this theme. Attention! If a post with the same name exist - it is skipped!', 'trx_addons')),
                "std" => 'trx_addons_cpt_layouts_create',
                "type" => "button"
            )
        ));
        return $options;
    }
}

// Callback for the 'Create Layouts' button
if (!function_exists('trx_addons_callback_ajax_trx_addons_cpt_layouts_create')) {
    add_action('wp_ajax_trx_addons_cpt_layouts_create', 'trx_addons_callback_ajax_trx_addons_cpt_layouts_create');
    function trx_addons_callback_ajax_trx_addons_cpt_layouts_create()
    {
        if (!wp_verify_nonce(trx_addons_get_value_gp('nonce'), admin_url('admin-ajax.php')))
            die();

        $response = array(
            'error' => '',
            'success' => esc_html__('Custom Layouts created successfully!', 'trx_addons')
        );

        trx_addons_cpt_layouts_create(true);

        echo json_encode($response);
        die();
    }
}

// Create theme-specific layouts
if (!function_exists('trx_addons_cpt_layouts_create')) {
    function trx_addons_cpt_layouts_create($check = true)
    {
        $layouts = apply_filters('trx_addons_filter_default_layouts', array());
        if (count($layouts) > 0) {
            // Add in the user's VC l8ayouts
            $vc_layouts = get_option('wpb_js_templates');
            if (!is_array($vc_layouts)) $vc_layouts = array();
            update_option('wpb_js_templates', array_merge($vc_layouts, $layouts));
            // Create 'layouts' posts
            foreach ($layouts as $layout) {
                if ($check && trx_addons_get_post_by_title($layout['name'], TRX_ADDONS_CPT_LAYOUTS_PT) != null) continue;
                $post_id = wp_insert_post(array(
                    'post_title' => $layout['name'],
                    'post_content' => $layout['template'],
                    'post_type' => TRX_ADDONS_CPT_LAYOUTS_PT,
                    'post_status' => 'publish'
                ));
                if (!is_wp_error($post_id)) {
                    if (!empty($layout['meta']) && is_array($layout['meta'])) {
                        foreach ($layout['meta'] as $k => $v) {
                            $v = trx_addons_unserialize($v);
                            update_post_meta($post_id, $k, $k == 'trx_addons_options'
                                ? apply_filters('trx_addons_filter_save_post_options', $v, $post_id, TRX_ADDONS_CPT_LAYOUTS_PT)
                                : wp_slash($v));
                        }
                    }
                }
            }
        }
    }
}

// Put meta box to the sidebar
if (!function_exists('trx_addons_cpt_layouts_meta_box_context')) {
    add_filter('trx_addons_filter_add_meta_box_context', 'trx_addons_cpt_layouts_meta_box_context', 10, 2);
    function trx_addons_cpt_layouts_meta_box_context($context, $post_type)
    {
        if ($post_type == TRX_ADDONS_CPT_LAYOUTS_PT)
            $context = 'side';
        return $context;
    }
}

// Save data from meta box
if (!function_exists('trx_addons_cpt_layouts_meta_box_save')) {
    add_filter('trx_addons_filter_save_post_options', 'trx_addons_cpt_layouts_meta_box_save', 10, 3);
    function trx_addons_cpt_layouts_meta_box_save($options, $post_id, $post_type)
    {
        if ($post_type == TRX_ADDONS_CPT_LAYOUTS_PT && is_array($options) && !empty($options['layout_type']))
            update_post_meta($post_id, 'trx_addons_layout_type', $options['layout_type']);
        return $options;
    }
}


// Load required styles and scripts for the frontend
if (!function_exists('trx_addons_cpt_layouts_load_scripts_front')) {
    add_action("wp_enqueue_scripts", 'trx_addons_cpt_layouts_load_scripts_front');
    function trx_addons_cpt_layouts_load_scripts_front()
    {
        if (trx_addons_exists_page_builder() && trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
            wp_enqueue_style('trx_addons-cpt_layouts', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'layouts/layouts.css'), array(), null);
            wp_enqueue_script('trx_addons-cpt_layouts', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'layouts/layouts.js'), array('jquery'), null, true);
        }
    }
}


// Merge shortcode's specific styles into single stylesheet
if (!function_exists('trx_addons_cpt_layouts_merge_styles')) {
    add_action("trx_addons_filter_merge_styles", 'trx_addons_cpt_layouts_merge_styles');
    function trx_addons_cpt_layouts_merge_styles($list)
    {
        if (trx_addons_exists_visual_composer()) $list[] = TRX_ADDONS_PLUGIN_CPT . 'layouts/layouts.css';
        return $list;
    }
}


// Merge shortcode's specific scripts into single file
if (!function_exists('trx_addons_cpt_layouts_merge_scripts')) {
    add_action("trx_addons_filter_merge_scripts", 'trx_addons_cpt_layouts_merge_scripts');
    function trx_addons_cpt_layouts_merge_scripts($list)
    {
        if (trx_addons_exists_page_builder()) $list[] = TRX_ADDONS_PLUGIN_CPT . 'layouts/layouts.js';
        return $list;
    }
}

// Check if layouts components are showed or set new state
if (!function_exists('trx_addons_sc_layouts_showed')) {
    function trx_addons_sc_layouts_showed($name, $val = null)
    {
        global $TRX_ADDONS_STORAGE;
        if ($val !== null) {
            if (!isset($TRX_ADDONS_STORAGE['sc_layouts_components'])) $TRX_ADDONS_STORAGE['sc_layouts_components'] = array();
            $TRX_ADDONS_STORAGE['sc_layouts_components'][$name] = $val;
        } else
            return isset($TRX_ADDONS_STORAGE['sc_layouts_components'][$name]) ? $TRX_ADDONS_STORAGE['sc_layouts_components'][$name] : false;
    }
}


// Admin utils
// -----------------------------------------------------------------

// Add query vars to filter posts
if (!function_exists('trx_addons_cpt_layouts_pre_get_posts')) {
    add_action('pre_get_posts', 'trx_addons_cpt_layouts_pre_get_posts');
    function trx_addons_cpt_layouts_pre_get_posts($query)
    {
        if (!$query->is_main_query() || !is_admin()) return;
        if ($query->get('post_type') == TRX_ADDONS_CPT_LAYOUTS_PT) {
            $layout_type = trx_addons_get_value_gp('layout_type');
            if (!empty($layout_type)) {
                $query->set('meta_key', 'trx_addons_layout_type');
                $query->set('meta_value', $layout_type);
            }
        }
    }
}

// Create additional column in the posts list
if (!function_exists('trx_addons_cpt_layouts_add_custom_column')) {
    add_filter('manage_edit-' . trx_addons_cpt_param('layouts', 'post_type') . '_columns', 'trx_addons_cpt_layouts_add_custom_column', 9);
    function trx_addons_cpt_layouts_add_custom_column($columns)
    {
        if (is_array($columns) && count($columns) > 0) {
            $new_columns = array();
            $tmp = '';
            foreach ($columns as $k => $v) {
                if ($k == 'author') {
                    $tmp = $v;
                    continue;
                } else if ($k == 'date')
                    $new_columns['author'] = $tmp;
                $new_columns[$k] = $v;
                if ($k == 'title') {
                    $new_columns['cpt_layouts_image'] = esc_html__('Image', 'trx_addons');
                    $new_columns['cpt_layouts_type'] = esc_html__('Type', 'trx_addons');
                }
            }
            $columns = $new_columns;
        }
        return $columns;
    }
}

// Fill image column in the posts list
if (!function_exists('trx_addons_cpt_layouts_fill_custom_column')) {
    add_action('manage_' . trx_addons_cpt_param('layouts', 'post_type') . '_posts_custom_column', 'trx_addons_cpt_layouts_fill_custom_column', 9, 2);
    function trx_addons_cpt_layouts_fill_custom_column($column_name = '', $post_id = 0)
    {
        if ($column_name == 'cpt_layouts_image') {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), trx_addons_get_thumb_size('masonry'));
            if (!empty($image[0])) {
                ?><img class="trx_addons_cpt_column_image_preview trx_addons_cpt_layouts_image_preview"
                       src="<?php echo esc_url($image[0]); ?>" alt="<?php esc_attr_e("Layout's preview", 'trx_addons'); ?>"<?php if (!empty($image[1])) echo ' width="' . intval($image[1]) . '"'; ?><?php if (!empty($image[2])) echo ' height="' . intval($image[2]) . '"'; ?>><?php
            }
        } else if ($column_name == 'cpt_layouts_type') {
            $type = get_post_meta($post_id, 'trx_addons_layout_type', true);
            if (!empty($type)) {
                ?>
                <div class="trx_addons_meta_row">
                <span class="trx_addons_meta_label"><?php echo esc_html(trx_addons_get_option_title(TRX_ADDONS_CPT_LAYOUTS_PT, 'layout_type', $type)); ?></span>
                </div><?php
            }
        }
    }
}

// Show <select> with layouts categories and with layout types in the admin filters area
if (!function_exists('trx_addons_cpt_layouts_admin_filters')) {
    add_action('restrict_manage_posts', 'trx_addons_cpt_layouts_admin_filters');
    function trx_addons_cpt_layouts_admin_filters()
    {
        if (get_query_var('post_type') != TRX_ADDONS_CPT_LAYOUTS_PT) return;
        // Layout's types
        $layout_type = trx_addons_get_value_gp('layout_type');
        $options = trx_addons_get_option_title(TRX_ADDONS_CPT_LAYOUTS_PT, 'layout_type');
        $list = '';
        if (is_array($options) && count($options) > 0) {
            $list .= '<select name="layout_type" id="layout_type" class="postform">';
            $list .= '<option value="">' . esc_html__('Any type', 'trx_addons') . '</option>';
            foreach ($options as $id => $title) {
                $list .= '<option value="' . esc_attr($id) . '"' . ($layout_type == $id ? ' selected="selected"' : '') . '>' . esc_html($title) . '</option>';
            }
            $list .= "</select>";
        }
        trx_addons_show_layout($list);
        // Layout's categories
        trx_addons_admin_filters(TRX_ADDONS_CPT_LAYOUTS_PT, TRX_ADDONS_CPT_LAYOUTS_TAXONOMY);
    }
}

// Clear terms cache on the taxonomy save
if (!function_exists('trx_addons_cpt_layouts_admin_clear_cache')) {
    add_action('edited_' . TRX_ADDONS_CPT_LAYOUTS_TAXONOMY, 'trx_addons_cpt_layouts_admin_clear_cache', 10, 1);
    add_action('delete_' . TRX_ADDONS_CPT_LAYOUTS_TAXONOMY, 'trx_addons_cpt_layouts_admin_clear_cache', 10, 1);
    add_action('created_' . TRX_ADDONS_CPT_LAYOUTS_TAXONOMY, 'trx_addons_cpt_layouts_admin_clear_cache', 10, 1);
    function trx_addons_cpt_layouts_admin_clear_cache($term_id = 0)
    {
        trx_addons_admin_clear_cache_terms(TRX_ADDONS_CPT_LAYOUTS_TAXONOMY);
    }
}


// Shortcodes utilities
// -----------------------------------------------------------------

// Shortcodes utilities
// -----------------------------------------------------------------

// Show layout with specified ID
if (!function_exists('trx_addons_cpt_layouts_show_layout')) {
    add_action('trx_addons_action_show_layout', 'trx_addons_cpt_layouts_show_layout', 10);
    function trx_addons_cpt_layouts_show_layout($id)
    {
        $layout = get_post($id);
        if (!empty($layout)) {
            $content = shortcode_unautop(trim($layout->post_content));
            trx_addons_sc_stack_push('show_layout');
            $from_content = trx_addons_sc_stack_check('trx_sc_layouts');
            if ($from_content) {
                global $post;
                $post = $layout;
                setup_postdata($layout);
            }
            trx_addons_sc_stack_push('show_layout');
            trx_addons_show_layout(
                apply_filters('trx_addons_filter_sc_layout_content',
                    shortcode_unautop(trim($layout->post_content)),
                    $layout->ID
                )
            );
            trx_addons_sc_stack_pop();
            if ($from_content) {
                wp_reset_postdata();
            }
        }
    }
}

// Replace macros in the content
if (!function_exists('trx_addons_cpt_layouts_prepare_macros')) {
	add_filter('trx_addons_filter_sc_layout_prepare_macros', 'trx_addons_cpt_layouts_prepare_macros');
	function trx_addons_cpt_layouts_prepare_macros($content, $id = 0)
	{
	  if($content)  {
		  return str_replace(array('{{Y}}', '{Y}'), date('Y'), $content);
	  }
	}
}


// Wrap shortcode's output into .sc_layouts_item if shortcode inside custom layout
if (!function_exists('trx_addons_cpt_layouts_sc_wrap')) {
    add_filter('trx_addons_sc_output', 'trx_addons_cpt_layouts_sc_wrap', 1000, 4);
    function trx_addons_cpt_layouts_sc_wrap($output, $sc, $atts, $content)
    {
        global $TRX_ADDONS_STORAGE;
        $tag = !empty($output) && !empty($TRX_ADDONS_STORAGE['inside_cpt_layouts']) && !in_array($sc, array('trx_sc_layouts', 'trx_sc_content'))
            ? substr($output, 0, strpos($output, '>'))
            : '';
        return !empty($tag)
            ? '<div class="sc_layouts_item '
            . (strpos($tag, 'hide_on_mobile') !== false && strpos($output, 'sc_layouts_menu_mobile_button') === false
                ? ' sc_layouts_hide_on_mobile'
                : '')
            . (strpos($tag, 'hide_on_tablet') !== false && strpos($output, 'sc_layouts_menu_mobile_button') === false
                ? ' sc_layouts_hide_on_tablet'
                : '')
            . (strpos($tag, 'hide_on_notebook') !== false && strpos($output, 'sc_layouts_menu_mobile_button') === false
                ? ' sc_layouts_hide_on_notebook'
                : '')
            . '">'
            . trim($output)
            . '</div>'
            : $output;
    }
}

// Add common classes to the shortcode's output
if (!function_exists('trx_addons_cpt_layouts_sc_add_classes')) {
    function trx_addons_cpt_layouts_sc_add_classes($args)
    {
        if (!empty($args['hide_on_desktop'])) echo ' hide_on_desktop';
        if (!empty($args['hide_on_notebook'])) echo ' hide_on_notebook';
        if (!empty($args['hide_on_tablet'])) echo ' hide_on_tablet';
        if (!empty($args['hide_on_mobile'])) echo ' hide_on_mobile';
        if (!empty($args['hide_on_frontpage'])) echo ' hide_on_frontpage';
        if (!empty($args['hide_on_singular'])) echo ' hide_on_singular';
        if (!empty($args['hide_on_other'])) echo ' hide_on_other';
        if (!empty($args['class'])) echo ' ' . esc_attr($args['class']);
        if (!empty($args['align']) && !trx_addons_is_inherit($args['align']))
            echo ' sc_align_' . esc_attr($args['align']);
    }
}

// trx_sc_layouts
//-------------------------------------------------------------
/*
[trx_sc_layouts id="unique_id" layout="layout_id"]
*/
if (!function_exists('trx_addons_sc_layouts')) {
    function trx_addons_sc_layouts($atts, $content = '')
    {
        $atts = trx_addons_sc_prepare_atts('trx_sc_layouts', $atts, array(
                // Individual params
                "type" => "default",
                "layout" => "",
                // Common params
                "id" => "",
                "class" => "",
                "popup_id" => "",        // Alter name for id in Elementor ('id' is reserved by Elementor)
                "css" => ""
            )
        );

        if (!empty($atts['layout'])) $atts['layout'] = apply_filters('trx_addons_filter_get_translated_layout', $atts['layout']);

        ob_start();
        trx_addons_get_template_part(array(
            TRX_ADDONS_PLUGIN_CPT . 'layouts/tpl.' . trx_addons_esc($atts['type']) . '.php',
            TRX_ADDONS_PLUGIN_CPT . 'layouts/tpl.default.php'
        ),
            'trx_addons_args_sc_layouts',
            $atts
        );
        $output = ob_get_contents();
        ob_end_clean();

        return apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts', $atts, $content);
    }
}


// Add [trx_sc_layouts] in the VC shortcodes list
if (!function_exists('trx_addons_sc_layouts_add_in_vc')) {
    function trx_addons_sc_layouts_add_in_vc()
    {

        if (!trx_addons_exists_visual_composer()) return;

        add_shortcode("trx_sc_layouts", "trx_addons_sc_layouts");

        vc_lean_map("trx_sc_layouts", 'trx_addons_sc_layouts_add_in_vc_params');

        class WPBakeryShortCode_Trx_Sc_Layouts extends WPBakeryShortCode
        {
        }
    }

    add_action('init', 'trx_addons_sc_layouts_add_in_vc', 20);
}


// Return params
if (!function_exists('trx_addons_sc_layouts_add_in_vc_params')) {
    function trx_addons_sc_layouts_add_in_vc_params()
    {
        // If open params in VC Editor
        $vc_edit = is_admin() && trx_addons_get_value_gp('action') == 'vc_edit_form' && trx_addons_get_value_gp('tag') == 'trx_sc_layouts';
        $vc_params = $vc_edit && isset($_POST['params']) ? $_POST['params'] : array();
        // Prepare lists
        $layout = $vc_edit && !empty($vc_params['layout']) ? $vc_params['layout'] : 0;

        return apply_filters('trx_addons_sc_map', array(
            "base" => "trx_sc_layouts",
            "name" => esc_html__("Layouts", 'trx_addons'),
            "description" => wp_kses_data(__("Display previously created layout (header, footer, etc.)", 'trx_addons')),
            "category" => esc_html__('ThemeREX', 'trx_addons'),
            "icon" => 'icon_trx_sc_layouts',
            "class" => "trx_sc_layouts",
            "content_element" => true,
            "is_container" => false,
            "show_settings_on_create" => true,
            "params" => array_merge(
                array(
                    array(
                        "param_name" => "type",
                        "heading" => esc_html__("Type", 'trx_addons'),
                        "description" => wp_kses_data(__("Select shortcodes's type", 'trx_addons')),
                        "std" => "default",
                        "value" => apply_filters('trx_addons_sc_type', array(
                            esc_html__('Default', 'trx_addons') => 'default',
                        ), 'trx_sc_layouts'),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "layout",
                        "heading" => esc_html__("Layout", 'trx_addons'),
                        "description" => wp_kses_post(__("Select any previously created layout to insert to this page", 'trx_addons')
                            . '<br>'
                            . sprintf('<a href="%s" class="trx_addons_post_editor" target="_blank">%s</a>',
                                get_edit_post_link($layout),
                                __("Open selected layout in a new tab", 'trx_addons')
                            )
                        ),
                        "admin_label" => true,
                        'save_always' => true,
                        "value" => array_flip(trx_addons_get_list_posts(false, TRX_ADDONS_CPT_LAYOUTS_PT)),
                        "type" => "dropdown"
                    )
                ),
                trx_addons_vc_add_id_param()
            )
        ), 'trx_sc_layouts');
    }
}


// WPBakery Page Builder support utilities
//----------------------------------------------------
if (trx_addons_exists_visual_composer() && ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "layouts/layouts_vc.php")) != '') {
    $trx_addons_need = true;
    $trx_addons_wp_action = trx_addons_get_value_gp('action');
    if (is_admin() && get_option('trx_addons_action') == '' && !in_array($trx_addons_wp_action, array('ajax_search', 'vc_load_template_preview'))) {
        $trx_addons_need = strpos($_SERVER['REQUEST_URI'], 'post-new.php') !== false && trx_addons_get_value_gp('post_type') == TRX_ADDONS_CPT_LAYOUTS_PT;
        if (!$trx_addons_need && (
                (strpos($_SERVER['REQUEST_URI'], 'post.php') !== false && ($trx_addons_id = (int)trx_addons_get_value_gp('post')) > 0)
                ||
                ($trx_addons_wp_action == 'vc_edit_form' && ($trx_addons_id = (int)trx_addons_get_value_gp('post_id')) > 0)
            )) {
            $trx_addons_post = get_post($trx_addons_id);
            $trx_addons_need = is_object($trx_addons_post) && $trx_addons_post->post_type == TRX_ADDONS_CPT_LAYOUTS_PT;
        }
    }
    if ($trx_addons_need) {
        include_once $fdir;
    }
}


// One-click import support
//------------------------------------------------------------------------

// Export custom layouts
if (!function_exists('trx_addons_cpt_layouts_importer_export')) {
    if (is_admin()) add_action('trx_addons_action_importer_export', 'trx_addons_cpt_layouts_importer_export', 10, 1);
    function trx_addons_cpt_layouts_importer_export($importer)
    {
        $posts = get_posts(array(
                'post_type' => TRX_ADDONS_CPT_LAYOUTS_PT,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'ignore_sticky_posts' => true,
                'orderby' => 'post_title',
                'order' => 'ASC'
            )
        );
        $output = '';
        if (is_array($posts) && count($posts) > 0) {
            $output = "<?php"
                . "\n//" . esc_html__('Custom Layouts', 'trx_addons')
                . "\n\$layouts = array(";
            $counter = 0;
            foreach ($posts as $post) {
                $vc_custom_css = get_post_meta($post->ID, '_wpb_shortcodes_custom_css', true);
                $layout_type = get_post_meta($post->ID, 'trx_addons_layout_type', true);
                $output .= ($counter++ ? ',' : '')
                    . "\n\t\t'" . trim($layout_type) . '_' . $post->ID . "' => array("
                    . "\n\t\t\t\t'name' => '" . addslashes($post->post_title) . "',"
                    . "\n\t\t\t\t'template' => '" . addslashes(str_replace(array("\x0D\x0A", "©", " "), array("\x0A", "&copy;", "&nbsp;"), $post->post_content)) . "',"
                    . "\n\t\t\t\t'meta' => array("
                    . "\n\t\t\t\t\t\t'trx_addons_options' => array("
                    . "\n\t\t\t\t\t\t\t\t'layout_type' => '{$layout_type}'"
                    . "\n\t\t\t\t\t\t\t\t)"
                    . (empty($vc_custom_css) ? '' : ",\n\t\t\t\t\t\t'_wpb_shortcodes_custom_css' => '{$vc_custom_css}'")
                    . "\n\t\t\t\t\t\t)"
                    . "\n\t\t\t\t)";
            }
            $output .= "\n\t\t);"
                . "\n?>";
        }
        trx_addons_fpc(trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_IMPORTER . 'export/layouts.txt'), $output);
    }
}

// Display exported data in the fields
if (!function_exists('trx_addons_cpt_layouts_importer_export_fields')) {
    if (is_admin()) add_action('trx_addons_action_importer_export_fields', 'trx_addons_cpt_layouts_importer_export_fields', 11, 1);
    function trx_addons_cpt_layouts_importer_export_fields($importer)
    {
        $importer->show_exporter_fields(array(
                'slug' => 'layouts',
                'title' => esc_html__('Custom Layouts', 'trx_addons'),
                'download' => 'trx_addons.layouts.php'
            )
        );
    }
}

// Check if current screen require for the VC and/or SOW support
if (!function_exists('trx_addons_cpt_layouts_sc_required')) {
    function trx_addons_cpt_layouts_sc_required()
    {
        static $need = -1;
        if ($need === -1) {
            $need = true;
            $wp_action = trx_addons_get_value_gp('action');
            $vc_action = trx_addons_get_value_gp('vc_action');
            if (is_admin()
                && get_option('trx_addons_action') == ''
                && !in_array($wp_action, array('ajax_search', 'vc_load_template_preview'))
            ) {
                $need = strpos($_SERVER['REQUEST_URI'], 'post-new.php') !== false
                    && trx_addons_get_value_gp('post_type') == TRX_ADDONS_CPT_LAYOUTS_PT;
                if (!$need)
                    $need = in_array($wp_action, array('so_panels_widget_form', 'so_panels_style_form', 'so_panels_builder_content'));
                if (!$need
                    && (
                        ($wp_action == 'editpost' && ($post_id = (int)trx_addons_get_value_gp('post_ID')) > 0)
                        ||
                        (strpos($_SERVER['REQUEST_URI'], 'post.php') !== false && ($post_id = (int)trx_addons_get_value_gp('post')) > 0)
                        ||
                        (($wp_action == 'vc_edit_form' || $vc_action == 'vc_inline') && ($post_id = (int)trx_addons_get_value_gp('post_id')) > 0)
                    )
                ) {
                    $post_obj = get_post($post_id);
                    $need = is_object($post_obj) && $post_obj->post_type == TRX_ADDONS_CPT_LAYOUTS_PT;
                }
            }
        }
        return $need;
    }
}

// Include shortcodes for the Layouts builder
// Attention! Use priority 7 because this file is included in the handler with priority 6
if (!function_exists('trx_addons_cpt_layouts_sc_load')) {
    add_action('after_setup_theme', 'trx_addons_cpt_layouts_sc_load', 7);
    function trx_addons_cpt_layouts_sc_load()
    {
        static $loaded = false;
        if ($loaded !== false) return;
        $loaded = '';

        foreach (trx_addons_components_get_allowed_layouts('cpt', 'layouts', 'sc') as $sc => $title) {
            $loaded .= $sc . ',';
            if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "{$sc}/{$sc}.php")) != '') {
                include_once $fdir;
            }
        }
        // Load sc 'layouts' anyway
        $sc = 'layouts';
        if (strpos($loaded, $sc . ',') === false) {
            if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "{$sc}/{$sc}.php")) != '') {
                include_once $fdir;
            }
        }
    }
}


// Use layouts as WordPress submenu
if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "layouts/layouts_submenu.php")) != '') {
    include_once $fdir;
}

// WPBakery Page Builder support utilities
if (trx_addons_exists_visual_composer()
    && ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "layouts/layouts_vc.php")) != '') {
    include_once $fdir;
}

// Elementor support utilities
if (trx_addons_exists_elementor() && trx_addons_components_is_allowed('api', 'elementor')
    && ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "layouts/layouts_elementor.php")) != '') {
    include_once $fdir;
}

?>
