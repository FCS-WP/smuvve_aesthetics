<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

						// Widgets area inside page content
						accalia_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					accalia_create_widgets_area('widgets_below_page');

					$accalia_body_style = accalia_get_theme_option('body_style');
					if ($accalia_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$accalia_footer_style = accalia_get_theme_option("footer_style");
			if (strpos($accalia_footer_style, 'footer-custom-')===0) $accalia_footer_style = 'footer-custom';
			get_template_part( "templates/{$accalia_footer_style}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (accalia_is_on(accalia_get_theme_option('debug_mode')) && accalia_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(accalia_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>