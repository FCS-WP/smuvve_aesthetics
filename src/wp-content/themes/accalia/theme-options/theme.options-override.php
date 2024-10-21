<?php
/**
 * Theme Options and override-options support
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0.29
 */


// -----------------------------------------------------------------
// -- Override-options
// -----------------------------------------------------------------

if ( !function_exists('accalia_init_override') ) {
	add_action( 'after_setup_theme', 'accalia_init_override' );
	function accalia_init_override() {
		if ( is_admin() ) {
			add_action('admin_enqueue_scripts',	'accalia_add_override_scripts');
			add_action('save_post',				'accalia_save_override');
			add_filter('accalia_filter_override_options',		'accalia_add_override');
		}
	}
}

// Load required styles and scripts for admin mode
if ( !function_exists( 'accalia_add_override_scripts' ) ) {
	function accalia_add_override_scripts() {
		// If current screen is 'Edit Page' - load font icons
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && accalia_allow_override(!empty($screen->post_type) ? $screen->post_type : $screen->id)) {
			wp_enqueue_style( 'fontello-icons',  accalia_get_file_url('css/font-icons/css/fontello-embedded.css') );
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'jquery-ui-accordion', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'accalia-options', accalia_get_file_url('theme-options/theme.options.js'), array('jquery'), null, true );
			wp_localize_script( 'accalia-options', 'accalia_dependencies', accalia_get_theme_dependencies() );
		}
	}
}


// Check if override options is allow
if (!function_exists('accalia_allow_override')) {
	function accalia_allow_override($post_type) {
		return apply_filters('accalia_filter_allow_override', in_array($post_type, array('page', 'post')), $post_type);
	}
}

// Add override options
if (!function_exists('accalia_add_override')) {
	function accalia_add_override($list) {
		global $post_type;
		if (accalia_allow_override($post_type)) {
			$list[] = array(sprintf('accalia_override_options_%s', $post_type),
				esc_html__('Theme Options', 'accalia'),
				'accalia_show_override',
				$post_type,
				$post_type=='post' ? 'side' : 'advanced',
				'default'
			);
		}
		return $list;
	}
}

// Callback function to show fields in override options
if (!function_exists('accalia_show_override')) {
	function accalia_show_override() {
		global $post, $post_type;
		if (accalia_allow_override($post_type)) {
			// Load saved options
			$meta = get_post_meta($post->ID, 'accalia_options', true);
			$tabs_titles = $tabs_content = array();
			global $ACCALIA_STORAGE;
			// Refresh linked data if this field is controller for the another (linked) field
			// Do this before show fields to refresh data in the $ACCALIA_STORAGE
			foreach ($ACCALIA_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
				if (!empty($v['linked'])) {
					$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
					if (!empty($v['val']) && !accalia_is_inherit($v['val']))
						accalia_refresh_linked_data($v['val'], $v['linked']);
				}
			}
			// Show fields
			foreach ($ACCALIA_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
				if (empty($v['override']['section']))
					$v['override']['section'] = esc_html__('General', 'accalia');
				if (!isset($tabs_titles[$v['override']['section']])) {
					$tabs_titles[$v['override']['section']] = $v['override']['section'];
					$tabs_content[$v['override']['section']] = '';
				}
				$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
				$tabs_content[$v['override']['section']] .= accalia_options_show_field($k, $v, $post_type);
			}
			if (count($tabs_titles) > 0) {
				?>
				<div class="accalia_options accalia_override">
					<input type="hidden" name="override_options_post_nonce" value="<?php echo esc_attr(wp_create_nonce(admin_url())); ?>" />
					<input type="hidden" name="override_options_post_type" value="<?php echo esc_attr($post_type); ?>" />
					<div id="accalia_options_tabs">
						<ul><?php
							$cnt = 0;
							foreach ($tabs_titles as $k=>$v) {
								$cnt++;
								?><li><a href="#accalia_options_<?php echo esc_attr($cnt); ?>"><?php echo esc_html($v); ?></a></li><?php
							}
						?></ul>
						<?php
							$cnt = 0;
							foreach ($tabs_content as $k=>$v) {
								$cnt++;
								?>
								<div id="accalia_options_<?php echo esc_attr($cnt); ?>" class="accalia_options_section">
									<?php accalia_show_layout($v); ?>
								</div>
								<?php
							}
						?>
					</div>
				</div>
				<?php
			}
		}
	}
}


// Save data from override options
if (!function_exists('accalia_save_override')) {
	function accalia_save_override($post_id) {

		// verify nonce
		if ( !wp_verify_nonce( accalia_get_value_gp('override_options_post_nonce'), admin_url() ) )
			return $post_id;

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		$post_type = isset($_POST['override_options_post_type']) ? $_POST['override_options_post_type'] : $_POST['post_type'];

		// check permissions
		$capability = 'page';
		$post_types = get_post_types( array( 'name' => $post_type), 'objects' );
		if (!empty($post_types) && is_array($post_types)) {
			foreach ($post_types  as $type) {
				$capability = $type->capability_type;
				break;
			}
		}
		if (!current_user_can('edit_'.($capability), $post_id)) {
			return $post_id;
		}

		// Save meta
		$meta = array();
		$options = accalia_storage_get('options');
		foreach ($options as $k=>$v) {
			// Skip not overriden options
			if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
			// Skip inherited options
			if (!empty($_POST['accalia_options_inherit_' . $k])) continue;
			// Get option value from POST
			$meta[$k] = isset($_POST['accalia_options_field_' . $k])
							? accalia_get_value_gp('accalia_options_field_' . $k)
							: ($v['type']=='checkbox' ? 0 : '');
		}
		update_post_meta($post_id, 'accalia_options', $meta);
		
		// Save separate meta options to search template pages
		if ($post_type=='page' && !empty($_POST['page_template']) && $_POST['page_template']=='blog.php') {
			update_post_meta($post_id, 'accalia_options_post_type', isset($meta['post_type']) ? $meta['post_type'] : 'post');
			update_post_meta($post_id, 'accalia_options_parent_cat', isset($meta['parent_cat']) ? $meta['parent_cat'] : 0);
		}
	}
}
?>