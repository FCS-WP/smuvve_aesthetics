<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

$accalia_post_format = get_post_format();
$accalia_post_format = empty($accalia_post_format) ? 'standard' : str_replace('post-format-', '', $accalia_post_format);
$accalia_animation = accalia_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($accalia_post_format) ); ?>
	<?php echo (!accalia_is_off($accalia_animation) ? ' data-animation="'.esc_attr(accalia_get_animation_classes($accalia_animation)).'"' : ''); ?>
	><?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_excerpt_label_sticky"><?php esc_html_e('Sticky Post','accalia'); ?></span><?php
	}

    // Title
    if (get_the_title() != '') {
        ?>
        <div class="post_header entry-header">
            <?php
            do_action('accalia_action_before_post_title');

            // Post title
            the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
            ?>
        </div><!-- .post_header --><?php
    }

    if (get_post_type()=='post'&&$accalia_post_format=='audio'&&!has_post_thumbnail()) {
        accalia_show_layout('<span class="post_info_item post_categories">'.get_the_category_list(' ').'</span>');
    }

	// Featured image
	accalia_show_post_featured(array(
	        'thumb_size' => accalia_get_thumb_size( strpos(accalia_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ),
            'post_info' => ((get_post_type()=='post'&&has_post_thumbnail()&&($accalia_post_format=='standard'||$accalia_post_format=='video'||$accalia_post_format=='gallery')) ? '<span class="post_info_item post_categories">'.get_the_category_list(' ').'</span>' : '')

    ));

	if (get_post_type()=='post'&&$accalia_post_format=='standard'&&!has_post_thumbnail()) {
	    accalia_show_layout('<span class="post_info_item post_categories">'.get_the_category_list(' ').'</span>');
    }

    do_action('accalia_action_before_post_meta');

    // Post meta
    $accalia_components = accalia_is_inherit(accalia_get_theme_option_from_meta('meta_parts'))
        ? 'date,author,counters'
        : accalia_array_get_keys_by_value(accalia_get_theme_option('meta_parts'));
    $accalia_counters = accalia_is_inherit(accalia_get_theme_option_from_meta('counters'))
        ? 'comments,likes'
        : accalia_array_get_keys_by_value(accalia_get_theme_option('counters'));

    if (!empty($accalia_components))
        accalia_show_post_meta(apply_filters('accalia_filter_post_meta_args', array(
                'components' => $accalia_components,
                'counters' => $accalia_counters,
                'seo' => false
            ), 'excerpt', 1)
        );
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (accalia_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'accalia' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'accalia' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$accalia_show_learn_more = !in_array($accalia_post_format, array('link', 'aside', 'status', 'quote'));

			// Post content area
			?><div class="post_content_inner"><?php
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
			?></div><?php
			// More button
			if ( $accalia_show_learn_more ) {
				?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('learn more', 'accalia'); ?></a></p><?php
			}

		}
	?></div><!-- .entry-content -->
</article>