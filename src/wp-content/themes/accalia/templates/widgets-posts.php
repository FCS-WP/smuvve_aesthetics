<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

$accalia_post_id    = get_the_ID();
$accalia_post_date  = accalia_get_date();
$accalia_post_title = get_the_title();
$accalia_post_link  = get_permalink();
$accalia_post_author_id   = get_the_author_meta('ID');
$accalia_post_author_name = get_the_author_meta('display_name');
$accalia_post_author_url  = get_author_posts_url($accalia_post_author_id, '');

$accalia_args = get_query_var('accalia_args_widgets_posts');
$accalia_show_date = isset($accalia_args['show_date']) ? (int) $accalia_args['show_date'] : 1;
$accalia_show_image = isset($accalia_args['show_image']) ? (int) $accalia_args['show_image'] : 1;
$accalia_show_author = isset($accalia_args['show_author']) ? (int) $accalia_args['show_author'] : 1;
$accalia_show_counters = isset($accalia_args['show_counters']) ? (int) $accalia_args['show_counters'] : 1;
$accalia_show_categories = isset($accalia_args['show_categories']) ? (int) $accalia_args['show_categories'] : 1;

$accalia_output = accalia_storage_get('accalia_output_widgets_posts');

$accalia_post_counters_output = '';
if ( $accalia_show_counters ) {
	$accalia_post_counters_output = '<span class="post_info_item post_info_counters">'
								. accalia_get_post_counters('comments')
							. '</span>';
}


$accalia_output .= '<article class="post_item with_thumb">';

if ($accalia_show_image) {
	$accalia_post_thumb = get_the_post_thumbnail($accalia_post_id, accalia_get_thumb_size('tiny'), array(
		'alt' => the_title_attribute( array( 'echo' => false ) )
	));
	if ($accalia_post_thumb) $accalia_output .= '<div class="post_thumb">' . ($accalia_post_link ? '<a href="' . esc_url($accalia_post_link) . '">' : '') . ($accalia_post_thumb) . ($accalia_post_link ? '</a>' : '') . '</div>';
}

$accalia_output .= '<div class="post_content">'
			. ($accalia_show_categories 
					? '<div class="post_categories">'
						. accalia_get_post_categories()
						. $accalia_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($accalia_post_link ? '<a href="' . esc_url($accalia_post_link) . '">' : '') . ($accalia_post_title) . ($accalia_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('accalia_filter_get_post_info', 
								'<div class="post_info">'
									. ($accalia_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($accalia_post_link ? '<a href="' . esc_url($accalia_post_link) . '" class="post_info_date">' : '') 
											. esc_html($accalia_post_date) 
											. ($accalia_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($accalia_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'accalia') . ' ' 
											. ($accalia_post_link ? '<a href="' . esc_url($accalia_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($accalia_post_author_name) 
											. ($accalia_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$accalia_show_categories && $accalia_post_counters_output
										? $accalia_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
accalia_storage_set('accalia_output_widgets_posts', $accalia_output);
?>