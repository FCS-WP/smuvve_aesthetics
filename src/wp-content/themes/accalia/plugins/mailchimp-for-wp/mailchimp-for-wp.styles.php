<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('accalia_mailchimp_get_css')) {
	add_filter('accalia_filter_get_css', 'accalia_mailchimp_get_css', 10, 4);
	function accalia_mailchimp_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
.mc4wp-form .mc4wp-form-fields input[type="email"] {
    {$fonts['p_font-family']}
}
CSS;
		
			
			$rad = accalia_get_border_radius();
			$css['fonts'] .= <<<CSS

.mc4wp-form .mc4wp-form-fields input[type="email"],
.mc4wp-form .mc4wp-form-fields input[type="submit"] {
	-webkit-border-radius: {$rad};
	    -ms-border-radius: {$rad};
			border-radius: {$rad};
}

CSS;
		}

		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

.mc4wp-form button {
	background-color: {$colors['bg_color_0']};
	color: {$colors['alter_light']};
}
.mc4wp-form button:hover {
	color: {$colors['text_hover2']};
}
.mc4wp-form .mc4wp-alert {
	background-color: {$colors['text_link']};
	border-color: {$colors['text_hover']};
	color: {$colors['inverse_text']};
}
CSS;
		}

		return $css;
	}
}
?>