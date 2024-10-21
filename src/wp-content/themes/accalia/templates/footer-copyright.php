<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage ACCALIA
 * @since ACCALIA 1.0.10
 */

// Copyright area
$accalia_footer_scheme =  accalia_is_inherit(accalia_get_theme_option('footer_scheme')) ? accalia_get_theme_option('color_scheme') : accalia_get_theme_option('footer_scheme');
$accalia_copyright_scheme = accalia_is_inherit(accalia_get_theme_option('copyright_scheme')) ? $accalia_footer_scheme : accalia_get_theme_option('copyright_scheme');
?> 
<div class="footer_copyright_wrap scheme_<?php echo esc_attr($accalia_copyright_scheme); ?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and [[...]] on the <i>...</i> and <b>...</b>
				$accalia_copyright = accalia_prepare_macros(accalia_get_theme_option('copyright'));
				if (!empty($accalia_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $accalia_copyright, $accalia_matches)) {
						$accalia_copyright = str_replace($accalia_matches[1], date(str_replace(array('{', '}'), '', $accalia_matches[1])), $accalia_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($accalia_copyright));
				}
			?></div>
		</div>
	</div>
</div>
