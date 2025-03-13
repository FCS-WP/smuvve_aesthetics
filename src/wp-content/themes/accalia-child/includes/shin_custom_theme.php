<?php
add_action( 'template_redirect', 'custom_redirect_urls' );
function custom_redirect_urls() {
    if ( is_admin()) {
        return;
    }
    $redirect_urls = array(
        '/services/' => '/our-services',
    );

    $request_uri = $_SERVER['REQUEST_URI'];

    foreach ( $redirect_urls as $from_url => $to_url ) {
        if ( $request_uri == $from_url ) {

            wp_redirect( $to_url, 301 );
            exit;
        }
    }
}