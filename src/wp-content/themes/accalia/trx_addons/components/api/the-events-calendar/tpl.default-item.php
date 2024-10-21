<?php
/**
 * The style "default" of the Events
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_events');

if ($args['slider']) {
	?><div class="swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
}

?><div  class="sc_events_item">
<?php
// Featured image
trx_addons_get_template_part('templates/tpl.featured.php',
    'trx_addons_args_featured',
    apply_filters('trx_addons_filter_args_featured', array(
        'class' => 'sc_events_item_thumb',
        'hover' => 'zoomin',
        'thumb_size' => apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('tiny'), 'events-default')
    ), 'events-default')
);
?>
<?php
	// Event's date
	$date = tribe_get_start_date(null, true, 'd F, Y');
	$time = tribe_get_start_date(null, true, 'g a');
	?>
    <div class="sc_events_item_info">
        <div class="sc_events_item_start">
		    <span class="sc_events_default_item_date"><?php echo esc_html($date); ?></span>
		    <span class="sc_events_default_item_time"><?php echo esc_html__('Starting At ', 'accalia');echo esc_html($time); ?></span>
	    </div>
        <h6 class="sc_events_default_item_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
    </div>
    <div class="sc_events_default_item_button sc_item_button"><a href="<?php the_permalink(); ?>" class="sc_button"><?php esc_html_e('Learn more', 'accalia'); ?></a></div>
</div><?php

if ($args['slider'] || $args['columns'] > 1) {
	?></div><?php
}

?>