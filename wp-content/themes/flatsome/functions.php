<?php
/**
 * Flatsome functions and definitions
 *
 * @package flatsome
 */

require get_template_directory() . '/inc/init.php';
update_option( 'flatsome_wup_purchase_code', 'GPL001122334455AA6677BB8899CC000' );
update_option( 'flatsome_wup_supported_until', '01.01.2050' );
update_option( 'flatsome_wup_buyer', 'GPL' );
/**
 * Note: It's not recommended to add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * Learn more here: http://codex.wordpress.org/Child_Themes
 */
add_filter('woocommerce_email_headers', 'add_reply_to_wc_admin_new_order', 10, 3);

function add_reply_to_wc_admin_new_order($header = '', $id = '', $order)
{
    $wc_email = new WC_Email(); //instantiate wc meail

    if ($id == 'new_order') {
        $reply_to_email = $order->billing_email;
        $header = 'Content-Type: ' . $wc_email->get_content_type() . "\r\n"; 
    }

    return $header;
}
