<?php
/**
 * The Portfolio template to display the content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($accalia_columns).' post_format_'.esc_attr($accalia_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!accalia_is_off($accalia_animation) ? ' data-animation="'.esc_attr(accalia_get_animation_classes($accalia_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$accalia_image_hover = accalia_get_theme_option('image_hover');
	// Featured image
	accalia_show_post_featured(array(
		'thumb_size' => accalia_get_thumb_size(strpos(accalia_get_theme_option('body_style'), 'full')!==false || $accalia_columns < 3 ? 'masonry-big' : 'masonry'),
		'show_no_image' => true,
		'class' => $accalia_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $accalia_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>