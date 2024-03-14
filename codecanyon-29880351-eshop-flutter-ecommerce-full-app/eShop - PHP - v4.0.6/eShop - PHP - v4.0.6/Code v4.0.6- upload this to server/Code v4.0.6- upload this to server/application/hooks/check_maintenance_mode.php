<?php

class Check_web_maintenance_mode
{
    function Check_if_web_maintenance_mode()
    {
        // echo "<pre>";
        $include_urls = array(
            base_url("cart"),
            base_url("cart/checkout"),
            base_url("compare"),
            base_url("home"),
            base_url("home/contact-us"),
            base_url("home/about-us"),
            base_url("home/categories"),
            base_url("home/terms-and-conditions"),
            base_url("home/privacy-policy"),
            base_url("home/faq"),
            base_url("login"),
            base_url("my-account"),
            base_url("my-account/orders"),
            base_url("my-account/profile"),
            base_url("my-account/notifications"),
            base_url("my-account/favorites"),
            base_url("my-account/manage-address"),
            base_url("my-account/wallet"),
            base_url("my-account/transactions"),
            base_url("payment"),
            base_url("products"),
            base_url("products/offers_and_flash_sale"),
            base_url("products/details/"),
            base_url(),
        );
        // print_R(json_encode($include_urls));
        // echo $esacped_url = str_replace("/", "\/", current_url());
        $settings = get_settings('system_settings', true);
        if (
            isset($settings) && isset($settings['is_web_under_maintenance']) && ($settings['is_web_under_maintenance'] != '') && ($settings['is_web_under_maintenance'] == 1) &&
            // stripos(json_encode($include_urls), $esacped_url) !== false
            in_array(current_url(), $include_urls)
            // preg_grep('/^' . str_replace("/", "\/", current_url()) . '\s.*/', $include_urls)
        ) {
            redirect(base_url("home/maintenance_mode"));
        }
    }
}
