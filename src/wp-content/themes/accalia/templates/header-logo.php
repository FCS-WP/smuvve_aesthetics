<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */

$accalia_args = get_query_var('accalia_logo_args');

// Site logo
$accalia_logo_image  = accalia_get_logo_image(isset($accalia_args['type']) ? $accalia_args['type'] : '');
$accalia_logo_text   = accalia_is_on(accalia_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$accalia_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($accalia_logo_image) || !empty($accalia_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($accalia_logo_image)) {
			$accalia_attr = accalia_getimagesize($accalia_logo_image);
			echo '<img src="'.esc_url($accalia_logo_image).'" '.(!empty($accalia_attr[3]) ? sprintf(' %s', $accalia_attr[3]) : '').'>' ;
		} else {
			accalia_show_layout(accalia_prepare_macros($accalia_logo_text), '<span class="logo_text">', '</span>');
			accalia_show_layout(accalia_prepare_macros($accalia_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>