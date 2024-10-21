<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												. ' itemscope'
												); ?>
		itemscope itemtype="http://schema.org/<?php echo esc_attr(is_single() ? 'BlogPosting' : 'Article'); ?>">
	<?php
	do_action('accalia_action_before_post_data'); 

	// Structured data snippets
	if (accalia_is_on(accalia_get_theme_option('seo_snippets'))) {
		?>
		<div class="structured_data_snippets">
			<meta itemprop="headline" content="<?php the_title_attribute(); ?>">
			<meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
			<meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('Y-m-d')); ?>">
			<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php echo esc_url(get_the_permalink()); ?>" content="<?php the_title_attribute(); ?>"/>	
			<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
					<?php 
					$accalia_logo_image = accalia_get_retina_multiplier(2) > 1 
										? accalia_get_theme_option( 'logo_retina' )
										: accalia_get_theme_option( 'logo' );
					if (!empty($accalia_logo_image)) {
						$accalia_attr = accalia_getimagesize($accalia_logo_image);
						?>
						<img itemprop="url" src="<?php echo esc_url($accalia_logo_image); ?>">
						<meta itemprop="width" content="<?php echo esc_attr($accalia_attr[0]); ?>">
						<meta itemprop="height" content="<?php echo esc_attr($accalia_attr[1]); ?>">
						<?php
					}
					?>
				</div>
				<meta itemprop="name" content="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
				<meta itemprop="telephone" content="">
				<meta itemprop="address" content="">
			</div>
		</div>
		<?php
	}

	do_action('accalia_action_before_post_featured'); 
	
	// Featured image
	if ( !accalia_sc_layouts_showed('featured') && strpos(get_the_content(), '[trx_widget_banner]')===false) {
        if (get_post_type()=='post' && has_post_thumbnail()) {
            accalia_show_layout('<div class="single_post_featured_container">');
            accalia_show_layout('<span class="post_info_item post_categories">'.get_the_category_list(' ').'</span>');
        }
        accalia_show_post_featured(array(
            'post_info' => ((get_post_type()=='post') ? '<span class="post_info_item post_categories">'.get_the_category_list(' ').'</span>' : '')

        ));
        if (get_post_type()=='post' && has_post_thumbnail()) {
            accalia_show_layout('</div>');
        }
    }


	// Title and post meta
	if ( (!accalia_sc_layouts_showed('title') || !accalia_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		do_action('accalia_action_before_post_title'); 
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if (!accalia_sc_layouts_showed('title')) {
				the_title( '<h3 class="post_title entry-title"'.(accalia_is_on(accalia_get_theme_option('seo_snippets')) ? ' itemprop="headline"' : '').'>', '</h3>' );
			}
			// Post meta
			if (!accalia_sc_layouts_showed('postmeta')) {
				accalia_show_post_meta(apply_filters('accalia_filter_post_meta_args', array(
					'components' => 'categories,date,author,counters',
					'counters' => 'comments,likes',
					'seo' => accalia_is_on(accalia_get_theme_option('seo_snippets'))
					), 'single', 1)
				);
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	do_action('accalia_action_before_post_content'); 

	// Post content
	?>
	<div class="post_content entry-content" itemprop="articleBody">
		<?php
		the_content( );

		do_action('accalia_action_before_post_pagination'); 

		wp_link_pages( array(
			'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'accalia' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'accalia' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );

		// Taxonomies and share
		if ( is_single() && !is_attachment() ) {

			do_action('accalia_action_before_post_meta'); 

			?><div class="post_meta post_meta_single<?php if (accalia_get_theme_option('hide_meta')==1 ) { echo ' hide'; }?>"><?php
				
				// Post taxonomies
				the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">'.esc_html__('Tags:', 'accalia').'</span> ', ', ', '</span>' );

				// Share
				accalia_show_share_links(array(
						'type' => 'block',
						'caption' => esc_attr__('Share:', 'accalia'),
						'before' => '<span class="post_meta_item post_share">',
						'after' => '</span>'
					));
			?></div><?php

			do_action('accalia_action_after_post_meta'); 
		}
		?>
	</div><!-- .entry-content -->
	

	<?php
	do_action('accalia_action_after_post_content'); 

	// Author bio.
	if ( accalia_get_theme_option('author_info')==1 && is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {
		do_action('accalia_action_before_post_author'); 
		get_template_part( 'templates/author-bio' );
		do_action('accalia_action_after_post_author'); 
	}

	do_action('accalia_action_after_post_data'); 
	?>
</article>
