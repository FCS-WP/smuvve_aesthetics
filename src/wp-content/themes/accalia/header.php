<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js scheme_<?php
										 // Class scheme_xxx need in the <html> as context for the <body>!
										 echo esc_attr(accalia_get_theme_option('color_scheme'));
										 ?>">
<head>
	<?php wp_head(); ?>
</head>

<body <?php	body_class(); ?>>

    <?php wp_body_open(); ?>

	<?php do_action( 'accalia_action_before' ); ?>

	<div class="body_wrap">

		<div class="page_wrap">

			<?php
			// Desktop header
			$accalia_header_style = accalia_get_theme_option("header_style");
			if (strpos($accalia_header_style, 'header-custom-')===0) $accalia_header_style = 'header-custom';
			get_template_part( "templates/{$accalia_header_style}");

			// Side menu
			if (in_array(accalia_get_theme_option('menu_style'), array('left', 'right'))) {
				get_template_part( 'templates/header-navi-side' );
			}

			// Mobile header
			get_template_part( 'templates/header-mobile');
			?>

			<div class="page_content_wrap scheme_<?php echo esc_attr(accalia_get_theme_option('color_scheme')); ?>">

				<?php if (accalia_get_theme_option('body_style') != 'fullscreen') { ?>
				<div class="content_wrap">
				<?php } ?>

					<?php
					// Widgets area above page content
					accalia_create_widgets_area('widgets_above_page');
					?>				

					<div class="content">
						<?php
						// Widgets area inside page content
						accalia_create_widgets_area('widgets_above_content');
						?>				
