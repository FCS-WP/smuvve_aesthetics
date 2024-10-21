<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

// Page (category, tag, archive, author) title

if ( accalia_need_page_title() ) {
	accalia_sc_layouts_showed('title', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$accalia_blog_title = accalia_get_blog_title();
							$accalia_blog_title_text = $accalia_blog_title_class = $accalia_blog_title_link = $accalia_blog_title_link_text = '';
							if (is_array($accalia_blog_title)) {
								$accalia_blog_title_text = $accalia_blog_title['text'];
								$accalia_blog_title_class = !empty($accalia_blog_title['class']) ? ' '.$accalia_blog_title['class'] : '';
								$accalia_blog_title_link = !empty($accalia_blog_title['link']) ? $accalia_blog_title['link'] : '';
								$accalia_blog_title_link_text = !empty($accalia_blog_title['link_text']) ? $accalia_blog_title['link_text'] : '';
							} else
								$accalia_blog_title_text = $accalia_blog_title;
							?>
							<h1 class="sc_layouts_title_caption<?php echo esc_attr($accalia_blog_title_class); ?>"><?php
								$accalia_top_icon = accalia_get_category_icon();
								if (!empty($accalia_top_icon)) {
									$accalia_attr = accalia_getimagesize($accalia_top_icon);
									?><img src="<?php echo esc_url($accalia_top_icon); ?>"  <?php if (!empty($accalia_attr[3])) accalia_show_layout($accalia_attr[3]);?>><?php
								}
								echo wp_kses_post($accalia_blog_title_text);
							?></h1>
							<?php
							if (!empty($accalia_blog_title_link) && !empty($accalia_blog_title_link_text)) {
								?><a href="<?php echo esc_url($accalia_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($accalia_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'accalia_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>