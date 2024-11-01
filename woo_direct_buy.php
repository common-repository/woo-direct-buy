<?php
/**
 * Plugin Name: Easy direct buy for woocommerce
 * Plugin URI:  https://detrasdelaweb.com/product/woo-direct-buy/
 * Description: This plugin allow direct buy to woocommerce, perfect to marketplaces like "Mercadolibre"
 * Version: 1.0
 * Author: Jhainey Milevis
 * Author URI: http://disegnatec.com/
 * Text Domain: edbfw_direct_buy
 */


// Clear cart after add a new prodct
add_filter( 'woocommerce_add_to_cart_validation', 'edbfw_add_to_cart_validation', 10, 1 );
function edbfw_add_to_cart_validation( $passed ) {
    if( ! WC()->cart->is_empty() ){

        WC()->cart->empty_cart(true);

    }
    return $passed;
}

/**
 * @snippet       Redirect to Checkout Upon Add to Cart - WooCommerce
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=21607
 * @author        Rodolfo Melogli
 * @compatible    Woo 3.5.3
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

function edbfw_redirect_checkout_add_cart( $url ) {
    $url = get_permalink( get_option( 'woocommerce_checkout_page_id' ) );
    return $url;
}

add_filter( 'woocommerce_add_to_cart_redirect', 'edbfw_redirect_checkout_add_cart' );


add_filter('woocommerce_product_single_add_to_cart_text', 'edbfw_custom_cart_button_text');
add_filter('woocommerce_product_add_to_cart_text', 'edbfw_custom_cart_button_text');

function edbfw_custom_cart_button_text() {
    $text = get_option('edbfw_button_text');
    return empty($text)?__('Buy now', 'edbfw_direct_buy'):$text;
}

/** Step 1. */
function edbfw_cutom_menu_options()
{
    add_options_page('Easy direct buy for woocommerce Options', 'Easy direct buy for woocommerce', 'manage_options',
        'edbfw-options', 'register_edbfw_plugin_settings_page');
    //call register settings function
    add_action('admin_init', 'register_edbfw_plugin_settings');

}
/** Step 2 (from text above). */
if (is_admin()) { // admin actions
    add_action('admin_menu', 'edbfw_cutom_menu_options');

}

function register_edbfw_plugin_settings()
{
    //register our settings
    register_setting('edbfw_settings-group', 'edbfw_button_text');


}



function register_edbfw_plugin_settings_page()
{
    ?>
    <div class="wrap">
        <h1><?=__('Easy direct buy for woocommerce Options', 'edbfw_direct_buy')?></h1>


        <form method="post" action="options.php">
            <?php settings_fields('edbfw_settings-group'); ?>
            <?php do_settings_sections('edbfw_settings-group'); ?>
            <table class="form-table" style="width: 100%">


                <tr valign="top">
                    <th scope="row"><?=__('Buy now button Text', 'edbfw_direct_buy')?></th>
                    <td><input type="text" name="edbfw_button_text" placeholder="ej: Comprar ahora"
                               value="<?php echo esc_attr(get_option('edbfw_button_text')); ?>"/>
                    </td>
                </tr>


            </table>

            <?php submit_button(); ?>

        </form>


    </div>
    <?php


}
?>