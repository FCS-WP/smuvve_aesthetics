<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0
 */
?>

<div class="author_info author vcard" itemprop="author" itemscope itemtype="http://schema.org/Person">

	<div class="author_avatar" itemprop="image">
		<?php 
		$accalia_mult = accalia_get_retina_multiplier();
		echo get_avatar( get_the_author_meta( 'user_email' ), 120*$accalia_mult ); 
		?>
	</div><!-- .author_avatar -->

	<div class="author_description">
        <div class="author_title_about"><?php echo esc_html__( 'About Author', 'accalia' ); ?></div>
        <h5 class="author_title" itemprop="name"><?php echo wp_kses_data(get_the_author()); ?></h5>

		<div class="author_bio" itemprop="description">
			<?php echo wp_kses_post(wpautop(get_the_author_meta( 'description' ))); ?>
			<?php do_action('accalia_action_user_meta'); ?>
		</div><!-- .author_bio -->

	</div><!-- .author_description -->

</div><!-- .author_info -->
