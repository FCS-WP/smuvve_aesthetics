<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

$accalia_blog_style = explode('_', accalia_get_theme_option('blog_style'));
$accalia_columns = empty($accalia_blog_style[1]) ? 1 : max(1, $accalia_blog_style[1]);
$accalia_expanded = !accalia_sidebar_present() && accalia_is_on(accalia_get_theme_option('expand_content'));
$accalia_post_format = get_post_format();
$accalia_post_format = empty($accalia_post_format) ? 'standard' : str_replace('post-format-', '', $accalia_post_format);
$accalia_animation = accalia_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($accalia_columns).' post_format_'.esc_attr($accalia_post_format) ); ?>
	<?php echo (!accalia_is_off($accalia_animation) ? ' data-animation="'.esc_attr(accalia_get_animation_classes($accalia_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($accalia_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.the_title_attribute( array( 'echo' => false ) ).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	accalia_show_post_featured( array(
											'class' => $accalia_columns == 1 ? 'trx-stretch-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => accalia_get_thumb_size(
																	strpos(accalia_get_theme_option('body_style'), 'full')!==false
																		? ( $accalia_columns > 1 ? 'huge' : 'original' )
																		: (	$accalia_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('accalia_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('accalia_action_before_post_meta'); 

			// Post meta
			$accalia_components = accalia_is_inherit(accalia_get_theme_option_from_meta('meta_parts')) 
										? 'categories,date'.($accalia_columns < 3 ? ',counters' : '').($accalia_columns == 1 ? ',edit' : '')
										: accalia_array_get_keys_by_value(accalia_get_theme_option('meta_parts'));
			$accalia_counters = accalia_is_inherit(accalia_get_theme_option_from_meta('counters')) 
										? 'comments'
										: accalia_array_get_keys_by_value(accalia_get_theme_option('counters'));
			$accalia_post_meta = empty($accalia_components) 
										? '' 
										: accalia_show_post_meta(apply_filters('accalia_filter_post_meta_args', array(
												'components' => $accalia_components,
												'counters' => $accalia_counters,
												'seo' => false,
												'echo' => false
												), $accalia_blog_style[0], $accalia_columns)
											);
			accalia_show_layout($accalia_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$accalia_show_learn_more = !in_array($accalia_post_format, array('link', 'aside', 'status', 'quote'));
				if (has_excerpt()) {
					the_excerpt();
				} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
					the_content( '' );
				} else if (in_array($accalia_post_format, array('link', 'aside', 'status'))) {
					the_content();
				} else if ($accalia_post_format == 'quote') {
					if (($quote = accalia_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
						accalia_show_layout(wpautop($quote));
					else
						the_excerpt();
				} else if (substr(get_the_content(), 0, 1)!='[') {
					the_excerpt();
				}
				?>
			</div>
			<?php
			// Post meta
			if (in_array($accalia_post_format, array('link', 'aside', 'status', 'quote'))) {
				accalia_show_layout($accalia_post_meta);
			}
			// More button
			if ( $accalia_show_learn_more ) {
				?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'accalia'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>