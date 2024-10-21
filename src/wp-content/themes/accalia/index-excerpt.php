<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

accalia_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	?><div class="posts_container"><?php
	
	$accalia_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$accalia_sticky_out = accalia_get_theme_option('sticky_style')=='columns' 
							&& is_array($accalia_stickies) && count($accalia_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($accalia_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($accalia_sticky_out && !is_sticky()) {
			$accalia_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $accalia_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($accalia_sticky_out) {
		$accalia_sticky_out = false;
		?></div><?php
	}
	
	?></div><?php

	accalia_show_pagination();

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>