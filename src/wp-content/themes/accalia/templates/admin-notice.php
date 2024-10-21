<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0.1
 */
?>
<div class="update-nag" id="accalia_admin_notice">
	<h3 class="accalia_notice_title"><?php echo sprintf(esc_html__('Welcome to %s', 'accalia'), wp_get_theme()->name); ?></h3>
	<?php
	if (!accalia_exists_trx_addons()) {
		?><p><?php echo wp_kses_data(__('<b>Attention!</b> Plugin "ThemeREX Addons is required! Please, install and activate it!', 'accalia')); ?></p><?php
	}
	?><p><?php
		if (accalia_get_value_gp('page')!='tgmpa-install-plugins') {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>" class="button-primary"><i class="dashicons dashicons-admin-plugins"></i> <?php esc_html_e('Install plugins', 'accalia'); ?></a>
			<?php
		}
		if (function_exists('accalia_exists_trx_addons') && accalia_exists_trx_addons()) {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=trx_importer'); ?>" class="button-primary"><i class="dashicons dashicons-download"></i> <?php esc_html_e('One Click Demo Data', 'accalia'); ?></a>
			<?php
		}
		?>
        <a href="<?php echo esc_url(admin_url().'customize.php'); ?>" class="button-primary"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Customizer', 'accalia'); ?></a>
        <a href="#" class="button accalia_hide_notice"><i class="dashicons dashicons-dismiss"></i> <?php esc_html_e('Hide Notice', 'accalia'); ?></a>
	</p>
</div>