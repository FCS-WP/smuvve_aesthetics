<?php
/**
 * Lists generators
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.22
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Return numbers range
if ( !function_exists( 'trx_addons_get_list_range' ) ) {
	function trx_addons_get_list_range($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = $i;
		return $prepend_inherit 
				? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
				: $list;
	}
}

// Return months list
if ( !function_exists( 'trx_addons_get_list_months' ) ) {
    function trx_addons_get_list_months($prepend_inherit=false) {
        $list = array();
        for ($i=1; $i<=12; $i++)
            $list[$i] = date_i18n('F', strtotime('2018-'.$i.'-01'));
        return $prepend_inherit
            ? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list)
            : $list;
    }
}


// Return list of categories
if ( !function_exists( 'trx_addons_get_list_categories' ) ) {
	function trx_addons_get_list_categories($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			$taxonomies = get_categories( array(
											'type' => 'post',
											'orderby' => 'name',
											'order' => 'ASC',
											'hide_empty' => 0,
											'hierarchical' => 1,
											'taxonomy' => 'category',
											'pad_counts' => false
											)
										);
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
		}
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
					: $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'trx_addons_get_list_terms' ) ) {
	function trx_addons_get_list_terms($prepend_inherit=false, $taxonomy='category', $opt=array()) {
		static $list = array();
		$opt = array_merge(array(
			'meta_query' => '',
			'meta_key'	 => '',
			'meta_value' => '',
			'pad_counts' => false
			), $opt);
		$hash = 'list_terms'
				. '_' . (is_array($taxonomy) ? join('_', $taxonomy) : $taxonomy)
				. '_' . ($opt['meta_key'])
				. '_' . ($opt['meta_value'])
				. '_' . (is_array($opt['meta_query']) ? serialize($opt['meta_query']) : $opt['meta_query']);
		if (empty($list[$hash])) {
			$list[$hash] = array();
			if ( is_array($taxonomy) || taxonomy_exists($taxonomy) ) {
				$args = array(
					'orderby' => 'name',
					'order' => 'ASC',
					'hide_empty' => 0,
					'hierarchical' => 1,
					'taxonomy' => $taxonomy,
					'pad_counts' => $opt['pad_counts']
					);
				if (is_array($opt['meta_query'])) 
					$args['meta_query'] = $opt['meta_query'];
				else if (!empty($opt['meta_key'])) {
					$args['meta_key'] = $opt['meta_key'];
					$args['meta_value'] = $opt['meta_value'];
				}
				$terms = get_terms( $taxonomy, $args);
			} else {
				$terms = trx_addons_get_terms_by_taxonomy_from_db($taxonomy, $opt);
			}
			if (!is_wp_error( $terms ) && is_array($terms) && count($terms) > 0) {
				foreach ($terms as $term) {
					$list[$hash][$term->term_id] = $term->name;	// . ($taxonomy!='category' ? ' /'.($cat->taxonomy).'/' : '');
				}
			}
		}
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list[$hash]) 
					: $list[$hash];
	}
}

// Return list of post's types
if ( !function_exists( 'trx_addons_get_list_posts_types' ) ) {
	function trx_addons_get_list_posts_types($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$types = get_post_types(array('public'=>true), 'objects');
			$list = array();
			if (is_array($types)) {
				foreach ($types as $slug => $type)
					$list[$type->name] = $type->label;
			}
		}
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
					: $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'trx_addons_get_list_posts' ) ) {
	function trx_addons_get_list_posts($prepend_inherit=false, $opt=array()) {
		static $list = array();
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'post_parent'		=> '',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'meta_key'			=> '',
			'meta_value'		=> '',
			'meta_compare'		=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'not_selected'		=> true,
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts'
				. '_' . (is_array($opt['post_type']) ? join('_', $opt['post_type']) : $opt['post_type'])
				. '_' . (is_array($opt['post_parent']) ? join('_', $opt['post_parent']) : $opt['post_parent'])
				. '_' . ($opt['taxonomy'])
				. '_' . (is_array($opt['taxonomy_value']) ? join('_', $opt['taxonomy_value']) : $opt['taxonomy_value'])
				. '_' . ($opt['meta_key'])
				. '_' . ($opt['meta_compare'])
				. '_' . ($opt['meta_value'])
				. '_' . ($opt['orderby'])
				. '_' . ($opt['order'])
				. '_' . ($opt['return'])
				. '_' . ($opt['posts_per_page']);
		if (!isset($list[$hash])) {
			$list[$hash] = array();
			if ($opt['not_selected']!==false) $list[$hash]['none'] = $opt['not_selected']===true 
																					? esc_html__("- Not selected -", 'trx_addons')
																					: $opt['not_selected'];
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['post_parent'])) {
				if (is_array($opt['post_parent']))
					$args['post_parent__in'] = $opt['post_parent'];
				else
					$args['post_parent'] = $opt['post_parent'];
			}
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => is_array($opt['taxonomy_value']) 
										? ((int) $opt['taxonomy_value'][0] > 0  ? 'term_taxonomy_id' : 'slug')
										: ((int) $opt['taxonomy_value'] > 0  ? 'term_taxonomy_id' : 'slug'),
						'terms' => is_array($opt['taxonomy_value'])
										? $opt['taxonomy_value'] 
										: ((int) $opt['taxonomy_value'] > 0 ? (int) $opt['taxonomy_value'] : $opt['taxonomy_value'] ) 
					)
				);
			}
			if (!empty($opt['meta_key'])) {
				$args['meta_key'] = $opt['meta_key'];
			}
			if (!empty($opt['meta_value'])) {
				$args['meta_value'] = $opt['meta_value'];
			}
			if (!empty($opt['meta_compare'])) {
				$args['meta_compare'] = $opt['meta_compare'];
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$hash][$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
		}
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list[$hash]) 
					: $list[$hash];
	}
}


// Return list pages
if ( !function_exists( 'trx_addons_get_list_pages' ) ) {
	function trx_addons_get_list_pages($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'taxonomy'			=> '',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'title',
			'order'				=> 'asc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));
		return trx_addons_get_list_posts($prepend_inherit, $opt);
	}
}



// Return list of the custom layouts
if ( !function_exists( 'trx_addons_get_list_layouts' ) ) {
    function trx_addons_get_list_layouts($type='custom', $order='ID') {
        if (defined('TRX_ADDONS_CPT_LAYOUTS_PT')) {
            $list = trx_addons_get_list_posts(false, array(
                    'post_type' => TRX_ADDONS_CPT_LAYOUTS_PT,
                    'meta_key' => 'trx_addons_layout_type',
                    'meta_value' => $type,
                    'orderby' => $order,
                    'order' => 'asc',
                    'not_selected' => true
                )
            );
        } else
            $list = array();
        return $list;
    }
}

// Return list of cases when layouts should be showed
if ( !function_exists( 'trx_addons_get_list_layouts_show_on_load' ) ) {
    function trx_addons_get_list_layouts_show_on_load( $prepend_inherit = false ) {
        $list = apply_filters('trx_addons_filter_get_list_layouts_display', array(
            'none'				=> esc_html__('Do not show on page loads',	'trx_addons'),
            'on_page_load'		=> esc_html__('Every time the page loads',	'trx_addons'),
            'on_page_load_once'	=> esc_html__('When the page first loads',	'trx_addons'),
        ));
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
            : $list;
    }
}

// Return list of registered users
if ( !function_exists( 'trx_addons_get_list_users' ) ) {
	function trx_addons_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		static $list = false;
		if ($list === false) {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'trx_addons');
			$users = get_users(array(
									'orderby' => 'display_name',
									'order' => 'ASC'
									)
								);
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
		}
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
					: $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'trx_addons_get_list_icons' ) ) {
	function trx_addons_get_list_icons($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = apply_filters('trx_addons_filter_get_list_icons', $list, $prepend_inherit);
			if ($list === false)
				$list = trx_addons_parse_icons_classes(trx_addons_get_file_dir("css/font-icons/css/trx_addons_icons-codes.css"));
			if (!isset($list['none'])) $list = trx_addons_array_merge(array('none' => 'none'), $list);
		}
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
					: $list;
	}
}


// Return list files in the folder
if ( !function_exists('trx_addons_get_list_files')) {	
	function trx_addons_get_list_files($folder, $ext='', $only_names=false) {
		static $list = array();
		$hash = $folder.'_'.$ext.'_'.($only_names ? '1' : '0');
		if (!isset($list[$hash])) {
			$dir = trx_addons_get_folder_dir($folder);
			$url = trx_addons_get_folder_url($folder);
			$list[$hash] = array();
			if ( !empty($dir) && is_dir($dir) ) {
				$files = @glob(sprintf("%s/%s", $dir, !empty($ext) ? "*.{$ext}" : '*.*'));
				if ( is_array($files) ) {
					foreach ($files as $file) {
						if ( substr($file, 0, 1) == '.' || is_dir( $file ) )
							continue;
						$file = basename($file);
						$key = substr($file, 0, strrpos($file, '.'));
						if (substr($key, -4)=='.min') $key = substr($file, 0, strrpos($key, '.'));
						$list[$hash][$key] = $only_names ? ucfirst(str_replace('_', ' ', $key)) : ($url) . '/' . ($file);
					}
				}
				if (!isset($list[$hash]['none'])) $list[$hash] = trx_addons_array_merge(array('none' => ''), $list[$hash]);
			}
		}
		return $list[$hash];
	}
}

// Return input hover effects
if ( !function_exists( 'trx_addons_get_list_input_hover' ) ) {
	function trx_addons_get_list_input_hover($prepend_inherit=false) {
		$list = apply_filters('trx_addons_filter_get_list_input_hover', array(
			'default'	=> esc_html__('Default',	'trx_addons'),
			'accent'	=> esc_html__('Accented',	'trx_addons'),
			'path'		=> esc_html__('Path',		'trx_addons'),
			'jump'		=> esc_html__('Jump',		'trx_addons'),
			'underline'	=> esc_html__('Underline',	'trx_addons'),
			'iconed'	=> esc_html__('Iconed',		'trx_addons'),
		));
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
					: $list;
	}
}

// Return menu hover effects
if ( !function_exists( 'trx_addons_get_list_menu_hover' ) ) {
	function trx_addons_get_list_menu_hover($prepend_inherit=false) {
		$list = apply_filters('trx_addons_filter_get_list_menu_hover', array(
			'fade'			=> esc_html__('Fade',		'trx_addons'),
			'fade_box'		=> esc_html__('Fade Box',	'trx_addons'),
			'slide_line'	=> esc_html__('Slide Line',	'trx_addons'),
			'slide_box'		=> esc_html__('Slide Box',	'trx_addons'),
			'zoom_line'		=> esc_html__('Zoom Line',	'trx_addons'),
			'path_line'		=> esc_html__('Path Line',	'trx_addons'),
			'roll_down'		=> esc_html__('Roll Down',	'trx_addons'),
			'color_line'	=> esc_html__('Color Line',	'trx_addons'),
		));
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
					: $list;
	}
}

// Return list of the enter animations
if ( !function_exists( 'trx_addons_get_list_animations_in' ) ) {
	function trx_addons_get_list_animations_in($prepend_inherit=false) {
		$list = apply_filters('trx_addons_filter_get_list_animations_in', array(
			'none'				=> esc_html__('- None -',			'trx_addons'),
			'bounceIn'			=> esc_html__('Bounce In',			'trx_addons'),
			'bounceInUp'		=> esc_html__('Bounce In Up',		'trx_addons'),
			'bounceInDown'		=> esc_html__('Bounce In Down',		'trx_addons'),
			'bounceInLeft'		=> esc_html__('Bounce In Left',		'trx_addons'),
			'bounceInRight'		=> esc_html__('Bounce In Right',	'trx_addons'),
			'elastic'			=> esc_html__('Elastic In',			'trx_addons'),
			'fadeIn'			=> esc_html__('Fade In',			'trx_addons'),
			'fadeInUp'			=> esc_html__('Fade In Up',			'trx_addons'),
			'fadeInUpSmall'		=> esc_html__('Fade In Up Small',	'trx_addons'),
			'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'trx_addons'),
			'fadeInDown'		=> esc_html__('Fade In Down',		'trx_addons'),
			'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'trx_addons'),
			'fadeInLeft'		=> esc_html__('Fade In Left',		'trx_addons'),
			'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'trx_addons'),
			'fadeInRight'		=> esc_html__('Fade In Right',		'trx_addons'),
			'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'trx_addons'),
			'flipInX'			=> esc_html__('Flip In X',			'trx_addons'),
			'flipInY'			=> esc_html__('Flip In Y',			'trx_addons'),
			'lightSpeedIn'		=> esc_html__('Light Speed In',		'trx_addons'),
			'rotateIn'			=> esc_html__('Rotate In',			'trx_addons'),
			'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','trx_addons'),
			'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'trx_addons'),
			'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'trx_addons'),
			'rotateInDownRight'	=> esc_html__('Rotate In Down Right','trx_addons'),
			'rollIn'			=> esc_html__('Roll In',			'trx_addons'),
			'slideInUp'			=> esc_html__('Slide In Up',		'trx_addons'),
			'slideInDown'		=> esc_html__('Slide In Down',		'trx_addons'),
			'slideInLeft'		=> esc_html__('Slide In Left',		'trx_addons'),
			'slideInRight'		=> esc_html__('Slide In Right',		'trx_addons'),
			'wipeInLeftTop'		=> esc_html__('Wipe In Left Top',	'trx_addons'),
			'zoomIn'			=> esc_html__('Zoom In',			'trx_addons'),
			'zoomInUp'			=> esc_html__('Zoom In Up',			'trx_addons'),
			'zoomInDown'		=> esc_html__('Zoom In Down',		'trx_addons'),
			'zoomInLeft'		=> esc_html__('Zoom In Left',		'trx_addons'),
			'zoomInRight'		=> esc_html__('Zoom In Right',		'trx_addons')
		));
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
					: $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'trx_addons_get_list_animations_out' ) ) {
	function trx_addons_get_list_animations_out($prepend_inherit=false) {
		$list = apply_filters('trx_addons_filter_get_list_animations_out', array(
			'none'			=> esc_html__('- None -',			'trx_addons'),
			'bounceOut'		=> esc_html__('Bounce Out',			'trx_addons'),
			'bounceOutUp'	=> esc_html__('Bounce Out Up',		'trx_addons'),
			'bounceOutDown'	=> esc_html__('Bounce Out Down',	'trx_addons'),
			'bounceOutLeft'	=> esc_html__('Bounce Out Left',	'trx_addons'),
			'bounceOutRight'=> esc_html__('Bounce Out Right',	'trx_addons'),
			'fadeOut'		=> esc_html__('Fade Out',			'trx_addons'),
			'fadeOutUp'		=> esc_html__('Fade Out Up',		'trx_addons'),
			'fadeOutUpBig'	=> esc_html__('Fade Out Up Big',	'trx_addons'),
			'fadeOutDownSmall'	=> esc_html__('Fade Out Down Small','trx_addons'),
			'fadeOutDownBig'=> esc_html__('Fade Out Down Big',	'trx_addons'),
			'fadeOutDown'	=> esc_html__('Fade Out Down',		'trx_addons'),
			'fadeOutLeft'	=> esc_html__('Fade Out Left',		'trx_addons'),
			'fadeOutLeftBig'=> esc_html__('Fade Out Left Big',	'trx_addons'),
			'fadeOutRight'	=> esc_html__('Fade Out Right',		'trx_addons'),
			'fadeOutRightBig'=> esc_html__('Fade Out Right Big','trx_addons'),
			'flipOutX'		=> esc_html__('Flip Out X',			'trx_addons'),
			'flipOutY'		=> esc_html__('Flip Out Y',			'trx_addons'),
			'hinge'			=> esc_html__('Hinge Out',			'trx_addons'),
			'lightSpeedOut'	=> esc_html__('Light Speed Out',	'trx_addons'),
			'rotateOut'		=> esc_html__('Rotate Out',			'trx_addons'),
			'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left',	'trx_addons'),
			'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right',	'trx_addons'),
			'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',		'trx_addons'),
			'rotateOutDownRight'=> esc_html__('Rotate Out Down Right',	'trx_addons'),
			'rollOut'			=> esc_html__('Roll Out',		'trx_addons'),
			'slideOutUp'		=> esc_html__('Slide Out Up',	'trx_addons'),
			'slideOutDown'		=> esc_html__('Slide Out Down',	'trx_addons'),
			'slideOutLeft'		=> esc_html__('Slide Out Left',	'trx_addons'),
			'slideOutRight'		=> esc_html__('Slide Out Right','trx_addons'),
			'zoomOut'			=> esc_html__('Zoom Out',		'trx_addons'),
			'zoomOutUp'			=> esc_html__('Zoom Out Up',	'trx_addons'),
			'zoomOutDown'		=> esc_html__('Zoom Out Down',	'trx_addons'),
			'zoomOutLeft'		=> esc_html__('Zoom Out Left',	'trx_addons'),
			'zoomOutRight'		=> esc_html__('Zoom Out Right',	'trx_addons')
		));
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
					: $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('trx_addons_get_animation_classes')) {
	function trx_addons_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return trx_addons_is_off($animation) 
					? '' 
					: 'animated '.esc_attr($animation).' '.esc_attr($speed).(!trx_addons_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'trx_addons_get_list_menus' ) ) {
	function trx_addons_get_list_menus($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'trx_addons');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
		}
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
					: $list;
	}
}

// Return menu locations list, prepended inherit
if ( !function_exists( 'trx_addons_get_list_menu_locations' ) ) {
	function trx_addons_get_list_menu_locations($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'trx_addons');
			$menus = get_registered_nav_menus();
			if (is_array($menus)) {
				foreach ( $menus as $location => $description )
					$list[$location] = $description;
			}
			$list = apply_filters('trx_addons_filter_menu_locations', $list);
		}
		return $prepend_inherit 
					? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) 
					: $list;
	}
}

// Return list of the bg sizes to oversize content area
if ( !function_exists( 'trx_addons_get_list_sc_content_extra_bg' ) ) {
    function trx_addons_get_list_sc_content_extra_bg($none_key = 'none') {
        return apply_filters('trx_addons_filter_get_list_sc_content_extra_bg', array(
            $none_key => esc_html__('None', 'trx_addons'),
            'tiny' => esc_html__('Tiny', 'trx_addons'),
            'small' => esc_html__('Small', 'trx_addons'),
            'medium' => esc_html__('Medium', 'trx_addons'),
            'large' => esc_html__('Large', 'trx_addons')
        ));
    }
}

// Return list of the bg mask values to color tone of the bg image
if ( !function_exists( 'trx_addons_get_list_sc_content_extra_bg_mask' ) ) {
    function trx_addons_get_list_sc_content_extra_bg_mask($none_key = 'none') {
        return apply_filters('trx_addons_filter_get_list_sc_content_extra_bg_mask', array(
            $none_key => esc_html__('None', 'trx_addons'),
            'bg_color' => esc_html__('Use bg color', 'trx_addons'),
            '1'  => esc_html__('10%', 'trx_addons'),
            '2'  => esc_html__('20%', 'trx_addons'),
            '3'  => esc_html__('30%', 'trx_addons'),
            '4'  => esc_html__('40%', 'trx_addons'),
            '5'  => esc_html__('50%', 'trx_addons'),
            '6'  => esc_html__('60%', 'trx_addons'),
            '7'  => esc_html__('70%', 'trx_addons'),
            '8'  => esc_html__('80%', 'trx_addons'),
            '9'  => esc_html__('90%', 'trx_addons')
        ));
    }
}

// Return list of the shift sizes to move content along X- and/or Y-axis
if ( !function_exists( 'trx_addons_get_list_sc_content_shift' ) ) {
    function trx_addons_get_list_sc_content_shift($none_key = 'none') {
        return apply_filters('trx_addons_filter_get_list_sc_content_shift', array(
            $none_key => esc_html__('None', 'trx_addons'),
            'tiny' => esc_html__('Tiny', 'trx_addons'),
            'small' => esc_html__('Small', 'trx_addons'),
            'medium' => esc_html__('Medium', 'trx_addons'),
            'large' => esc_html__('Large', 'trx_addons'),
            'tiny_negative' => esc_html__('Tiny (negative)', 'trx_addons'),
            'small_negative' => esc_html__('Small (negative)', 'trx_addons'),
            'medium_negative' => esc_html__('Medium (negative)', 'trx_addons'),
            'large_negative' => esc_html__('Large (negative)', 'trx_addons')
        ));
    }
}

// Return list of the empty_space heights
if ( !function_exists( 'trx_addons_get_list_sc_empty_space_heights' ) ) {
    function trx_addons_get_list_sc_empty_space_heights($none_key = 'none') {
        return apply_filters('trx_addons_filter_get_list_sc_empty_space_heights', array(
            'tiny' => esc_html__('Tiny', 'trx_addons'),
            'small' => esc_html__('Small', 'trx_addons'),
            'medium' => esc_html__('Medium', 'trx_addons'),
            'large' => esc_html__('Large', 'trx_addons'),
            'huge' => esc_html__('Huge', 'trx_addons'),
            $none_key => esc_html__('From the value above', 'trx_addons'),
        ));
    }
}

// Lists for shortcode's parameters
//-------------------------------------------------------------------------

// Return list of the title align
if ( !function_exists( 'trx_addons_get_list_sc_aligns' ) ) {
    function trx_addons_get_list_sc_aligns($prepend_inherit=false, $add_none=true, $add_justify=false) {
        $list = array(
            'left' => esc_html__('Left', 'trx_addons'),
            'center' => esc_html__('Center', 'trx_addons'),
            'right' => esc_html__('Right', 'trx_addons')
        );
        if ($add_none) $list = trx_addons_array_merge(array('none' => esc_html__("Default", 'trx_addons')), $list);
        if ($add_justify) $list['justify'] = esc_html__("Justify", 'trx_addons');
        $list = apply_filters('trx_addons_filter_get_list_sc_aligns', $list);
        return $prepend_inherit
            ? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list)
            : $list;
    }
}

// Return list of the slider pagination types
if ( !function_exists( 'trx_addons_get_list_sc_slider_paginations_types' ) ) {
    function trx_addons_get_list_sc_slider_paginations_types() {
        return apply_filters('trx_addons_filter_get_list_sc_slider_paginations_types', array(
            'bullets' => esc_html__('Bullets', 'trx_addons'),
            'fraction' => esc_html__('Fraction (slide numbers)', 'trx_addons')
        ));
    }
}

// Return list of the slider titles
if ( !function_exists( 'trx_addons_get_list_sc_slider_titles' ) ) {
    function trx_addons_get_list_sc_slider_titles() {
        return apply_filters('trx_addons_filter_get_list_sc_slider_titles', array(
            'no' => esc_html__('No titles', 'trx_addons'),
            'center' => esc_html__('Center', 'trx_addons'),
            'bottom' => esc_html__('Bottom Center', 'trx_addons'),
            'lb' => esc_html__('Bottom Left', 'trx_addons'),
            'rb' => esc_html__('Bottom Right', 'trx_addons'),
            'outside' => esc_html__('Outside', 'trx_addons')
        ));
    }
}

// Return list of the slides change effects
if ( !function_exists( 'trx_addons_get_list_sc_slider_effects' ) ) {
    function trx_addons_get_list_sc_slider_effects() {
        return apply_filters('trx_addons_filter_get_list_sc_slider_effects', array(
            'slide' => esc_html__('Slide', 'trx_addons'),
            'fade' => esc_html__('Fade', 'trx_addons'),
            'cube' => esc_html__('Cube', 'trx_addons'),
            //'flip' => esc_html__('Flip', 'trx_addons'),
            'coverflow' => esc_html__('Coverflow', 'trx_addons')
        ));
    }
}

// Return list of the slides change effects
if ( !function_exists( 'trx_addons_get_list_sc_slider_directions' ) ) {
    function trx_addons_get_list_sc_slider_directions() {
        return apply_filters('trx_addons_filter_get_list_sc_slider_directions', trx_addons_get_list_sc_directions());
    }
}

// Return list of the directions
if ( !function_exists( 'trx_addons_get_list_sc_directions' ) ) {
    function trx_addons_get_list_sc_directions() {
        return apply_filters('trx_addons_filter_get_list_sc_directions', array(
            'horizontal' => esc_html__('Horizontal', 'trx_addons'),
            'vertical' => esc_html__('Vertical', 'trx_addons')
        ));
    }
}

// Return list of the slider controls positions
if ( !function_exists( 'trx_addons_get_list_sc_slider_controls' ) ) {
    function trx_addons_get_list_sc_slider_controls($none_key = 'none') {
        $list = array(
            'side'		=> esc_html__('Side', 'trx_addons'),
            'outside'	=> esc_html__('Outside', 'trx_addons'),
            'top'		=> esc_html__('Top', 'trx_addons'),
            'bottom'	=> esc_html__('Bottom', 'trx_addons')
        );
        if (!empty($none_key))
            $list = array_merge(array($none_key => esc_html__('None', 'trx_addons')), $list);
        return apply_filters('trx_addons_filter_get_list_sc_slider_controls', $list);
    }
}

// Return list of the slider pagination positions
if ( !function_exists( 'trx_addons_get_list_sc_slider_paginations' ) ) {
    function trx_addons_get_list_sc_slider_paginations($none_key = 'none', $bottom_outside = false) {
        $list = array(
            'left'		=> esc_html__('Left', 'trx_addons'),
            'right'		=> esc_html__('Right', 'trx_addons'),
            'bottom'	=> esc_html__('Bottom', 'trx_addons')
        );
        if (!empty($none_key))
            $list = array_merge(array($none_key => esc_html__('None', 'trx_addons')), $list);
        if ($bottom_outside)
            $list['bottom_outside'] = esc_html__('Bottom Outside', 'trx_addons');
        return apply_filters('trx_addons_filter_get_list_sc_slider_paginations', $list);
    }
}

// Return list of taxonomies
if ( !function_exists( 'trx_addons_get_list_taxonomies' ) ) {
    function trx_addons_get_list_taxonomies($prepend_inherit=false, $post_type='post') {
        static $list = array();
        if (empty($list[$post_type])) {
            $list[$post_type] = array();
            $taxonomies = get_object_taxonomies($post_type, 'objects');
            foreach ($taxonomies as $slug => $taxonomy)
                $list[$post_type][$slug] = $taxonomy->label;
        }
        return $prepend_inherit
            ? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list[$post_type])
            : $list[$post_type];
    }
}

// Return list of the layouts row types
if ( !function_exists( 'trx_addons_get_list_sc_layouts_row_types' ) ) {
    function trx_addons_get_list_sc_layouts_row_types() {
        return apply_filters('trx_addons_filter_get_list_sc_layouts_row_types', array(
            'inherit' => esc_html__('Inherit', 'trx_addons'),
            'narrow' => esc_html__('Narrow', 'trx_addons'),
            'compact' => esc_html__('Compact', 'trx_addons'),
            'normal' => esc_html__('Normal', 'trx_addons')
        ));
    }
}

// Return list of the icon positions in the layout items
if ( !function_exists( 'trx_addons_get_list_sc_layouts_icons_positions' ) ) {
    function trx_addons_get_list_sc_layouts_icons_positions() {
        return apply_filters('trx_addons_filter_get_list_sc_layouts_icons_positions', array(
            'left' => esc_html__('Left', 'trx_addons'),
            'right' => esc_html__('Right', 'trx_addons')
        ));
    }
}

// Return list of the orderby options for CPT shortcodes
if ( !function_exists( 'trx_addons_get_list_sc_query_orderby' ) ) {
    function trx_addons_get_list_sc_query_orderby($none_key = 'none', $keys = array('none', 'ID', 'post_date', 'title', 'rand')) {
        $list = array();
        if (!is_array($keys) && strpos($keys, ',') !== false)
            $keys = array_map('trim', explode(',', $keys));
        foreach($keys as $key) {
            if ($key == $none_key)
                $list[$key] = esc_html__('None', 'trx_addons');
            else if ($key == 'ID' || $key == 'post_id')
                $list[$key] = esc_html__('Post ID', 'trx_addons');
            else if ($key == 'date' || $key == 'post_date')
                $list[$key] = esc_html__('Date', 'trx_addons');
            else if ($key == 'title' || $key == 'post_title')
                $list[$key] = esc_html__('Title', 'trx_addons');
            else if ($key == 'price')
                $list[$key] = esc_html__('Price', 'trx_addons');
            else if ($key == 'update')
                $list[$key] = esc_html__('Update', 'trx_addons');
            else if ($key == 'rand' || $key == 'random')
                $list['rand'] = esc_html__('Random', 'trx_addons');
        }
        return apply_filters('trx_addons_filter_get_list_sc_query_orderby', $list, $keys);
    }
}

// Return list of the order options
if ( !function_exists( 'trx_addons_get_list_sc_query_orders' ) ) {
    function trx_addons_get_list_sc_query_orders() {
        return apply_filters('trx_addons_filter_get_list_sc_query_orders', array(
            'desc' => esc_html__('Descending', 'trx_addons'),
            'asc' => esc_html__('Ascending', 'trx_addons')
        ));
    }
}


// Return list of the title tags
if ( !function_exists( 'trx_addons_get_list_sc_title_tags' ) ) {
    function trx_addons_get_list_sc_title_tags($none_key = 'none', $extended = false) {
        return apply_filters('trx_addons_filter_get_list_sc_title_tags', array_merge(
            (!empty($none_key)
                ? array($none_key => esc_html__('Default', 'trx_addons'))
                : array()
            ),
            array(
                'h1' => esc_html__('Heading 1', 'trx_addons'),
                'h2' => esc_html__('Heading 2', 'trx_addons'),
                'h3' => esc_html__('Heading 3', 'trx_addons'),
                'h4' => esc_html__('Heading 4', 'trx_addons'),
                'h5' => esc_html__('Heading 5', 'trx_addons'),
                'h6' => esc_html__('Heading 6', 'trx_addons')
            ),
            ($extended
                ? array(
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                )
                : array()
            )
        ));
    }
}

// Return list of the title types
if ( !function_exists( 'trx_addons_get_list_sc_supertitle_item_types' ) ) {
    function trx_addons_get_list_sc_supertitle_item_types() {
        return apply_filters('trx_addons_filter_get_list_sc_supertitle_item_types', array(
            'text'  => __( 'Text', 'trx_addons' ),
            'media' => __( 'Media', 'trx_addons' ),
            'icon'  => __( 'Icon', 'trx_addons' ),
        ));
    }
}

// Return list of the menu layouts
if ( !function_exists( 'trx_addons_get_list_sc_layouts_menu' ) ) {
    function trx_addons_get_list_sc_layouts_menu() {
        return apply_filters('trx_addons_filter_get_list_sc_layouts_menu', array(
            'default' => esc_html__('Default', 'trx_addons'),
            'burger' => esc_html__('Burger', 'trx_addons')
        ));
    }
}

// Return list of the search layouts
if ( !function_exists( 'trx_addons_get_list_sc_layouts_search' ) ) {
    function trx_addons_get_list_sc_layouts_search() {
        return apply_filters('trx_addons_filter_get_list_sc_layouts_search', array(
            'normal' => esc_html__('Normal', 'trx_addons'),
            'expand' => esc_html__('Expand', 'trx_addons'),
            'fullscreen' => esc_html__('Fullscreen', 'trx_addons')
        ));
    }
}

// Return custom sidebars list, prepended inherit and hide sidebars item (if need)
if ( !function_exists( 'trx_addons_get_list_sidebars' ) ) {
    function trx_addons_get_list_sidebars($prepend_inherit=false, $add_hide=false) {
        static $list = false;
        if ($list === false) {
            $list = array();
            global $wp_registered_sidebars;
            if (is_array($wp_registered_sidebars)) {
                foreach ( $wp_registered_sidebars as $k => $v ) {
                    $list[$v['id']] = $v['name'];
                }
            }
            $list = apply_filters('trx_addons_filter_sidebars', $list);
        }
        if ($add_hide) $list = trx_addons_array_merge(array('hide' => esc_html__("- Select widgets -", 'trx_addons')), $list);
        return $prepend_inherit
            ? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list)
            : $list;
    }
}

// Return list of the featured elements in services
if ( !function_exists( 'trx_addons_get_list_sc_services_featured' ) ) {
    function trx_addons_get_list_sc_services_featured() {
        return apply_filters('trx_addons_filter_get_list_sc_services_featured', array(
            'image' => esc_html__('Image', 'trx_addons'),
            'icon' => esc_html__('Icon', 'trx_addons'),
            'number' => esc_html__('Number', 'trx_addons')
        ));
    }
}

// Return list of positions of the featured element in services
if ( !function_exists( 'trx_addons_get_list_sc_services_featured_positions' ) ) {
    function trx_addons_get_list_sc_services_featured_positions() {
        return apply_filters('trx_addons_filter_get_list_sc_services_featured_positions', array(
            'top' => esc_html__('Top', 'trx_addons'),
            'bottom' => esc_html__('Bottom', 'trx_addons'),
            'left' => esc_html__('Left', 'trx_addons'),
            'right' => esc_html__('Right', 'trx_addons')
        ));
    }
}

// Return list of the tabs effects in services
if ( !function_exists( 'trx_addons_get_list_sc_services_tabs_effects' ) ) {
    function trx_addons_get_list_sc_services_tabs_effects() {
        return apply_filters('trx_addons_filter_get_list_sc_services_tabs_effects', array(
            'fade' => esc_html__('Fade', 'trx_addons'),
            'slide' => esc_html__('Slide', 'trx_addons'),
            'flip' => esc_html__('Page flip', 'trx_addons')
        ));
    }
}

// Return list of the button's sizes
if ( !function_exists( 'trx_addons_get_list_sc_button_sizes' ) ) {
    function trx_addons_get_list_sc_button_sizes() {
        return apply_filters('trx_addons_filter_get_list_sc_button_sizes', array(
            'normal' => esc_html__('Normal', 'trx_addons'),
            'small' => esc_html__('Small', 'trx_addons'),
            'large' => esc_html__('Large', 'trx_addons')
        ));
    }
}

// Return list of the icon's positions
if ( !function_exists( 'trx_addons_get_list_sc_icon_positions' ) ) {
    function trx_addons_get_list_sc_icon_positions() {
        return apply_filters('trx_addons_filter_get_list_sc_icon_positions', array(
            'left' => esc_html__('Left', 'trx_addons'),
            'right' => esc_html__('Right', 'trx_addons'),
            'top' => esc_html__('Top', 'trx_addons')
        ));
    }
}

?>