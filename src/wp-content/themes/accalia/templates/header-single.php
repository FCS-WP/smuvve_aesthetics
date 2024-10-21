<?php
/**
 * The template to display the featured image in the single post
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

if ( get_query_var('accalia_header_image')=='' && is_singular() && has_post_thumbnail() && in_array(get_post_type(), array('post', 'page')) )  {
	$accalia_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	if (!empty($accalia_src[0])) {
		accalia_sc_layouts_showed('featured', true);
		?><div class="sc_layouts_featured with_image <?php echo esc_attr(accalia_add_inline_css_class('background-image:url('.esc_url($accalia_src[0]).');')); ?>"></div><?php
	}
}
?>