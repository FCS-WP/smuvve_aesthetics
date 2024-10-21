<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

$accalia_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$accalia_post_format = get_post_format();
$accalia_post_format = empty($accalia_post_format) ? 'standard' : str_replace('post-format-', '', $accalia_post_format);
$accalia_animation = accalia_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($accalia_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($accalia_post_format) ); ?>
	<?php echo (!accalia_is_off($accalia_animation) ? ' data-animation="'.esc_attr(accalia_get_animation_classes($accalia_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	accalia_show_post_featured(array(
		'thumb_size' => accalia_get_thumb_size($accalia_columns==1 ? 'big' : ($accalia_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($accalia_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			accalia_show_post_meta(apply_filters('accalia_filter_post_meta_args', array(), 'sticky', $accalia_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>