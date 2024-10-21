<?php
if (!class_exists('VC_Extensions_ExpandSlider')) {
	class VC_Extensions_ExpandSlider {
		private $titlesize, $outtitlesize, $contentsize;
		function __construct() {
			vc_map(array(
				"name" => esc_attr__("Expand Slider", 'cq_allinone_vc'),
				"base" => "cq_vc_expandslider",
				"class" => "cq_vc_expandslider",
				"icon" => "cq_vc_expandslider",
				"category" => esc_attr__('Sike Extensions', 'cq_allinone_vc'),
				"as_parent" => array('only' => 'cq_vc_expandslider_item'),
				"js_view" => 'VcColumnView',
				"show_settings_on_create" => true,
				'description' => esc_attr__('Video or image', 'cq_allinone_vc'),
				"params" => array(
					array(
						"type" => "dropdown",
						"holder" => "",
						"edit_field_class" => "vc_col-xs-6 vc_column",
						"heading" => esc_attr__("Auto delay slideshow", "cq_allinone_vc"),
						"param_name" => "autodelay",
						"value" => array("no", "2", "3", "4", "5", "6", "7", "8"),
						"std" => "no",
						"description" => esc_attr__("In seconds, default is no, which is disabled.", "cq_allinone_vc"),
					),
					array(
						"type" => "checkbox",
						"heading" => esc_attr__("Display the arrow navigation?", "cq_allinone_vc"),
						"edit_field_class" => "vc_col-xs-6 vc_column",
						"param_name" => "isarrow",
						"std" => "yes",
						"description" => esc_attr__("", "cq_allinone_vc"),
						"value" => array(esc_attr__("Yes, show the arrows", "cq_allinone_vc") => "yes"),
					),
					array(
						"type" => "colorpicker",
						"holder" => "div",
						"class" => "",
						"edit_field_class" => "vc_col-xs-6 vc_column",
						"heading" => esc_attr__("Arrow color", 'cq_allinone_vc'),
						"param_name" => "arrowcolor",
						"value" => '',
						"description" => esc_attr__("Default is white.", 'cq_allinone_vc'),
					),
					array(
						"type" => "colorpicker",
						"holder" => "div",
						"class" => "",
						"edit_field_class" => "vc_col-xs-6 vc_column",
						"heading" => esc_attr__("Arrow hover color", 'cq_allinone_vc'),
						"param_name" => "arrowhovercolor",
						"value" => '',
						"description" => esc_attr__("Default is white.", 'cq_allinone_vc'),
					),
					array(
						"type" => "checkbox",
						"heading" => esc_attr__("Display the dot navigation?", "cq_allinone_vc"),
						"edit_field_class" => "vc_col-xs-6 vc_column",
						"param_name" => "isdot",
						"std" => "yes",
						"description" => esc_attr__("", "cq_allinone_vc"),
						"value" => array(esc_attr__("Yes, show the dots", "cq_allinone_vc") => "yes"),
					),
					array(
						"type" => "dropdown",
						"holder" => "div",
						"class" => "",
						"edit_field_class" => "vc_col-xs-6 vc_column",
						"heading" => esc_attr__("Dot pagination default color:", "cq_allinone_vc"),
						"param_name" => "dotcolor",
						"value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray"),
						"std" => "mediumgray",
						"description" => esc_attr__("", "cq_allinone_vc"),
					),
					array(
						"type" => "dropdown",
						"holder" => "div",
						"class" => "",
						"edit_field_class" => "vc_col-xs-6 vc_column",
						"heading" => esc_attr__("Dot pagination active color:", "cq_allinone_vc"),
						"param_name" => "dotactivecolor",
						"value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray"),
						"std" => "grass",
						"description" => esc_attr__("", "cq_allinone_vc"),
					),
					array(
						"type" => "textfield",
						"edit_field_class" => "vc_col-xs-6 vc_column",
						"heading" => esc_attr__("Title font size (under the thumbnail)", "cq_allinone_vc"),
						"param_name" => "outtitlesize",
						"value" => "",
						"description" => esc_attr__("Support value like 1em or 14px etc, default is 1.5em", "cq_allinone_vc"),
					),
					array(
						"type" => "textfield",
						"edit_field_class" => "vc_col-xs-6 vc_column",
						"heading" => esc_attr__("Title font size (in expand mode)", "cq_allinone_vc"),
						"param_name" => "titlesize",
						"value" => "",
						"description" => esc_attr__("Support value like 1em or 14px etc, default is 1.5em", "cq_allinone_vc"),
					),
					array(
						"type" => "textfield",
						"edit_field_class" => "vc_col-xs-6 vc_column",
						"heading" => esc_attr__("Content font size", "cq_allinone_vc"),
						"param_name" => "contentsize",
						"value" => "",
						"description" => esc_attr__("Support value like 1em or 14px etc, default is 1.2em", "cq_allinone_vc"),
					),
					array(
						"type" => "textfield",
						"edit_field_class" => "vc_col-xs-6 vc_column",
						"heading" => esc_attr__("Extra class name", "cq_allinone_vc"),
						"param_name" => "extraclass",
						"value" => "",
						"description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cq_allinone_vc"),
					),
					array(
						"type" => "css_editor",
						"heading" => esc_attr__("CSS", "cq_allinone_vc"),
						"param_name" => "css",
						"description" => esc_attr__("It's recommended to use this to customize the padding/margin only.", "cq_allinone_vc"),
						"group" => esc_attr__("Design options", "cq_allinone_vc"),
					),
				),
			));

			vc_map(
				array(
					"name" => esc_attr__("Slider Item", "cq_allinone_vc"),
					"base" => "cq_vc_expandslider_item",
					"class" => "cq_vc_expandslider_item",
					"icon" => "cq_vc_expandslider_item",
					"category" => esc_attr__('Sike Extensions', 'cq_allinone_vc'),
					"description" => esc_attr__("Add image, text and button", "cq_allinone_vc"),
					"as_child" => array('only' => 'cq_vc_expandslider'),
					"show_settings_on_create" => true,
					"content_element" => true,
					"params" => array(
						array(
							"type" => "attach_image",
							"heading" => esc_attr__("Item image:", "cq_allinone_vc"),
							"param_name" => "image",
							"value" => "",
							"description" => esc_attr__("Select from media library.", "cq_allinone_vc"),
						),
						array(
							"type" => "textfield",
							"heading" => esc_attr__("Title", "cq_allinone_vc"),
							"param_name" => "caption",
							"value" => "Default title",
							"group" => "Text",
							"description" => esc_attr__("The title under thumbnail, also display in expand mode, you can hide it below.", "cq_allinone_vc"),
						),
						array(
							"type" => "checkbox",
							"heading" => esc_attr__("Hide the title in expand mode?", "cq_allinone_vc"),
							"edit_field_class" => "vc_col-xs-6 vc_column",
							"param_name" => "hidetitle",
							"std" => "no",
							"group" => "Text",
							"description" => esc_attr__("The title is displayed by default in expand mode.", "cq_allinone_vc"),
							"value" => array(esc_attr__("Yes, hide the title", "cq_allinone_vc") => "yes"),
						),
						array(
							"type" => "colorpicker",
							"holder" => "div",
							"class" => "",
							"edit_field_class" => "vc_col-xs-6 vc_column",
							"heading" => esc_attr__("Title color", 'cq_allinone_vc'),
							"param_name" => "outtitlecolor",
							"value" => '',
							"group" => "Text",
							"description" => esc_attr__("Title under the thumbnail. Default is dark gray.", 'cq_allinone_vc'),
						),
						array(
							"type" => "colorpicker",
							"holder" => "div",
							"class" => "",
							"edit_field_class" => "vc_col-xs-6 vc_column",
							"heading" => esc_attr__("Expand mode title color", 'cq_allinone_vc'),
							"param_name" => "titlecolor",
							"value" => '',
							"group" => "Text",
							"description" => esc_attr__("The title in the expand mode. Default is dark gray.", 'cq_allinone_vc'),
						),
						array(
							"type" => "textarea_html",
							"heading" => esc_attr__("More content in expand mode", "cq_allinone_vc"),
							"param_name" => "content",
							"value" => "",
							"group" => "Text",
							"description" => esc_attr__("", "cq_allinone_vc"),
						),
						array(
							"type" => "colorpicker",
							"holder" => "div",
							"class" => "",
							"edit_field_class" => "vc_col-xs-6 vc_column",
							"heading" => esc_attr__("Content color", 'cq_allinone_vc'),
							"param_name" => "contentcolor",
							"value" => '',
							"group" => "Text",
							"description" => esc_attr__("Default is white.", 'cq_allinone_vc'),
						),
						array(
							"type" => "dropdown",
							"holder" => "div",
							"class" => "",
							"edit_field_class" => "vc_col-xs-6 vc_column",
							"heading" => esc_attr__("Content background:", "cq_allinone_vc"),
							"param_name" => "contentstyle",
							"value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray"),
							"std" => "mediumgray",
							"description" => esc_attr__("Select the background style for the text in the expand mode.", "cq_allinone_vc"),
						),
						array(
							"type" => "textfield",
							"heading" => esc_attr__("Button text (optional button in expand mode)", "cq_allinone_vc"),
							"param_name" => "buttontext",
							"value" => "",
							"group" => "Button",
							"description" => esc_attr__("Optional button under the title and description.", "cq_allinone_vc"),
						),
						array(
							"type" => "vc_link",
							"heading" => esc_attr__("link URL (can be opened as lightbox)", "cq_allinone_vc"),
							"param_name" => "thelink",
							"group" => "Button",
							"description" => esc_attr__("Support YouTube, Vimeo video, image, Google Map etc, for example, https://vimeo.com/639845104, or https://www.youtube.com/watch?v=ba2OnpjbncQ", "cq_allinone_vc"),
						),
						array(
							"type" => "attach_image",
							"heading" => esc_attr__("Lightbox image (optional, click button to open):", "cq_allinone_vc"),
							"param_name" => "lightboximage",
							"value" => "",
							"group" => "Button",
							"description" => esc_attr__("Select from media library. The link above will be ignored if added.", "cq_allinone_vc"),
						),
						array(
							"type" => "checkbox",
							"heading" => esc_attr__("Display the link as lightbox?", "cq_allinone_vc"),
							"edit_field_class" => "vc_col-xs-6 vc_column",
							"param_name" => "islightbox",
							"std" => "yes",
							"group" => "Button",
							"description" => esc_attr__("Support YouTube, Vimeo video, image, Google Map etc.", "cq_allinone_vc"),
							"value" => array(esc_attr__("Yes, apply lightbox effect", "cq_allinone_vc") => "yes"),
						),
						array(
							"type" => "dropdown",
							"edit_field_class" => "vc_col-xs-6 vc_column",
							"holder" => "",
							"heading" => esc_attr__("Button color", "cq_allinone_vc"),
							"param_name" => "buttoncolor",
							"value" => array('Blue' => 'blue', 'Turquoise' => 'turquoise', 'Pink' => 'pink', 'Violet' => 'violet', 'Peacoc' => 'peacoc', 'Chino' => 'chino', 'Vista Blue' => 'vista_blue', 'Black' => 'black', 'Grey' => 'grey', 'Orange' => 'orange', 'Sky' => 'sky', 'Green' => 'green', 'Sandy brown' => 'sandy_brown', 'Purple' => 'purple', 'White' => 'white'),
							"std" => "blue",
							"group" => "Button",
							"description" => esc_attr__("", "cq_allinone_vc"),
						),
						array(
							"type" => "dropdown",
							"edit_field_class" => "vc_col-xs-6 vc_column",
							"holder" => "",
							"heading" => esc_attr__("Button size", "cq_allinone_vc"),
							"param_name" => "buttonsize",
							"value" => array('Mini' => 'xs', 'Small' => 'sm', 'Large' => 'lg'),
							"std" => "xs",
							"group" => "Button",
							"description" => esc_attr__("", "cq_allinone_vc"),
						),
						array(
							"type" => "dropdown",
							"edit_field_class" => "vc_col-xs-6 vc_column",
							"holder" => "",
							"heading" => esc_attr__("Button shape", "cq_allinone_vc"),
							"param_name" => "buttonshape",
							"value" => array('Rounded' => 'rounded', 'Square' => 'square', 'Round' => 'round'),
							"std" => "rounded",
							"group" => "Button",
							"description" => esc_attr__("", "cq_allinone_vc"),
						),

					),
				)
			);

			add_shortcode('cq_vc_expandslider', array($this, 'cq_vc_expandslider_func'));
			add_shortcode('cq_vc_expandslider_item', array($this, 'cq_vc_expandslider_item_func'));

		}

		function cq_vc_expandslider_func($atts, $content = null) {
			$css_class = $css = $arrowcolor = $arrowhovercolor = $dotcolor = $dotactivecolor = $extraclass = '';
			$imageposition = $navposition = $titlesize = $outtitlesize = $contentsize = '';
			$this->titlesize = '';
			$this->outtitlesize = '';
			$this->contentsize = '';
			extract(shortcode_atts(array(
				"isarrow" => "yes",
				"isdot" => "yes",
				"titlesize" => "",
				"outtitlesize" => "",
				"contentsize" => "",
				"imageposition" => "top",
				"navposition" => "float-left",
				"arrowcolor" => "",
				"arrowhovercolor" => "",
				"dotcolor" => "mediumgray",
				"dotactivecolor" => "grass",
				"autodelay" => "no",
				"css" => "",
				"extraclass" => "",
			), $atts));

			$output = "";
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_expandslider', $atts);
			wp_register_style('vc-extensions-expandslider-style', plugins_url('css/style.css', __FILE__));
			wp_enqueue_style('vc-extensions-expandslider-style');

			wp_register_style('swiper', plugins_url('../cardslider/css/swiper-bundle.min.css', __FILE__));
			wp_enqueue_style('swiper');

			wp_register_script('cq-swiper', plugins_url('../cardslider/js/swiper-bundle.min.js', __FILE__), array('jquery'));
			wp_enqueue_script('cq-swiper');

			wp_register_style('lity', plugins_url('../hotspot/css/lity.min.css', __FILE__));
			wp_enqueue_style('lity');

			wp_register_script('lity', plugins_url('../hotspot/js/lity.min.js', __FILE__), array('jquery'));
			wp_enqueue_script('lity');

			wp_register_script('vc-extensions-expandslider-script', plugins_url('js/init.js', __FILE__), array("jquery", "cq-swiper"));
			wp_enqueue_script('vc-extensions-expandslider-script');

			$this->titlesize = $titlesize;
			$this->outtitlesize = $outtitlesize;
			$this->contentsize = $contentsize;

			$output .= '<div class="cq-expandslider-dot-' . $dotcolor . ' cq-expandslider-active-' . $dotactivecolor . ' cq-expandslider ' . $extraclass . ' ' . $css_class . '" data-arrowcolor="' . $arrowcolor . '" data-autodelay="' . $autodelay . '" data-arrowhovercolor="' . $arrowhovercolor . '">';

			$output .= '<div class="swiper cq-expandslider-swiper">';
			$output .= '<div class="swiper-wrapper">';

			$output .= do_shortcode($content);

			$output .= '</div>';

			if ($isarrow == "yes") {
				$output .= '<div class="swiper-button-next" style="color:' . $arrowcolor . ';"></div>';
				$output .= '<div class="swiper-button-prev" style="color:' . $arrowcolor . ';"></div>';
			}
			if ($isdot == "yes") {
				$output .= '<div class="swiper-pagination"></div>';
			}
			$output .= '</div>';

			$output .= '</div>';
			return $output;

		}

		function cq_vc_expandslider_item_func($atts, $content = null, $tag = null) {
			$output = $thelink = $videourl = $image = $imagesize = $videowidth = $islightbox = $hidetitle = $caption = $titlecolor = $outtitlecolor = $contentcolor = $contentbg = $buttoncolor = $buttontext = $buttonshape = $buttonsize = $buttonlink = $align = $css = "";
			extract(shortcode_atts(array(
				"thelink" => "",
				"islightbox" => "yes",
				"hidetitle" => "no",
				"videourl" => "",
				"image" => "",
				"lightboximage" => "",
				"imagesize" => "64",
				"iscaption" => "",
				"titlecolor" => "",
				"outtitlecolor" => "",
				"contentcolor" => "",
				"caption" => "Default title",
				"buttontext" => "",
				"buttoncolor" => "blue",
				"buttonsize" => "xs",
				"buttonshape" => "rounded",
				"buttonstyle" => "modern",
				"buttonlink" => "",
				"align" => "center",
				"contentstyle" => "mediumgray",
				"css" => "",
			), $atts));

			$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

			$thelink = vc_build_link($thelink);

			$img = $thumbnail = "";

			$fullimage = wp_get_attachment_image_src($image, 'full');
			$attachment = get_post($image);
			$thumbnail = $fullimage[0] ?? "";

			$openedimage = wp_get_attachment_image_src($lightboximage, 'full');
			$lightboxattachment = get_post($lightboximage);
			$openedimageurl = $openedimage[0] ?? "";

			$output = '';

			$lightboxurl = '';

			$is_lity = $islightbox == "yes" ? "data-lity" : "";

			$output .= '<div class="cq-expandslider-item cq-expandslider-item-' . $contentstyle . ' swiper-slide" data-image="' . $thumbnail . '">';

			$output .= '<img src="' . $thumbnail . '" alt="' . get_post_meta($image, '_wp_attachment_image_alt', true) . '" class="cq-expandslider-image" />';

			if (($caption != "" && $hidetitle != "yes") || $content != "" || $buttontext != "") {
				$output .= '<div class="cq-expandslider-desc">';

				if ($caption != "" && $hidetitle != "yes") {
					$output .= '<h4 class="cq-expandslider-title" style="color:' . $titlecolor . ';font-size:' . $this->titlesize . ';">' . esc_html($caption) . ' </h4>';
				}

				if ($content != "") {
					$output .= '<div class="cq-expandslider-caption" style="color:' . $contentcolor . ';font-size:' . $this->contentsize . ';">';
					$output .= do_shortcode($content);
					$output .= '</div>';
				}

				if ($buttontext != "") {

					$btn_link = $openedimageurl == "" ? $thelink['url'] : $openedimageurl;

					$output .= '<div class="vc_btn3-container vc_btn3-center">';
					$output .= '<a class="vc_general vc_btn3 vc_btn3-size-' . $buttonsize . ' vc_btn3-shape-' . $buttonshape . ' vc_btn3-style-' . $buttonstyle . ' vc_btn3-color-' . $buttoncolor . '" title="' . get_post_meta($lightboxattachment->ID, '_wp_attachment_image_alt', true) . '" ' . $is_lity . ' data-lity-desc="' . get_post_meta($lightboxattachment->ID, '_wp_attachment_image_alt', true) . '" href="' . $btn_link . '" target="' . $thelink["target"] . '">' . $buttontext . '</a>';
					$output .= '</div>';

				}

				$output .= '</div>';

			}

			if ($caption != "") {
				$output .= '<h4 class="cq-expandslider-outtitle" style="color:' . $outtitlecolor . ';font-size:' . $this->outtitlesize . ';">' . esc_html($caption) . ' </4>';
			}

			$output .= '</div>';

			return $output;

		}

	}
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer') && !class_exists('WPBakeryShortCode_cq_vc_expandslider')) {
	class WPBakeryShortCode_cq_vc_expandslider extends WPBakeryShortCodesContainer {
	}
}
if (class_exists('WPBakeryShortCode') && !class_exists('WPBakeryShortCode_cq_vc_expandslider_item')) {
	class WPBakeryShortCode_cq_vc_expandslider_item extends WPBakeryShortCode {
	}
}

?>
