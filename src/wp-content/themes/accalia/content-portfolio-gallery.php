<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

$accalia_blog_style = explode('_', accalia_get_theme_option('blog_style'));
$accalia_columns = empty($accalia_blog_style[1]) ? 2 : max(2, $accalia_blog_style[1]);
$accalia_post_format = get_post_format();
$accalia_post_format = empty($accalia_post_format) ? 'standard' : str_replace('post-format-', '', $accalia_post_format);
$accalia_animation = accalia_get_theme_option('blog_animation');
$accalia_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($accalia_columns).' post_format_'.esc_attr($accalia_post_format) ); ?>
	<?php echo (!accalia_is_off($accalia_animation) ? ' data-animation="'.esc_attr(accalia_get_animation_classes($accalia_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($accalia_image[1]) && !empty($accalia_image[2])) echo intval($accalia_image[1]) .'x' . intval($accalia_image[2]); ?>"
	data-src="<?php if (!empty($accalia_image[0])) echo esc_url($accalia_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$accalia_image_hover = 'icon';
	if (in_array($accalia_image_hover, array('icons', 'zoom'))) $accalia_image_hover = 'dots';
	$accalia_components = accalia_is_inherit(accalia_get_theme_option_from_meta('meta_parts')) 
								? 'categories,date,counters,share'
								: accalia_array_get_keys_by_value(accalia_get_theme_option('meta_parts'));
	$accalia_counters = accalia_is_inherit(accalia_get_theme_option_from_meta('counters')) 
								? 'comments'
								: accalia_array_get_keys_by_value(accalia_get_theme_option('counters'));
	accalia_show_post_featured(array(
		'hover' => $accalia_image_hover,
		'thumb_size' => accalia_get_thumb_size( strpos(accalia_get_theme_option('body_style'), 'full')!==false || $accalia_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($accalia_components)
										? accalia_show_post_meta(apply_filters('accalia_filter_post_meta_args', array(
											'components' => $accalia_components,
											'counters' => $accalia_counters,
											'seo' => false,
											'echo' => false
											), $accalia_blog_style[0], $accalia_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'accalia') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>