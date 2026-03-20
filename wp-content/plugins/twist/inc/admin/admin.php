<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://codeixer.com
 * @since      1.0.0
 *
 * @package    twist
 * @subpackage twist/inc
 */

// Check if the free version is enabled, and if so, disable it
if (in_array('woo-product-gallery-slider/woo-product-gallery-slider.php', apply_filters('active_plugins', get_option('active_plugins')), true)) {
    deactivate_plugins('woo-product-gallery-slider/woo-product-gallery-slider.php');
}

require WPGS_INC . 'admin/options.php';

add_filter('attachment_fields_to_edit', 'wpgs_add_video_url', 10, 2);
add_filter('attachment_fields_to_save', 'wpgs_add_video_url_save', 10, 2);


if (! function_exists('wpgs_add_video_url')) {
    /**
     * Add Product Video URL fields to media uploader
     *
     * @param $form_fields array, fields to include in attachment form
     * @param $post object, attachment record in database
     * @return $form_fields, modified form fields
     */

    function wpgs_add_video_url($form_fields, $post)
    {
        $form_fields['twist-video-url'] = array(
            'label' => 'Video URL',
            'input' => 'text',
            'value' => get_post_meta($post->ID, 'twist_video_url', true),
            'helps' => 'Woocommerce Product Video Link',
        );

        return $form_fields;
    }
}



if (! function_exists('wpgs_add_video_url_save')) {
    /**
     * Save values of Product Video URL fields to media uploader
     *
     * @param $post array, the post data for database
     * @param $attachment array, attachment fields from $_POST form
     * @return $post array, modified post data
     */

    function wpgs_add_video_url_save($post, $attachment)
    {
        if (isset($attachment['twist-video-url'])) {
            update_post_meta($post['ID'], 'twist_video_url', $attachment['twist-video-url']);
        }
        
        return $post;
    }
}


//value from Plugin settings
$check_img = cix_wpgs::option('adv_single_image');
if ($check_img['main_image_width']) {
    add_filter('woocommerce_get_image_size_single', function ($size) {
        $opts = cix_wpgs::option('adv_single_image');
        return array(
            'width'  => (!empty($opts['main_image_width'])) ? absint($opts['main_image_width']) : '600',
            'height' => absint($opts['main_image_height']),
            'crop' => absint($opts['main_image_crop']),
            
        );
    });
    add_filter('woocommerce_get_image_size_gallery_thumbnail', function ($size) {
        $opts = cix_wpgs::option('adv_thumbs_image');
        return array(
            'width'  => absint($opts['i_width']),
            'height' => absint($opts['i_height']),
            'crop'   => absint($opts['i_crop']),
        );
    });
}



function wpgs_single_image_width()
{
    $old_single_size    = get_option('shop_single_image_size', array());


    return (!empty($old_single_size)) ? $old_single_size['width'] : '600';
}



add_filter('wc_get_template', 'wpgs_get_template', 10, 5);

if (! function_exists('wpgs_get_template')) {
    function wpgs_get_template($located, $template_name, $args, $template_path, $default_path)
    {
        if ('single-product/product-image.php' == $template_name) {
            $located = WPGS_INC . 'public/templates/default.php';
        }
        
        return $located;
    }
}

/*  Shortcode */
function twist_shortcod_render()
{
    ob_start();
    if (is_product()) {
        cix_wpgs::wpgs_templates();
    }
        
    $output = ob_get_clean();
    return $output;
}
/**
 * @deprecated shortocde
 * we just keep it for older version support
 * @since version 1.0
 */

add_shortcode('twist_vc', 'twist_shortcod_render');

/**
 * @since verion 3.0
 * Shortcdoe for display the gallery section
 */
add_shortcode('product_gallery_slider', 'twist_shortcod_render');

add_action('vc_before_init', 'twist_vc_map');

function twist_vc_map()
{
    vc_map(array(
        "name"        => __("Twist Product Gallery", "wpgs-td"),
        "base"        => "twist_vc",
        "description" => __("Product Gallery Slider", "wpgs-td"),
        "category"    => __("WooCommerce", "wpgs-td"),
        
    
    ));
}


add_filter('plugin_row_meta', 'wpgs_plugin_meta_links', 10, 2);
  /**
   * Add links to plugin's description in plugins table
   *
   * @param array  $links  Initial list of links.
   * @param string $file   Basename of current plugin.
   *
   * @return array
   */
function wpgs_plugin_meta_links($links, $file)
{
    if ($file !== WPGS_PLUGIN_BASE) {
        return $links;
    }
   
    

    $support_link = '<a style="color:red;" target="_blank" href="https://codeixer.com/s" title="' . __('Get help', 'wpgs-td') . '">' . __('Support', 'wpgs-td') . '</a>';

    $links[] = $support_link;

    return $links;
} // plugin_meta_links

function wpgs_plugin_settings_link($links)
{
    $settings_link = '<a href="'.get_admin_url(null, 'admin.php?page=cix-gallery-settings').'">' . __('Settings', 'wpgs-td') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = WPGS_PLUGIN_BASE;
add_filter("plugin_action_links_$plugin", 'wpgs_plugin_settings_link');


add_filter('wpgs_carousel_mode', 'wpgs_carousel_mode_return', 20);

function wpgs_carousel_mode_return($boolen)
{
    $thumb_lightbox =  (cix_wpgs::option('thumbnails_lightbox') == 1) ? 'true' : 'false';
    if ($thumb_lightbox == 'true') {
        return false;
    } else {
        return true;
    }
}

// add class into main wrapper
add_filter('wpgs_wrapper_add_classes', 'wpgs_no_gallery_class', 20, 2);

function wpgs_no_gallery_class($class, $attachment_ids)
{
    return (empty($attachment_ids)) ? ' wpgs-no-gallery-images' : ' wpgs-has-gallery-images' ;
}


/**
 * Plugin Notice
 * * Promotional Notice
 */

$twist_notice = new \WPTRT\AdminNotices\Notices();


$slug        = 'deposits-for-woocommerce';
$install_url = esc_url(wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $slug), 'install-plugin_' . $slug));
                    
$popup_url = esc_url(add_query_arg(array(
    'tab'       => 'plugin-information',
    'section'   => 'description',
    'plugin'    => $slug ,
    'TB_iframe' => 'true',
    'width'     => '950',
    'height'    => '600',
), self_admin_url('plugin-install.php')));

$promo_message = '<img src="https://ps.w.org/deposits-for-woocommerce/assets/icon-128x128.png" /> <p>Allowed customers to pay for products using a fixed or percentage amount of the productby using <a target="_blank" class="thickbox open-plugin-details-modal" href="'.$popup_url.'"><strong>Deposits for WooCommerce</strong></a></p>
<a href="'.$install_url.'" class="button button-alt"> Install Now </a>';
  
$plugins     = array_keys(get_plugins());

if (!in_array('deposits-for-woocommerce/deposits-for-woocommerce.php', $plugins)) {
    $twist_notice->add(
        'woo_deposits',                       // Unique ID.
        '',
        $promo_message, // The content for this notice.
        [
            'scope'         => 'user',
            'screens'       => [ 'plugins','dashboard','codeixer_page_cix-gallery-settings' ], // Only show notice in the "themes" screen.
            'type'          => '',    // Make this a warning (orange color).
            'alt_style'     => false,         // Use alt styles.
            'option_prefix' => 'woo_deposits_dismissed',   // Change the user-meta prefix.
        ]
    );
    $twist_notice->boot();
}
