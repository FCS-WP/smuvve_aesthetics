<?php
if (!class_exists('VC_Extensions_CardCarousel')){
    class VC_Extensions_CardCarousel{
        private $titlesize, $captionsize, $itemindex;
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Card Carousel", 'cq_allinone_vc'),
            "base" => "cq_vc_cardcarousel",
            "class" => "cq_vc_cardcarousel",
            "icon" => "cq_vc_cardcarousel",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_cardcarousel_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('Avatar with text', 'js_composer'),
            "params" => array(
                array(
                   "type" => "dropdown",
                   "edit_field_class" => "vc_col-xs-6 vc_column",
                   "heading" => esc_attr__("Auto delay slideshow", "js_composer"),
                   "param_name" => "autodelay",
                   "value" => array("no", "2", "3", "4", "5", "6", "7", "8"),
                   "std" => "no",
                   "description" => esc_attr__("In seconds, default is no, which is disabled.", "js_composer")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Avatar size (in pixel)", "cq_allinone_vc"),
                 "param_name" => "avatarsize",
                 "value" => array("40", "60", "80", "100", "120"),
                 "std" => "60",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Button navigation position", "cq_allinone_vc"),
                 "param_name" => "btnpos",
                 "value" => array("left", "right"),
                 "std" => "right",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Button shape", "cq_allinone_vc"),
                 "param_name" => "btnshape",
                 "value" => array("square", "rounded", "circle"),
                 "std" => "rounded",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Button size", "cq_allinone_vc"),
                 "param_name" => "btnsize",
                 "value" => array("small", "medium", "large"),
                 "std" => "medium",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Card shape", "cq_allinone_vc"),
                 "param_name" => "cardshape",
                 "value" => array("square", "rounded" ),
                 "std" => "rounded",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Card item gap", "cq_allinone_vc"),
                 "param_name" => "cardgap",
                 "value" => array("small" => "140", "medium" => "160", "large" => "180", "x-large" => "200"),
                 "std" => "140",
                 "description" => esc_attr__("Gap between each card, please choose the large value if the avatar size is large.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Arrow color", 'cq_allinone_vc'),
                "param_name" => "arrowcolor",
                "value" => '',
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Arrow background color", 'cq_allinone_vc'),
                "param_name" => "arrowbgcolor",
                "value" => '',
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Arrow hover color", 'cq_allinone_vc'),
                "param_name" => "arrowhovercolor",
                "value" => '',
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Arrow background hover color", 'cq_allinone_vc'),
                "param_name" => "arrowbghovercolor",
                "value" => '',
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Card title font size", "cq_allinone_vc"),
                "param_name" => "titlesize",
                "value" => "",
                "description" => esc_attr__("Support value like 1em or 14px etc.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Card caption font size", "cq_allinone_vc"),
                "param_name" => "captionsize",
                "value" => "",
                "description" => esc_attr__("Support value like 1em or 14px etc.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("min-height for this element", "cq_allinone_vc"),
                "param_name" => "minheight",
                "value" => "",
                "description" => esc_attr__("Default is 400px, you may have to increase the value if have too many contents.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("margin-top offset for this element", "cq_allinone_vc"),
                "param_name" => "margintop",
                "value" => "",
                "description" => esc_attr__("CSS margin-top for the whole cards, you may have to customize this value in some theme to make sure the element is align vertical center. For example -30px, which will move the element 30px above.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Extra class name", "cq_allinone_vc"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cq_allinone_vc")
              ),
              array(
                "type" => "css_editor",
                "heading" => esc_attr__( "CSS", "cq_allinone_vc" ),
                "param_name" => "css",
                "description" => esc_attr__("It's recommended to use this to customize the padding/margin only.", "cq_allinone_vc"),
                "group" => esc_attr__( "Design options", "cq_allinone_vc" ),
             )
           )
        ));

        vc_map(
          array(
             "name" => esc_attr__("Card Item","cq_allinone_vc"),
             "base" => "cq_vc_cardcarousel_item",
             "class" => "cq_vc_cardcarousel_item",
             "icon" => "cq_vc_cardcarousel_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Avatar with text","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_cardcarousel'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Card background style", "cq_allinone_vc"),
                "param_name" => "bgstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Or you can customized color:" => "customized"),
                'std' => 'aqua',
                "description" => esc_attr__("Choose the card background.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Card background color", 'cq_allinone_vc'),
                "param_name" => "bgcolor",
                "value" => "",
                "dependency" => array("element" => "bgstyle", "value" => "customized"),
                "description" => esc_attr__("You can customize with your own one here.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Card title (optional)", "cq_allinone_vc"),
                "param_name" => "cardtitle",
                "value" => "Default title",
                "description" => esc_attr__("Text title for the card.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Card caption (optional)", "cq_allinone_vc"),
                "param_name" => "caption",
                "value" => "Optional card caption under the title.",
                "description" => esc_attr__("Text caption for the card.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Title color", 'cq_allinone_vc'),
                "param_name" => "titlecolor",
                "value" => "",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Caption color", 'cq_allinone_vc'),
                "param_name" => "captioncolor",
                "value" => "",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                 "type" => "dropdown",
                 "heading" => esc_attr__("Display the avatar on the", "cq_allinone_vc"),
                 "param_name" => "avatarposition",
                 "value" => array("left", "right"),
                 "std" => "left",
                 "group" => "Avatar",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Display the avatar with", "cq_allinone_vc"),
                 "param_name" => "avatartype",
                 "value" => array("icon", "image", "none"),
                 "std" => "icon",
                 "group" => "Avatar",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                  "type" => "attach_image",
                  "edit_field_class" => "vc_col-xs-6 vc_column",
                  "heading" => esc_attr__("Avatar image:", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                  "group" => "Avatar",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                'type' => 'dropdown',
                'edit_field_class' => 'vc_col-xs-6 vc_column',
                'heading' => esc_attr__( 'Icon library', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'avataricon',
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-user', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'type' => 'fontawesome',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'fontawesome',
                ),
                'group' => 'Avatar',
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'openiconic',
                ),
                'group' => 'Avatar',
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'typicons',
                ),
                'group' => 'Avatar',
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-user', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'entypo',
                ),
                'group' => 'Avatar',
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'linecons',
                ),
                'group' => 'Avatar',
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_material',
                'value' => 'vc-material vc-material-cake',
                // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false,
                  // default true, display an "EMPTY" icon?
                  'type' => 'material',
                  'iconsPerPage' => 100,
                  // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'material',
                ),
                'group' => 'Avatar',
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Icon font-size", "cq_allinone_vc"),
                "param_name" => "iconsize",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "group" => "Avatar",
                "description" => esc_attr__("Default (leave to be blank) is 2.4em, support a value like 36px or 3.2em", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Color of the icon", "cq_allinone_vc"),
                "param_name" => "iconcolor",
                "value" => "",
                "dependency" => Array("element" => "avatartype", "value" => array("icon")),
                "group" => "Avatar",
                "description" => esc_attr__("Default is white", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Background color of the icon", "cq_allinone_vc"),
                "param_name" => "iconbg",
                "value" => "",
                "dependency" => Array("element" => "avatartype", "value" => array("icon")),
                "group" => "Avatar",
                "description" => esc_attr__("Default is white", "cq_allinone_vc")
              ),
              array(
                  "type" => "vc_link",
                  "heading" => esc_attr__( "link URL for avatar (can be opened as lightbox)", "cq_allinone_vc" ),
                  "param_name" => "thelink",
                  "group" => "Avatar",
                  "dependency" => Array("element" => "avatartype", "value" => array("icon", "image")),
                  "description" => esc_attr__("Support YouTube, Vimeo video, image, Google Map etc, for example, https://vimeo.com/639845104, or https://www.youtube.com/watch?v=ba2OnpjbncQ", "cq_allinone_vc")
              ),
              array(
                "type" => "checkbox",
                "heading" => esc_attr__("Display the link for avatar as lightbox?", "js_composer" ),
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "param_name" => "islightbox",
                "std" => "yes",
                "group" => "Avatar",
                "description" => esc_attr__("Support YouTube, Vimeo video, image, Google Map etc.", "js_composer" ),
                "value" => array( esc_attr__( "Yes, apply lightbox effect", "js_composer" ) => "yes" ),
              ),
              array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Lightbox image for avatar (optional):", "cq_allinone_vc"),
                  "param_name" => "lightboximage",
                  "value" => "",
                  "group" => "Avatar",
                  "dependency" => Array("element" => "avatartype", "value" => array("icon", "image")),
                  "description" => esc_attr__("Select from media library. The link above will be ignored if added.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Avatar tooltip (optional)", "cq_allinone_vc"),
                "param_name" => "tooltip",
                "value" => "Optional avatar tooltip",
                "group" => "Avatar",
               "dependency" => Array("element" => "avatartype", "value" => array("icon", "image")),
                "description" => esc_attr__("Tooltip for the avatar image or icon.", "cq_allinone_vc")
              ),


              ),
            )
        );

          add_shortcode('cq_vc_cardcarousel', array($this,'cq_vc_cardcarousel_func'));
          add_shortcode('cq_vc_cardcarousel_item', array($this,'cq_vc_cardcarousel_item_func'));

      }

      function cq_vc_cardcarousel_func($atts, $content=null) {
        $css_class = $css = $arrowcolor = $arrowbgcolor = $arrowhovercolor = $arrowbghovercolor = $extraclass = $margintop = $minheight = '';
        $avatarsize = $btnpos = $btnshape = $btnsize = $cardshape = $cardgap = $imageposition = $navposition = $itemindex = $titlesize = $captionsize = '';
        $this -> titlesize = '';
        $this -> captionsize = '';
        $this -> itemindex = 0;
        extract(shortcode_atts(array(
          "avatarsize" => "60",
          "btnpos" => "right",
          "btnshape" => "rounded",
          "btnsize" => "medium",
          "cardshape" => "rounded",
          "cardgap" => "160",
          "itemindex" => "0",
          "islightbox" => "yes",
          "titlesize" => "",
          "captionsize" => "",
          "imageposition" => "top",
          "navposition" => "float-left",
          "arrowcolor" => "",
          "arrowbgcolor" => "",
          "arrowhovercolor" => "",
          "arrowbghovercolor" => "",
          "autodelay" => "no",
          "css" => "",
          "margintop" => "",
          "minheight" => "",
          "extraclass" => ""
        ),$atts));

        vc_icon_element_fonts_enqueue('entypo');

        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_cardcarousel', $atts);
        wp_register_style( 'vc-extensions-cardcarousel-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-cardcarousel-style' );


        wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
        wp_enqueue_style('tooltipster');

        wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('tooltipster');

        wp_register_style('lity', plugins_url('../hotspot/css/lity.min.css', __FILE__));
        wp_enqueue_style('lity');

        wp_register_script('lity', plugins_url('../hotspot/js/lity.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('lity');


        wp_register_script('vc-extensions-cardcarousel-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "tooltipster"));
        wp_enqueue_script('vc-extensions-cardcarousel-script');

        $this -> itemindex = $itemindex;
        $this -> titlesize = $titlesize;
        $this -> captionsize = $captionsize;

        $output .= '<div class="cq-cardcarousel cq-cardcarousel-btn-'.$btnpos.' cq-cardcarousel-btn-'.$btnshape.' cq-cardcarousel-btn-'.$btnsize.' cq-cardcarousel-shape-'.$cardshape.' cq-cardcarousel-gap-'.$cardgap.' cq-cardcarousel-'.$avatarsize.' '.$extraclass.' '.$css_class.'" data-arrowcolor="'.$arrowcolor.'" data-autodelay="'.$autodelay.'" data-arrowhovercolor="'.$arrowhovercolor.'" data-arrowbgcolor="'.$arrowbgcolor.'" data-arrowbghovercolor="'.$arrowbghovercolor.'" style="min-height:'.$minheight.';">';


        $output .= '<div class="cq-cardcarousel-container" style="margin-top:'.$margintop.';">';

        $nav_str = '';

        $nav_str .= '<div class="cq-cardcarousel-navigation btn-large">';
        $nav_str .= '<div class="cq-cardcarousel-btn cq-cardcarousel-prev" style="background-color:'.$arrowbgcolor.';color:'.$arrowcolor.';">';
        $nav_str .= '<i class="cq-cardcarousel-icon entypo-icon entypo-icon-up-open-big"></i>';
        $nav_str .= '</div>';
        $nav_str .= '<div class="cq-cardcarousel-btn cq-cardcarousel-next" style="background-color:'.$arrowbgcolor.';color:'.$arrowcolor.';">';
        $nav_str .= '<i class="cq-cardcarousel-icon entypo-icon entypo-icon-down-open-big"></i>';
        $nav_str .= '</div>';
        $nav_str .= '</div>';

        if($btnpos == "left"){
            $output .= $nav_str;
        }





        $output .= '<ul class="cq-cardcarousel-list" style="--rotateDegrees:-20; --currentDay:0;">';
        $output .= do_shortcode($content);

        $output .= '</ul>';

        if($btnpos == "right"){
            $output .= $nav_str;
        }




        $output .= '</div>';

        $output .= '</div>';
        return $output;

      }


      function cq_vc_cardcarousel_item_func($atts, $content=null, $tag=null) {
          $output = $thelink = $videourl = $image = $imagesize = $videowidth = $isresize = $islightbox = $cardtitle = $caption = $tooltip = $bgstyle = $bgcolor = $titlecolor = $captioncolor =  $css =   "";
          $avataricon = $iconcolor = $iconbg = $iconsize = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_monosocial = $icon_material = "";
            extract(shortcode_atts(array(
              "avatarposition" => "left",
              "avatartype" => "icon",
              "iconsize" => "",
              "iconcolor" => "",
              "iconbg" => "",
              "avataricon" => "entypo",
              "icon_fontawesome" => "fa fa-user",
              "icon_openiconic" => "vc-oi vc-oi-dial",
              "icon_typicons" => "typcn typcn-adjust-brightness",
              "icon_entypo" => "entypo-icon entypo-icon-user",
              "icon_linecons" => "vc_li vc_li-heart",
              "icon_material" => 'vc-material vc-material-cake',
              "icon_pixelicons" => "",
              "icon_monosocial" => "",
              "thelink" => "",
              "islightbox" => "yes",
              "videourl" => "",
              "image" => "",
              "lightboximage" => "",
              "imagesize" => "64",
              "isresize" => "yes",
              "iscaption" => "",
              "tooltip" => "Optional avatar tooltip",
              "cardtitle" => "Card title",
              "caption" => "Caption for the card",
              "bgstyle" => "aqua",
              "bgcolor" => "",
              "titlecolor" => "",
              "captioncolor" => "",
              "css" => ""
            ), $atts));

          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $itemindex = $this -> itemindex;
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

          // $color_style_arr = array("grapefruit", "bittersweet", "sunflower", "grass", "mint", "aqua", "bluejeans", "lavender", "pinkrose", "lightgray", "mediumgray", "darkgray");
          // $card_style = $color_style_arr[array_rand($color_style_arr)];
          // if($bgcolor != "") $card_style = "customized";


          $avatar_str = $text_str = '';

          $output .= '<li class="cq-cardcarousel-item cq-cardcarousel-type-'.$avatartype.' cq-cardcarousel-item-'.$bgstyle.' cq-cardcarousel-'.$avatarposition.'" style="--day_idx:'.($this -> itemindex ).';background-color:'.$bgcolor.';" data-image="'.$thumbnail.'">';

          // $output .= '<div class="cq-cardcarousel-itemcontainer">';

          if($openedimageurl != ""){
              $avatar_str .= '<a href="'.$openedimageurl.'" class="cq-cardcarousel-link" title="'.get_post_meta($lightboxattachment->ID, '_wp_attachment_image_alt', true ).'" '.$is_lity.' data-lity-desc="'.get_post_meta($lightboxattachment->ID, '_wp_attachment_image_alt', true ).'">';
          } else {
              if($thelink['url'] != ""){
                  $avatar_str .= '<a href="'.$thelink['url'].'" class="cq-cardcarousel-link" title="'.$thelink["title"].'" '.$is_lity.' target="'.$thelink["target"].'" data-lity-desc="'.esc_html($cardtitle).'">';
              } else {
                  $avatar_str .= '<a href="'.$thelink['url'].'" class="cq-cardcarousel-link" title="'.$thelink["title"].'" '.$is_lity.' target="'.$thelink["target"].'" data-lity-desc="'.esc_html($cardtitle).'">';

              }
          }


          if($avatartype=="image"){
            if($thumbnail!=""){
                $avatar_str .= '<div class="cq-cardcarousel-avatar" data-tooltip="'.esc_html($tooltip).'" title="'.esc_html($tooltip).'" style="background-image:url('.$thumbnail.');">';
                // $avatar_str .= '<img src="'.$thumbnail.'" alt="'.get_post_meta($image, '_wp_attachment_image_alt', true ).'" class="cq-cardcarousel-img" />';
                $avatar_str .= '</div>';
            }
          }else if($avatartype=="icon"){
            $avatar_str .= '<div class="cq-cardcarousel-avatar" data-tooltip="'.esc_html($tooltip).'" title="'.esc_html($tooltip).'" style="background-color:'.$iconbg.';">';
            if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $avataricon})&&esc_attr(${'icon_' . $avataricon})!=""&&$avatartype=="icon"){
              $avatar_str .= '<i class="cq-cardcarousel-icon '.esc_attr(${'icon_' . $avataricon}).'" style="color:'.$iconcolor.';font-size:'.$iconsize.'"></i>';
            }
            $avatar_str .= '</div>';
          }else{
            $avatar_str = '';
          }


          $avatar_str .= '</a>';

          $text_str .= '<div class="cq-cardcarousel-contentcontainer">';
          if(esc_html($cardtitle)!=""){
            $text_str .= '<span class="cq-cardcarousel-title" style="color:'.$titlecolor.';font-size:'.$this -> titlesize.';">';
            $text_str .= esc_html($cardtitle);
            $text_str .= '</span>';
          }

          if(esc_html($caption)!=""){
            $text_str .= '<span class="cq-cardcarousel-caption" style="color:'.$captioncolor.';font-size:'.$this -> captionsize.';">';
            $text_str .= esc_html($caption);
            $text_str .= '</span>';
          }

          $text_str .= '</div>';

          if($avatarposition=="left"){
              $output .= $avatar_str.$text_str;
          }else{
              $output .= $text_str.$avatar_str;
          }



          $output .= '</li>';

          $this -> itemindex = $itemindex + 1;

          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_cardcarousel')) {
    class WPBakeryShortCode_cq_vc_cardcarousel extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_cardcarousel_item')) {
    class WPBakeryShortCode_cq_vc_cardcarousel_item extends WPBakeryShortCode {
    }
}

?>
