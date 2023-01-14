<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Filter to remove the plugin credit notice added to the source.
 *
 */
add_filter('rank_math/frontend/remove_credit_notice', '__return_true');

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

//removing WP version
remove_action('wp_head', 'wp_generator');

add_filter('script_loader_tag', function ($url) {
    if ( is_user_logged_in() ) return $url; //don't break WP Admin
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.min.js' ) ) return $url;
    return str_replace( ' src', ' defer src', $url );
});

//Woocommerce 

// // To change add to cart text on single product page
// if (is_product_category('faca-sua-camiseta')) {
//     add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text');
//     function woocommerce_custom_single_add_to_cart_text()
//     {
//         return __('Compre sem customizar', 'woocommerce');
//     }
// }

add_filter( 'woocommerce_product_single_add_to_cart_text', function ($text) {
    return 'Comprar';
});

// add_filter( 'woocommerce_product_add_to_cart_text', function ($text) {
//     return 'Compre agora';
// });

add_filter( 'woocommerce_terms_is_checked_default', '__return_true' );

// For billing email and phone - Make them not required
add_filter( 'woocommerce_billing_fields', function ($billing_fields) {
// Only on checkout page
    if( ! is_checkout() ) {
        return $billing_fields;
    }
    $billing_fields['billing_cellphone']['required'] = true;   
    // $billing_fields['billing_email']['required'] = false;
    $billing_fields['billing_address_2']['required'] = false;
    return $billing_fields;
}, 20, 1 );

add_filter( 'woocommerce_checkout_fields', function ($fields) {
    unset( $fields['billing']['billing_phone'] );
	return $fields;
});

// Defer js
add_filter('script_loader_tag', function ($url) {
    if ( is_user_logged_in() ) return $url; //don't break WP Admin
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.min.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    return str_replace( ' src', ' defer src', $url );
});