<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WPBakery Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$accalia_content = '';
$accalia_blog_archive_mask = '%%CONTENT%%';
$accalia_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $accalia_blog_archive_mask);
if ( have_posts() ) {
	the_post(); 
	if (($accalia_content = apply_filters('the_content', get_the_content())) != '') {
		if (($accalia_pos = strpos($accalia_content, $accalia_blog_archive_mask)) !== false) {
			$accalia_content = preg_replace('/(\<p\>\s*)?'.$accalia_blog_archive_mask.'(\s*\<\/p\>)/i', $accalia_blog_archive_subst, $accalia_content);
		} else
			$accalia_content .= $accalia_blog_archive_subst;
		$accalia_content = explode($accalia_blog_archive_mask, $accalia_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) accalia_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$accalia_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$accalia_args = accalia_query_add_posts_and_cats($accalia_args, '', accalia_get_theme_option('post_type'), accalia_get_theme_option('parent_cat'));
$accalia_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($accalia_page_number > 1) {
	$accalia_args['paged'] = $accalia_page_number;
	$accalia_args['ignore_sticky_posts'] = true;
}
$accalia_ppp = accalia_get_theme_option('posts_per_page');
if ((int) $accalia_ppp != 0)
	$accalia_args['posts_per_page'] = (int) $accalia_ppp;
// Make a new query
query_posts( $accalia_args );
// Set a new query as main WP Query
$GLOBALS['wp_the_query'] = $GLOBALS['wp_query'];

// Set query vars in the new query!
if (is_array($accalia_content) && count($accalia_content) == 2) {
	set_query_var('blog_archive_start', $accalia_content[0]);
	set_query_var('blog_archive_end', $accalia_content[1]);
}

get_template_part('index');
?>