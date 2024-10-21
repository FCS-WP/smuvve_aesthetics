<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0.10
 */

// Footer menu
$accalia_menu_footer = accalia_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default',
                                            'depth' => 1
											));
if (!empty($accalia_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php accalia_show_layout($accalia_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>