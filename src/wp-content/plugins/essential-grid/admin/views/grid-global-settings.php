<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.essential-grid.com/
 * @copyright 2024 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

$curPermission             = Essential_Grid_Admin::getPluginPermissionValue();
$output_protection         = get_option( 'tp_eg_output_protection', 'none' );
$tooltips                  = get_option( 'tp_eg_tooltips', 'true' );
$js_to_footer              = get_option( 'tp_eg_js_to_footer', 'false' );
$use_cache                 = Essential_Grid_Base::getUseCache();
$query_type                = get_option( 'tp_eg_query_type', 'wp_query' );
$enable_log                = get_option( 'tp_eg_enable_log', 'false' );
$show_stream_failure_msg   = get_option( 'tp_eg_show_stream_failure_msg', 'true' );
$stream_failure_custom_msg = get_option( 'tp_eg_stream_failure_custom_msg', '' );
$use_lightbox              = get_option( 'tp_eg_use_lightbox', 'false' );
$use_crossorigin           = get_option( 'tp_eg_use_crossorigin', 'false' );
$overview_show_grid_info   = get_option( 'tp_eg_overview_show_grid_info', 'false' );
$enable_custom_post_type   = Essential_Grid_Base::getCpt();
$enable_extended_search    = get_option( 'tp_eg_enable_extended_search', 'false' );
$enable_post_meta          = get_option( 'tp_eg_enable_post_meta', 'true' );
$no_filter_match_message   = get_option( 'tp_eg_no_filter_match_message', 'No Items for the Selected Filter' );
$global_default_img        = get_option( 'tp_eg_global_default_img', '' );
$enable_fontello           = get_option( 'tp_eg_global_enable_fontello', 'backfront' );
$enable_font_awesome       = get_option( 'tp_eg_global_enable_font_awesome', 'false' );
$enable_pe7                = get_option( 'tp_eg_global_enable_pe7', 'false' );
$enable_youtube_nocookie   = get_option( 'tp_eg_enable_youtube_nocookie', 'false' );
$exclude_post_types        = Essential_Grid_Base::getExcludePostTypes();

$metas      = new Essential_Grid_Meta();
$meta_links = new Essential_Grid_Meta_Linking();

$custom_metas = $metas->get_all_meta( false );
$link_metas   = $meta_links->get_all_link_meta();

$settings = get_option( 'esg-search-settings', [ 'settings' => [], 'global' => [], 'shortcode' => [] ] );
$settings = Essential_Grid_Base::stripslashes_deep( $settings );

$base  = new Essential_Grid_Base();
$grids = Essential_Grid_Db::get_grids_short();

$search_enable = $base->getVar( @$settings, [ 'settings', 'search-enable' ], 'off' );

$my_skins = [
	'light' => esc_attr__( 'Light', ESG_TEXTDOMAIN ),
	'dark'  => esc_attr__( 'Dark', ESG_TEXTDOMAIN )
];
$my_skins = apply_filters( 'essgrid_modify_search_skins', $my_skins );

if ( $use_lightbox != 'disabled' ) {
	update_option( 'tp_eg_use_lightbox', 'false' );
}

if ( empty( $global_default_img ) ) {
	$display_global_img = 'none';
	$global_default_src = '';
} else {
	$display_global_img = 'block';
	$global_default_src = wp_get_attachment_image_src( $global_default_img, 'large' );
	$global_default_src = ! empty( $global_default_src ) ? $global_default_src[0] : '';
}

$data = apply_filters( 'essgrid_globalSettingsDialog_data', [] );

$custom_post_types = get_post_types( [ '_builtin' => false ] );

?>
<h2 class="topheader"><?php echo esc_html(get_admin_page_title()); ?></h2>
<div id="global-settings-dialog-wrap">

	<div class="save-wrap-settings">
		<div class="sws-toolbar-button sws-toolbar-button-transform"><a class="esg-btn esg-green" href="javascript:void(0);" id="eg-btn-save-global-settings"><i class="rs-icon-save-light"></i>Save Settings</a></div>
		<div class="sws-toolbar-button"><a class="esg-btn esg-purple" href="<?php echo Essential_Grid_Base::getViewUrl(Essential_Grid_Admin::VIEW_OVERVIEW); ?>"><i class="eg-icon-cancel"></i><?php esc_html_e('Close', ESG_TEXTDOMAIN); ?></a></div>
	</div>

	<div id="eg-global-settings-menu">
		<ul>
			<li data-toshow="esg-global-settings" class="selected-esg-setting"><i class="eg-icon-cog"></i><p><?php esc_html_e('Settings', ESG_TEXTDOMAIN); ?></p></li>
			<li data-toshow="esg-custommeta-settings"><i class="eg-icon-menu"></i><p><?php esc_html_e('Meta', ESG_TEXTDOMAIN); ?></p></li>
			<li data-toshow="esg-metareferences-settings"><i class="eg-icon-shuffle"></i><p><?php esc_html_e('References', ESG_TEXTDOMAIN); ?></p></li>
			<li data-toshow="esg-globalsearch-settings"><i class="eg-icon-search"></i><p><?php esc_html_e('Global Search', ESG_TEXTDOMAIN); ?></p></li>
			<li data-toshow="esg-shortcodesearch-settings"><i class="eg-icon-search"></i><p><?php esc_html_e('Shortcode Search', ESG_TEXTDOMAIN); ?></p></li>
			<?php echo apply_filters('essgrid_global_settings_menu', ''); ?>
		</ul>
	</div>
	<div class="esg-box">

		<div id="esg-global-settings" class="esg-settings-container active-esc">
			<div>
				<!-- BASIC SETTINGS -->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Basics', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">
					<label><?php esc_html_e('View Plugin Permissions', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="plugin_permissions">
						<option value="admin" <?php selected($curPermission, Essential_Grid_Admin::ROLE_ADMIN);?>><?php esc_html_e('Admin', ESG_TEXTDOMAIN); ?></option>
						<option value="editor" <?php selected($curPermission, Essential_Grid_Admin::ROLE_EDITOR);?>><?php esc_html_e('Editor, Admin', ESG_TEXTDOMAIN); ?></option>
						<option value="author" <?php selected($curPermission, Essential_Grid_Admin::ROLE_AUTHOR);?>><?php esc_html_e('Author, Editor, Admin', ESG_TEXTDOMAIN); ?></option>
					</select>
					<div class="div13"></div>
					
					<label><?php esc_html_e('Advanced Tooltips', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="plugin_tooltips">
						<option value="true" <?php selected($tooltips, 'true');?>><?php esc_html_e('On', ESG_TEXTDOMAIN); ?></option>
						<option value="false" <?php selected($tooltips, 'false');?>><?php esc_html_e('Off', ESG_TEXTDOMAIN); ?></option>
					</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('Show or Hide the Tooltips on Hover over the Settings in Essential Grid Backend. ', ESG_TEXTDOMAIN); ?></span>
					<div class="div13"></div>

					<label><?php esc_html_e('Page/Post Options', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="enable_post_meta">
						<option value="true" <?php selected($enable_post_meta, 'true');?>><?php esc_html_e('On', ESG_TEXTDOMAIN); ?></option>
						<option value="false" <?php selected($enable_post_meta, 'false');?>><?php esc_html_e('Off', ESG_TEXTDOMAIN); ?></option>
					</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('This enables the post and page meta box options beneath the WordPress content editor pages.', ESG_TEXTDOMAIN); ?></span>
					<div class="div13"></div>

					<label><?php esc_html_e('YouTube NoCookie', ESG_TEXTDOMAIN); ?></label><!--	
					--><select name="enable_youtube_nocookie">
						<option value="true" <?php selected($enable_youtube_nocookie, 'true');?>><?php esc_html_e('On', ESG_TEXTDOMAIN); ?></option>
						<option value="false" <?php selected($enable_youtube_nocookie, 'false');?>><?php esc_html_e('Off', ESG_TEXTDOMAIN); ?></option>
					</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('This enables changing all YouTube embeds to the youtube-nocookie.com url to save no cookies.', ESG_TEXTDOMAIN); ?></span>

					<div class="div13"></div>
					<label><?php esc_html_e('Lightbox', ESG_TEXTDOMAIN); ?></label><!--
						--><select name="use_lightbox">
							<option value="false" <?php selected($use_lightbox, 'false');?>><?php esc_html_e('Own LightBox', ESG_TEXTDOMAIN); ?></option>
							<option value="disabled" <?php selected($use_lightbox, 'disabled');?>><?php esc_html_e('3rd Party LightBox', ESG_TEXTDOMAIN); ?></option>
						</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('Only change this in case you wish to use 3rd party Lightbox.', ESG_TEXTDOMAIN); ?></span>
					
					<div class="div13"></div>
					<label><?php esc_html_e('Cross-origin', ESG_TEXTDOMAIN); ?></label><!--
						--><select name="use_crossorigin">
							<option value="false" <?php selected($use_crossorigin, 'false');?>><?php esc_html_e('Unset', ESG_TEXTDOMAIN); ?></option>
							<option value="true" <?php selected($use_crossorigin, 'true');?>><?php esc_html_e('Anonymous', ESG_TEXTDOMAIN); ?></option>
						</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('Cross-origin image defaults', ESG_TEXTDOMAIN); ?></span>
					
					<div class="div13"></div>
					<label><?php esc_html_e('Grid Info on Overview', ESG_TEXTDOMAIN); ?></label><!--
						--><select name="overview_show_grid_info">
							<option value="false" <?php selected($overview_show_grid_info, 'false');?>><?php esc_html_e('Hide', ESG_TEXTDOMAIN); ?></option>
							<option value="true" <?php selected($overview_show_grid_info, 'true');?>><?php esc_html_e('Show', ESG_TEXTDOMAIN); ?></option>
						</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('Show additional grid information ( ID / Handle ) on overview page', ESG_TEXTDOMAIN); ?></span>

				</div>
			</div>
			
			<div> <!-- FONT SETTINGS -->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Fonts & Icons', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">
					<label><?php esc_html_e('Fontello Icons', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="enable_fontello">
						<option value="backfront" <?php selected($enable_fontello, 'backfront');?>><?php esc_html_e('Backend+Frontend', ESG_TEXTDOMAIN); ?></option>
						<option value="back" <?php selected($enable_fontello, 'back');?>><?php esc_html_e('Only Backend', ESG_TEXTDOMAIN); ?></option>
					</select>
					<div class="div13"></div>
				
					<label><?php esc_html_e('Font-Awesome Icons', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="enable_font_awesome">
						<option value="false" <?php selected($enable_font_awesome, 'false');?>><?php esc_html_e('Off', ESG_TEXTDOMAIN); ?></option>
						<option value="backfront" <?php selected($enable_font_awesome, 'backfront');?>><?php esc_html_e('Backend+Frontend', ESG_TEXTDOMAIN); ?></option>
						<option value="back" <?php selected($enable_font_awesome, 'back');?>><?php esc_html_e('Only Backend', ESG_TEXTDOMAIN); ?></option>
					</select>
					<div class="div13"></div>
				
					<label><?php esc_html_e('Stroke 7 Icons', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="enable_pe7">
						<option value="false" <?php selected($enable_pe7, 'false');?>><?php esc_html_e('Off', ESG_TEXTDOMAIN); ?></option>
						<option value="backfront" <?php selected($enable_pe7, 'backfront');?>><?php esc_html_e('Backend+Frontend', ESG_TEXTDOMAIN); ?></option>
						<option value="back" <?php selected($enable_pe7, 'back');?>><?php esc_html_e('Only Backend', ESG_TEXTDOMAIN); ?></option>
					</select>
				</div>
			</div>

			<!-- OutPut Settings-->
			<div> 
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Output Settings', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">
					<label><?php esc_html_e('Use Own Caching System', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="use_cache">
						<option value="true" <?php selected($use_cache, 'true');?>><?php esc_html_e('On', ESG_TEXTDOMAIN); ?></option>
						<option value="false" <?php selected($use_cache, 'false');?>><?php esc_html_e('Off', ESG_TEXTDOMAIN); ?></option>
					</select><!--
					--><div class="space18"></div><span id="ess-grid-delete-cache" class="esg-btn esg-red"><?php esc_html_e('delete cache', ESG_TEXTDOMAIN); ?></span>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php  esc_html_e('Essential Grid has two caching engines. Primary cache will precache Post Queries to give a quicker result of queries. The internal engine will allow to cache the whole grid\'s HTML markup which will provide an extreme quick output. Cache should always be deleted after changes! Only for advanced users.', ESG_TEXTDOMAIN); ?></span>
					<div class="div13"></div>

					<label><?php esc_html_e('Output Filter Protection', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="output_protection">
						<option value="none" <?php selected($output_protection, 'none');?>><?php esc_html_e('None', ESG_TEXTDOMAIN); ?></option>
						<option value="compress" <?php selected($output_protection, 'compress');?>><?php esc_html_e('By Compressing Output', ESG_TEXTDOMAIN); ?></option>
						<option value="echo" <?php selected($output_protection, 'echo');?>><?php esc_html_e('By Echo Output', ESG_TEXTDOMAIN); ?></option>
					</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('The HTML Markup is printed in compressed form, or it is written through Echo instead of Return. In some cases Echo will move the full Grid to the top/bottom of the page ! ', ESG_TEXTDOMAIN); ?></span>
					<div class="div13"></div>

					<label><?php esc_html_e('JS To Footer', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="js_to_footer">
							<option value="true" <?php selected($js_to_footer, 'true');?>><?php esc_html_e('On', ESG_TEXTDOMAIN); ?></option>
							<option value="false" <?php selected($js_to_footer, 'false');?>><?php esc_html_e('Off', ESG_TEXTDOMAIN); ?></option>
						</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('Defines where the jQuery files should be loaded in the DOM.', ESG_TEXTDOMAIN); ?></span>
					<div class="div13"></div>
					<label><?php esc_html_e('Debug Log', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="enable_log">
						<option value="true" <?php selected($enable_log, 'true');?>><?php esc_html_e('On', ESG_TEXTDOMAIN); ?></option>
						<option value="false" <?php selected($enable_log, 'false');?>><?php esc_html_e('Off', ESG_TEXTDOMAIN); ?></option>
					</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('This enables console logs for debugging purposes.', ESG_TEXTDOMAIN); ?></span>
					
					<div class="div13"></div>
					<label><?php esc_html_e('Frontend Error Messages', ESG_TEXTDOMAIN); ?></label><!--
					--><select id="show_stream_failure_msg" name="show_stream_failure_msg">
						<option value="true" <?php selected($show_stream_failure_msg, 'true');?>><?php esc_html_e('Default', ESG_TEXTDOMAIN); ?></option>
						<option value="false" <?php selected($show_stream_failure_msg, 'false');?>><?php esc_html_e('Disabled', ESG_TEXTDOMAIN); ?></option>
						<option value="custom" <?php selected($show_stream_failure_msg, 'custom');?>><?php esc_html_e('Custom', ESG_TEXTDOMAIN); ?></option>
					</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('A custom message to display for empty Grids or for when social stream credentials fail.', ESG_TEXTDOMAIN); ?></span>
					<?php 
						$stream_error_display = $show_stream_failure_msg === 'custom' ? 'block' : 'none';
					?>
					<div id="stream_failure_custom_msg" class="esg-display-<?php echo $stream_error_display; ?>">
						<div class="div13"></div>
						<label><?php esc_html_e('Custom Error Message', ESG_TEXTDOMAIN); ?></label><!--
						--><input class="esg-w-305" type="text" name="stream_failure_custom_msg" value="<?php echo esc_attr(urldecode($stream_failure_custom_msg)); ?>">
						<div class="div5"></div>
						<label></label><span class="esgs-info"><?php esc_html_e('Optionally set a custom error message for empty Grids or when social streams fail to load. Can include HTML.', ESG_TEXTDOMAIN); ?></span>
					</div>
				</div>
			</div>			
			<div> <!-- Content Settings-->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Content', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">
					<label><?php esc_html_e('Set Query Type Used', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="query_type">
						<option value="wp_query" <?php selected($query_type, 'wp_query');?>><?php esc_html_e('WP_Query()', ESG_TEXTDOMAIN); ?></option>
						<option value="get_posts" <?php selected($query_type, 'get_posts');?>><?php esc_html_e('get_posts()', ESG_TEXTDOMAIN); ?></option>
					</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('If this is changed, caching of Essential Grid may be required to be deleted!', ESG_TEXTDOMAIN); ?></span>
					<div class="div13"></div>

					<label><?php esc_html_e('Extended Search', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="enable_extended_search">
						<option value="true" <?php selected($enable_extended_search, 'true');?>><?php esc_html_e('On', ESG_TEXTDOMAIN); ?></option>
						<option value="false" <?php selected($enable_extended_search, 'false');?>><?php esc_html_e('Off', ESG_TEXTDOMAIN); ?></option>
					</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('This enables grid search thru post categories, post tags and grid custom meta attached to post', ESG_TEXTDOMAIN); ?></span>
					<div class="div13"></div>

					<?php if (!empty($custom_post_types)) : ?>
					<label><?php esc_html_e('Exclude Post Type(s)', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="exclude_post_types" multiple size="5" data-init="<?php esc_attr_e( implode(',', $exclude_post_types) ); ?>">
						<?php 
						foreach ($custom_post_types as $cpt) {
							echo sprintf('<option value="%s">%s</option>', esc_attr($cpt), esc_html($cpt));
						}
						?>
					</select>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('List of post types to exclude from Essential Grid', ESG_TEXTDOMAIN); ?></span>
					<div class="div13"></div>
					<?php else : ?>
					<input type="hidden" name="exclude_post_types" value="<?php esc_attr_e( implode(',', $exclude_post_types) ); ?>" />
					<?php endif; ?>

					<label><?php esc_html_e('Example Custom Post Type', ESG_TEXTDOMAIN); ?></label><!--
					--><select name="enable_custom_post_type" class="esg-enable-custom-post-type">
						<option value="true" <?php selected($enable_custom_post_type, 'true');?>><?php esc_html_e('On', ESG_TEXTDOMAIN); ?></option>
						<option value="false" <?php selected($enable_custom_post_type, 'false');?>><?php esc_html_e('Off', ESG_TEXTDOMAIN); ?></option>
					</select><div class="space18"></div><!--
					--><button class="esg-display-none esg-margin-r-10 esg-btn esg-purple" id="esg-import-demo-posts">Import Full Demo Data</button>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('This enables the Ess. Grid Example Custom Post Type. Needs page reload to take action.', ESG_TEXTDOMAIN); ?></span>
					<div class="div13"></div>

					<label><?php esc_html_e('Global Default Image', ESG_TEXTDOMAIN); ?></label><!--
					--><button class="esg-btn esg-purple eg-global-add-image" data-setto="global_default_img">Choose Image</button><div class="space18"></div>
					<button class="esg-btn esg-red eg-global-image-clear" data-setto="global_default_img">Remove Image</button>
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('Set an optional default global image to avoid possible blank grid items', ESG_TEXTDOMAIN); ?></span>
					<div class="div5"></div>
					<img id="global_default_img-img" class="image-holder-wrap-div esg-display-<?php echo $display_global_img; ?>" src="<?php echo esc_url($global_default_src); ?>" alt="">
					<input type="hidden" id="global_default_img" name="global_default_img" value="<?php echo esc_attr($global_default_img); ?>">
					<div class="div13"></div>
					<label><?php esc_html_e('No Filter Match Message', ESG_TEXTDOMAIN); ?></label><!--
					--><input class="esg-w-305" type=text name="no_filter_match_message" id="no_filter_match_message" value="<?php echo esc_attr($no_filter_match_message); ?>">
					<div class="div5"></div>
					<label></label><span class="esgs-info"><?php esc_html_e('Normally filter selections would always return a result, but if you are using multiple Filter Groups with "AND" set for the Category Relation this custom message will be displayed to the user.', ESG_TEXTDOMAIN); ?></span>
				</div>
			</div>
			<?php
			do_action('essgrid_globalSettingsDialog', $data);
			?>
		</div>

		<div id="esg-custommeta-settings" class="esg-settings-container ">

			<div>
				<!-- FAQ - CUSTOM META -->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('FAQ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding eg-cs-tbc-line-height">
					<div class="metabox-title"><?php esc_html_e('Custom Meta Boxes', ESG_TEXTDOMAIN); ?></div>
					<div><?php esc_html_e('A custom meta (or write) box is incredibly simple in theory. It allows you to add a custom piece of data to a post or page in WordPress.<br>These meta boxes are available in any Posts, Custom Posts, Pages and Custom Items in Grid Editor in the Essential Grid.', ESG_TEXTDOMAIN); ?></div>
					<div><?php _e('Imagine you wish to have a Custom Link to your posts. You can create 1 Meta Box named <i>Custom Link</i>. Now this Meta Box is available in all your posts where you can add your individual value for it.  In the Skin Editor you can refer to this Metadata to show the individual content of your posts.', ESG_TEXTDOMAIN); ?></div>

					<div class="div30"></div>
					<div class="metabox-title"><?php esc_html_e('Custom Meta Fields', ESG_TEXTDOMAIN); ?></div>
					<?php _e('You can edit the Custom Meta Values in your posts, custom post and  pages within the Essential Grid section, and also in the Essential Grid Editor by clicking on the <strong>Cog Wheel Icon</strong> <span class="dashicons dashicons-admin-generic"></span> of the Item.', ESG_TEXTDOMAIN); ?>

					<div class="div30"></div>
					<div class="metabox-title"><?php esc_html_e('How to add to my Skin', ESG_TEXTDOMAIN); ?></div>
					<?php _e('<strong>Edit the Skin</strong> you selected for the Grid(s) and <strong>add or edit</strong> an existing <strong>Layer</strong>. Here you can select under the source tab the <strong>Source Type</strong> to <strong>"POST"</strong> and <strong>Element</strong> to <strong>"META"</strong>. Pick the Custom Meta Key of your choice from the Drop-Down list. ', ESG_TEXTDOMAIN); ?>
				</div>
			</div>
			
			<div class="eg-custom-meta-wrap"></div>
			
			<div>
				<!-- SETTINGS - CUSTOM META -->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Add New', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding">	
					<div class="esg-btn esg-purple" id="eg-meta-add"><?php esc_html_e('Create New Meta Key', ESG_TEXTDOMAIN); ?></div>
				</div>
			</div>
			
		</div>
		<!-- END OF ESG CUSTOM META SETTINGS -->

		<div id="esg-metareferences-settings" class="esg-settings-container">

			<div>
				<!-- FAQ - METAREFERENCES META -->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('FAQ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding eg-cs-tbc-line-height">
					<div class="metabox-title"><?php esc_html_e('What Are Meta References / Aliases ?', ESG_TEXTDOMAIN); ?></div>
					<div><?php _e('To make the selection of different <strong>existing Meta Datas of other plugins and themes</strong> easier within the Essential Grid, we created this Reference Table. <br>Define the Internal name (within Essential Grid) and the original Handle Name of the Meta Key, and all these Meta Keys are available anywhere in Essential Grid from now on.', ESG_TEXTDOMAIN); ?></div>
					<div class="div30"></div>
					<div class="metabox-title"><?php esc_html_e('Where can I edit the Meta Key References ?', ESG_TEXTDOMAIN); ?></div>
					<?php esc_html_e('You will still need to edit the Value of these Meta Keys in the old place where you edited them before. (Also applies to  WooCommerce, Event Plugins or other third party plugins)    We only reference on these values to deliver the value to the Grid.', ESG_TEXTDOMAIN); ?>
					<div class="div30"></div>
					<div class="metabox-title"><?php esc_html_e('How to add Meta Field References to my Skin?', ESG_TEXTDOMAIN); ?></div>
					<?php _e('<strong>Edit the Skin</strong> you selected for the Grid(s) and <strong>add or edit</strong> an existing <strong>Layer</strong>. Here you can select under the source tab the <strong>Source Type</strong> to <strong>"POST"</strong> and <strong>Element</strong> to <strong>"META"</strong>. Pick the Custom Meta Key of your choice from the Drop-Down list. ', ESG_TEXTDOMAIN); ?>
				</div>
			</div>
			
			<div class="eg-link-meta-wrap"></div>

			<div>
				<!-- SETTINGS - METAREFERENCES META -->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Add New', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding">	
					<div class="esg-btn esg-purple" id="eg-link-meta-add" href="javascript:void(0);"><?php esc_html_e('Add New Meta Reference', ESG_TEXTDOMAIN); ?></div>
				</div>
			</div>
			
		</div>
		<!-- END OF META REFERENCES -->

		<div id="esg-globalsearch-settings" class="esg-settings-container">

			<div>
				<!-- FAQ - GLOBAL SEARCH META -->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('FAQ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding eg-cs-tbc-line-height">
					<div class="metabox-title"><?php esc_html_e('What Are The Search Settings?', ESG_TEXTDOMAIN); ?></div>
					<div><?php esc_html_e('With this, you can let any element in your theme use Essential Grid as a Search Result page.', ESG_TEXTDOMAIN); ?></div>
					<div><?php esc_html_e('You can add more than one Setting to have more than one resulting Grid Style depending on the element that opened the search overlay', ESG_TEXTDOMAIN); ?></div>
				</div>
			</div>
			
			<div>
				<!-- SETTINGS - GLOBAL SEARCH ENABLED -->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('GlobalSearch', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">	
					<label for="search-enable"><?php esc_html_e('Enable Search Globally', ESG_TEXTDOMAIN); ?></label><!--
					--><span class="esg-display-inline-block"><input type="radio" name="search-enable" value="on" <?php checked($search_enable, 'on'); ?> /><?php esc_html_e('On', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
					--><span><input type="radio" name="search-enable" value="off" <?php checked($search_enable, 'off'); ?> /><?php esc_html_e('Off', ESG_TEXTDOMAIN); ?></span>
				</div>
			</div>

			<form id="esg-search-global-settings">
				<div class="eg-global-search-wrap"></div>
			</form>

			<div id="esg-globalsearch-settings-add" class="esg-display-none">
				<!-- SETTINGS - GLOBAL SEARCH META -->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Add Settings', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding">
					<div id="eg-btn-add-global-setting" class="esg-btn esg-purple"><?php esc_html_e('Add Global Search Setting', ESG_TEXTDOMAIN); ?></div>	
				</div>
			</div>
			
		</div>
		<!-- END OF GLOBAL SEARCH -->

		<div id="esg-shortcodesearch-settings" class="esg-settings-container ">

			<div>
				<!-- FAQ - SHORTCODE SEARCH META -->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('FAQ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding eg-cs-tbc-line-height">
					<div class="metabox-title"><?php esc_html_e('What Are The Search ShortCode Settings?', ESG_TEXTDOMAIN); ?></div>
					<?php esc_html_e('With this, you can create a ShortCode with custom HTML markup that can be used anywhere on the website to use the search functionality of Essential Grid.', ESG_TEXTDOMAIN); ?>
					<div class="div13"></div>
					<div><?php esc_html_e('- adding HTML will add the onclick event in the first found tag', ESG_TEXTDOMAIN); ?></div>
					<div><?php esc_html_e('- adding text will wrap an a tag around it that will have the onclick event', ESG_TEXTDOMAIN); ?></div>
				</div>
			</div>

			<form id="esg-search-shortcode-settings">
				<div class="eg-shortcode-search-wrap"></div>
			</form>

			<div>
				<!-- SETTINGS - SHORTCODE SEARCH META -->
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Add Settings', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding">
					<div id="eg-btn-add-shortcode-setting" class="esg-btn esg-purple"><?php esc_html_e('Add Shortcode based Search Setting', ESG_TEXTDOMAIN); ?></div>	
				</div>
			</div>
			
		</div>

		<?php echo apply_filters('essgrid_global_settings_content', ''); ?>
		
	</div>
</div>

<?php Essential_Grid_Dialogs::custom_meta_dialog(); ?>
<?php Essential_Grid_Dialogs::custom_meta_linking_dialog(); ?>
<?php echo apply_filters('essgrid_global_settings_dialogs', ''); ?>

<script type="text/html" id="tmpl-esg-custom-meta-wrap">
	<div class="custom-tbc-container">
		<!-- SETTINGS - GLOBAL SEARCH RULE -->
		<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Custom Meta', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
		<div class="eg-cs-tbc">	
			<div class="esg-meta-rule">	
				<label><?php esc_html_e('Handle', ESG_TEXTDOMAIN); ?></label><input class="esg-meta-handle-input" type="text" name="esg-meta-handle[]" value="{{ data.handle }}" />
				<div class="div13"></div>
				<label><?php esc_html_e('Name', ESG_TEXTDOMAIN); ?></label><input class="esg-meta-name-input" type="text" name="esg-meta-name[]" value="{{ data.name }}">
				<div class="div13"></div>
				<label><?php esc_html_e('Type', ESG_TEXTDOMAIN); ?></label><select class="esg-meta-type-select" name="esg-meta-type[]">
					<option value="text" <# if ("text" == data.type) { #>selected="selected"<# } #>><?php esc_attr_e('Text', ESG_TEXTDOMAIN); ?></option>
					<option value="multi-select" <# if ("multi-select" == data.type) { #>selected="selected"<# } #>><?php esc_attr_e('Multi Select', ESG_TEXTDOMAIN); ?></option>
					<option value="select" <# if ("select" == data.type) { #>selected="selected"<# } #>><?php esc_attr_e('Select', ESG_TEXTDOMAIN); ?></option>
					<option value="image" <# if ("image" == data.type) { #>selected="selected"<# } #>><?php esc_attr_e('Image', ESG_TEXTDOMAIN); ?></option>
				</select>
				<div class="div13"></div>
				<label><?php esc_html_e('Sort Type', ESG_TEXTDOMAIN); ?></label><select class="esg-meta-sort-type-select" name="esg-meta-sort-type[]">
					<option value="alphabetic" <# if ("alphabetic" == data['sort-type']) { #>selected="selected"<# } #>><?php esc_attr_e('Alphabetic', ESG_TEXTDOMAIN); ?></option>
					<option value="numeric" <# if ("numeric" == data['sort-type']) { #>selected="selected"<# } #>><?php esc_attr_e('Numeric', ESG_TEXTDOMAIN); ?></option>
				</select>
				<div class="div13"></div>
				<label><?php esc_html_e('Default', ESG_TEXTDOMAIN); ?></label><input class="esg-meta-default-input" type="text" name="esg-meta-default[]" value="{{ data.default }}">
				<div class="div13"></div>
				<div class="eg-custommeta-textarea-wrap esg-display-none"><label><?php esc_html_e('Comma Separated List', ESG_TEXTDOMAIN); ?></label><textarea class="eg-custommeta-textarea" name="esg-meta-select[]">{{ data['select'] }}</textarea></div>
				<div class="div13"></div>
				<div class="esg-btn esg-red eg-meta-delete" ><i class="eg-icon-trash"></i><?php esc_html_e('Remove', ESG_TEXTDOMAIN); ?></div>
			</div>
		</div>
	</div>
</script>

<script type="text/html" id="tmpl-esg-link-meta-wrap">
	<div class="custom-tbc-container">
		<!-- SETTINGS - GLOBAL SEARCH RULE -->
		<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Custom Meta', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
		<div class="eg-cs-tbc">	
			<div class="esg-meta-rule">
				<label><?php esc_html_e('Handle', ESG_TEXTDOMAIN); ?></label><input type="text" class="esg-link-meta-handle-input" name="esg-link-meta-handle[]" value="{{ data.handle }}" />
				<div class="div13"></div>
				<label><?php esc_html_e('Name', ESG_TEXTDOMAIN); ?></label><input type="text" class="esg-link-meta-name-input" name="esg-link-meta-name[]" value="{{ data.name }}">
				<div class="div13"></div>
				<label><?php esc_html_e('Original Handle', ESG_TEXTDOMAIN); ?></label><input class="esg-link-meta-original-input" type="text" name="esg-link-meta-original[]" value="{{ data.original }}">
				<div class="div13"></div>
				<label><?php esc_html_e('Sort Type', ESG_TEXTDOMAIN); ?></label><select class="esg-link-meta-sort-type-select" name="esg-link-meta-sort-type[]">
					<option value="alphabetic" <# if ("alphabetic" == data['sort-type']) { #>selected="selected"<# } #>><?php esc_attr_e('Alphabetic', ESG_TEXTDOMAIN); ?></option>
					<option value="numeric" <# if ("numeric" == data['sort-type']) { #>selected="selected"<# } #>><?php esc_attr_e('Numeric', ESG_TEXTDOMAIN); ?></option>
				</select>
				<div class="div13"></div>
				<div class="esg-btn esg-red eg-link-meta-delete" ><i class="eg-icon-trash"></i><?php esc_html_e('Remove', ESG_TEXTDOMAIN); ?></div>
			</div>
		</div>
	</div>
</script>

<script type="text/html" id="tmpl-esg-global-settings-wrap">
	<div class="custom-tbc-container">
		<!-- SETTINGS - GLOBAL SEARCH RULE -->
		<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Search Rule', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
		<div class="eg-cs-tbc" >
			<div class="esg-search-rule">
				<label for="search-class"><?php esc_html_e('Set by Class/ID', ESG_TEXTDOMAIN); ?></label><!--
				--><input type="text" name="search-class[]" class="eg-tooltip-wrap" title="<?php esc_attr_e('Add CSS ID or Class here to trigger search as an onclick event on given elements (can be combined like \'.search, .search2, #search\')', ESG_TEXTDOMAIN); ?>" value="{{ data['search-class'] }}"  />

				<div class="div13"></div>
				<label for="search-grid-id"><?php esc_html_e('Choose Grid To Use', ESG_TEXTDOMAIN); ?></label><!--
				--><select name="search-grid-id[]">
					<?php
					if(!empty($grids)){
						foreach($grids as $id => $name){
							echo '<option value="'.esc_attr($id).'" <# if ( \''.esc_attr($id).'\' == data[\'search-grid-id\'] ) { #>selected="selected"<# } #>>'.esc_html($name).'</option>'."\n";
						}
					}
					?>
				</select>
				<div class="div13"></div>
				<label for="search-style"><?php esc_html_e('Overlay Skin', ESG_TEXTDOMAIN); ?></label><!--
				--><select name="search-style[]">
					<?php
					foreach($my_skins as $handle => $name){
						echo '<option value="'.esc_attr($handle).'" <# if ( \''.esc_attr($handle).'\' == data[\'search-style\'] ) { #>selected="selected"<# } #>>'.esc_html($name).'</option>'."\n";
					}
					?>
				</select>
				<div class="div13"></div>
				<?php add_action('essgrid_add_search_global_settings', (object)$settings); ?>
				<div class="div13"></div>
				<div class="esg-btn esg-red eg-btn-remove-setting"><i class="eg-icon-trash"></i><?php esc_html_e('Remove', ESG_TEXTDOMAIN); ?></div>
			</div>	
		</div>
	</div>
</script>

<script type="text/html" id="tmpl-esg-shortcode-settings-wrap">
	<div class="custom-tbc-container">
		<!-- SETTINGS - GLOBAL SEARCH RULE -->
		<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Search Rule', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
		<div class="eg-cs-tbc" >
			<div class="esg-search-rule">
				<label for="sc-handle"><?php esc_html_e('Handle', ESG_TEXTDOMAIN); ?></label><input type="text" value="{{ data['sc-handle'] }}" name="sc-handle[]" />
				<div class="div13"></div>
				<label for="sc-grid-id"><?php esc_html_e('Choose Grid To Use', ESG_TEXTDOMAIN); ?></label><select name="sc-grid-id[]">
							<?php
							if(!empty($grids)){
								foreach($grids as $id => $name){
									echo '<option value="'.esc_attr($id).'" <# if ( \''.esc_attr($id).'\' == data[\'sc-grid-id\'] ) { #>selected="selected"<# } #>>'.esc_html($name).'</option>'."\n";
								}
							}
							?>
				</select>
				<div class="div13"></div>
				<label for="sc-style"><?php esc_html_e('Overlay Skin', ESG_TEXTDOMAIN); ?></label><select name="sc-style[]">
					<?php
					foreach($my_skins as $handle => $name){
						echo '<option value="'.esc_attr($handle).'" <# if ( \''.esc_attr($handle).'\' == data[\'sc-style\'] ) { #>selected="selected"<# } #>>'.esc_html($name).'</option>'."\n";
					}
					?>
				</select>
				<div class="div13"></div>
				<label for="sc-html"><?php esc_html_e('HTML Markup', ESG_TEXTDOMAIN); ?></label><textarea class="esg-w-400" name="sc-html[]">{{ data['sc-html'] }}</textarea>
				<div class="div5"></div>
				<span class="esgs-info">HTML Input field to be used for the search. Could also be a simple button or another html element.</span>
				<div class="div13"></div>
				<label for="sc-shortcode"><?php esc_html_e('Generated ShortCode', ESG_TEXTDOMAIN); ?></label><input type="text" value="" name="sc-shortcode[]" readonly="readonly" class="esg-w-400" />
				<?php add_action('essgrid_add_search_shortcode_settings', (object)$settings); ?>
				<div class="div13"></div>
				<div class="esg-btn  esg-red eg-btn-remove-setting"><i class="eg-icon-trash"></i><?php esc_html_e('Remove', ESG_TEXTDOMAIN); ?></div>
			</div>
		</div>
	</div>
</script>

<script type="text/javascript">
	window.ESG ??={};
	ESG.F ??= {};
	ESG.E ??= {};
	ESG.V ??= {};
	ESG.S ??= {};
	ESG.C ??= {};
	ESG.LIB = ESG.LIB===undefined ? { nav_skins:[], item_skins:{}, nav_originals:{}} : ESG.LIB;
	ESG.CM = ESG.CM===undefined ? {apiJS:null, ajaxCSS:null, navCSS:null} : ESG.CM;
	ESG.WIN ??=jQuery(window);
	ESG.DOC ??=jQuery(document);
	
	ESG.E.SearchSettings = <?php echo wp_json_encode($settings); ?>;
	ESG.E.CustomMetas = <?php echo wp_json_encode($custom_metas); ?>;
	ESG.E.LinkMetas = <?php echo wp_json_encode($link_metas); ?>;

	ESG.E.waitTptFunc ??= [];
	ESG.E.waitTptFunc.push(function(){
		jQuery(function(){
			jQuery('.mce-notification-error').remove();
			jQuery('#wpbody-content >.notice').remove();

			jQuery('#eg-global-settings-menu ul').esgScrollTabs();
			AdminEssentials.initGlobalSettings();
			AdminEssentials.initSearchSettings();
			AdminEssentials.initCustomMeta();
		});
	});
</script>
