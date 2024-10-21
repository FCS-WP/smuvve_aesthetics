<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0.10
 */

// Logo
if (accalia_is_on(accalia_get_theme_option('logo_in_footer'))) {
	$accalia_logo_image = '';
	if (accalia_get_retina_multiplier(2) > 1)
		$accalia_logo_image = accalia_get_theme_option( 'logo_footer_retina' );
	if (empty($accalia_logo_image)) 
		$accalia_logo_image = accalia_get_theme_option( 'logo_footer' );
	$accalia_logo_text   = get_bloginfo( 'name' );
	if (!empty($accalia_logo_image) || !empty($accalia_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($accalia_logo_image)) {
					$accalia_attr = accalia_getimagesize($accalia_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($accalia_logo_image).'" class="logo_footer_image" '.(!empty($accalia_attr[3]) ? sprintf(' %s', $accalia_attr[3]) : '').'></a>' ;
				} else if (!empty($accalia_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($accalia_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>