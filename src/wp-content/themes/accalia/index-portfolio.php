<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

accalia_storage_set('blog_archive', true);

// Load scripts for both 'Gallery' and 'Portfolio' layouts!
wp_enqueue_script( 'imagesloaded' );
wp_enqueue_script( 'masonry' );
wp_enqueue_script( 'classie', accalia_get_file_url('js/theme.gallery/classie.min.js'), array(), null, true );
wp_enqueue_script( 'accalia-gallery-script', accalia_get_file_url('js/theme.gallery/theme.gallery.js'), array(), null, true );

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	$accalia_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$accalia_sticky_out = accalia_get_theme_option('sticky_style')=='columns' 
							&& is_array($accalia_stickies) && count($accalia_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$accalia_cat = accalia_get_theme_option('parent_cat');
	$accalia_post_type = accalia_get_theme_option('post_type');
	$accalia_taxonomy = accalia_get_post_type_taxonomy($accalia_post_type);
	$accalia_show_filters = accalia_get_theme_option('show_filters');
	$accalia_tabs = array();
	if (!accalia_is_off($accalia_show_filters)) {
		$accalia_args = array(
			'type'			=> $accalia_post_type,
			'child_of'		=> $accalia_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $accalia_taxonomy,
			'pad_counts'	=> false
		);
		$accalia_portfolio_list = get_terms($accalia_args);
		if (is_array($accalia_portfolio_list) && count($accalia_portfolio_list) > 0) {
			$accalia_tabs[$accalia_cat] = esc_html__('All', 'accalia');
			foreach ($accalia_portfolio_list as $accalia_term) {
				if (isset($accalia_term->term_id)) $accalia_tabs[$accalia_term->term_id] = $accalia_term->name;
			}
		}
	}
	if (count($accalia_tabs) > 0) {
		$accalia_portfolio_filters_ajax = true;
		$accalia_portfolio_filters_active = $accalia_cat;
		$accalia_portfolio_filters_id = 'portfolio_filters';
		if (!is_customize_preview())
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
		?>
		<div class="portfolio_filters accalia_tabs accalia_tabs_ajax">
			<ul class="portfolio_titles accalia_tabs_titles">
				<?php
				foreach ($accalia_tabs as $accalia_id=>$accalia_title) {
					?><li><a href="<?php echo esc_url(accalia_get_hash_link(sprintf('#%s_%s_content', $accalia_portfolio_filters_id, $accalia_id))); ?>" data-tab="<?php echo esc_attr($accalia_id); ?>"><?php echo esc_html($accalia_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$accalia_ppp = accalia_get_theme_option('posts_per_page');
			if (accalia_is_inherit($accalia_ppp)) $accalia_ppp = '';
			foreach ($accalia_tabs as $accalia_id=>$accalia_title) {
				$accalia_portfolio_need_content = $accalia_id==$accalia_portfolio_filters_active || !$accalia_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $accalia_portfolio_filters_id, $accalia_id)); ?>"
					class="portfolio_content accalia_tabs_content"
					data-blog-template="<?php echo esc_attr(accalia_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(accalia_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($accalia_ppp); ?>"
					data-post-type="<?php echo esc_attr($accalia_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($accalia_taxonomy); ?>"
					data-cat="<?php echo esc_attr($accalia_id); ?>"
					data-parent-cat="<?php echo esc_attr($accalia_cat); ?>"
					data-need-content="<?php echo (false===$accalia_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($accalia_portfolio_need_content) 
						accalia_show_portfolio_posts(array(
							'cat' => $accalia_id,
							'parent_cat' => $accalia_cat,
							'taxonomy' => $accalia_taxonomy,
							'post_type' => $accalia_post_type,
							'page' => 1,
							'sticky' => $accalia_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		accalia_show_portfolio_posts(array(
			'cat' => $accalia_cat,
			'parent_cat' => $accalia_cat,
			'taxonomy' => $accalia_taxonomy,
			'post_type' => $accalia_post_type,
			'page' => 1,
			'sticky' => $accalia_sticky_out
			)
		);
	}

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>