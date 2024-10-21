<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0.14
 */
$accalia_header_video = accalia_get_header_video();
$accalia_embed_video = '';
if (!empty($accalia_header_video) && !accalia_is_from_uploads($accalia_header_video)) {
	if (accalia_is_youtube_url($accalia_header_video) && preg_match('/[=\/]([^=\/]*)$/', $accalia_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$accalia_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($accalia_header_video) . '[/embed]' ));
			$accalia_embed_video = accalia_make_video_autoplay($accalia_embed_video);
		} else {
			$accalia_header_video = str_replace('/watch?v=', '/embed/', $accalia_header_video);
			$accalia_header_video = accalia_add_to_url($accalia_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$accalia_embed_video = '<iframe src="' . esc_url($accalia_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php accalia_show_layout($accalia_embed_video); ?></div><?php
	}
}
?>