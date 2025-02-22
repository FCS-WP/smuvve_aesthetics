<?php
/**
 * The style "default" of the Agents
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.22
 */

$args = get_query_var('trx_addons_args_sc_agents');

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
$link = get_permalink();

if ($args['slider']) {
	?><div class="swiper-slide"><?php
} else if ((int) $args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
}
?><div class="sc_team_item">
	<?php
	// Featured image
	trx_addons_get_template_part('templates/tpl.featured.php',
								'trx_addons_args_featured',
								apply_filters('trx_addons_filter_args_featured', array(
															'class' => 'sc_team_item_thumb',
															'hover' => 'zoomin',
															'thumb_size' => apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('avatar'), 'team-default')
															),
															'team-default'
												)
								);
	?><div class="sc_team_item_info">
		<div class="sc_team_item_header">
			<h4 class="sc_team_item_title"><a href="<?php echo esc_url($link); ?>"><?php the_title(); ?></a></h4>
			<div class="sc_team_item_subtitle"><?php trx_addons_show_layout($meta['position']);?></div>
		</div><?php
		if (!empty($meta['description'])) {
			?><div class="sc_team_item_content"><?php
				trx_addons_show_layout($meta['description']);
				//the_excerpt();
			?></div><?php
		}
		?><div class="sc_team_item_socials"><?php
			trx_addons_show_layout(trx_addons_get_socials_links_custom(trx_addons_properties_get_agent_socials($meta)));
		?></div>
		<div class="sc_team_item_button"><a href="<?php echo esc_url($link); ?>" class="sc_button sc_button_simple"><?php
			esc_html_e('Learn more', 'trx_addons');
		?></a></div>
	</div>
</div>
<?php
if ($args['slider'] || (int) $args['columns'] > 1) {
	?></div><?php
}
?>