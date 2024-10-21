<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0.10
 */


// Socials
if ( accalia_is_on(accalia_get_theme_option('socials_in_footer')) && ($accalia_output = accalia_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php accalia_show_layout($accalia_output); ?>
		</div>
	</div>
	<?php
}
?>