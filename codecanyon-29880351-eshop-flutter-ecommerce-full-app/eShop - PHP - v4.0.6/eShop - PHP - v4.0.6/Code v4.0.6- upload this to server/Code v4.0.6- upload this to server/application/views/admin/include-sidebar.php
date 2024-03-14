<!DOCTYPE html>

<?php $current_url = current_url();

$settings = get_settings('system_settings', true); ?>


<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url('assets/admin') ?>" data-template="vertical-menu-template-free">

</html>
<!-- Menu -->


<!-- Sidebar -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?= base_url('admin/home') ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="<?= base_url()  . get_settings('favicon') ?>" class="brand-image">
            </span>
            <span class="brand-text  fw-bolder ms-2"><?= $settings['app_name']; ?></span>

        </a>

        <a href="<?= base_url('admin/home') ?>" class="app-brand-link">

        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 ps ps--active-y">

        <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->

        <!-- Dashboard -->
        <li class="menu-item <?= ($current_url == base_url('admin/home')) ? 'active' : '' ?>">
            <a href="<?= base_url('/admin/home') ?>" class="menu-link ">
                <i class="ion-icon-desktop-outline"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>


        <!-- Orders -->
        <?php if (has_permissions('read', 'orders')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/orders') || $current_url == base_url('admin/orders/order-tracking') || ($current_url == base_url('admin/notification_settings/manage_ststem_notifications')) || $current_url == base_url('admin/orders/edit_orders')) ? 'active open' : '' ?>">
                <a href="#" class="menu-link menu-toggle">
                    <i class="ion-icon-cart-outline"></i>
                    <div data-i18n="Layouts">Orders</div>
                </a>

                <ul class="menu-sub">
                    <?php if (has_permissions('read', 'orders')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/orders')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/orders/') ?>#order" class="menu-link">
                                <div data-i18n="Without menu">Orders</div>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (has_permissions('read', 'orders')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/orders/order-tracking')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/orders/order-tracking') ?>#order" class="menu-link">
                                <div data-i18n="Without menu">Order Tracking</div>
                            </a>
                        </li>
                    <?php } ?>


                    <?php if (has_permissions('read', 'orders')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/notification_settings/manage_ststem_notifications')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/notification_settings/manage_ststem_notifications') ?>#order" class="menu-link">
                                <div data-i18n="Without menu">System Notifications</div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>



        <!-- Categories -->
        <?php if (has_permissions('read', 'categories')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/category/create_category') || ($current_url == base_url('admin/category/category-order'))) ? 'active open' : '' ?>">
                <a href="#" class="menu-link menu-toggle">
                    <i class="ion-icon-disc-outline"></i>
                    <div data-i18n="Layouts">Categories</div>
                </a>
                <ul class="menu-sub">
                    <?php if (has_permissions('read', 'categories')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/category/create_category')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/category/create_category') ?>" class="menu-link">
                                <div data-i18n="Without menu">Categories</div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (has_permissions('read', 'category_order')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/category/category-order')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/category/category-order') ?>" class="menu-link">
                                <div data-i18n="Without menu">Category Order</div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <!-- Brands -->
        <?php if (has_permissions('read', 'media')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/brand')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/brand/') ?>" class="menu-link">
                    <i class="ion-icon-color-filter-outline"></i>
                    <div data-i18n="Without menu">Brands</div>
                </a>
            </li>
        <?php } ?>

        <!-- Products -->
        <?php if (has_permissions('read', 'product') || has_permissions('read', 'attribute') || has_permissions('read', 'attribute_set') || has_permissions('read', 'attribute_value') || has_permissions('read', 'tax') || has_permissions('read', 'product_order')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/attributes') || $current_url == base_url('admin/taxes/manage-taxes') || $current_url == base_url('admin/product/create-product') || $current_url == base_url('admin/product/bulk-upload') || $current_url == base_url('admin/product') || $current_url == base_url('admin/product_faqs') || $current_url == base_url('admin/product/product-order')) ? 'active open' : '' ?>">
                <a href="#" class="menu-link menu-toggle">
                    <i class="ion-icon-file-tray-stacked-outline"></i>
                    <div data-i18n="Layouts">Products</div>
                </a>

                <ul class="menu-sub">
                    <?php if (has_permissions('read', 'attribute')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/attributes')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/attributes') ?>" class="menu-link">
                                <div data-i18n="Layouts">Attributes</div>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (has_permissions('read', 'tax')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/taxes/manage-taxes')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/taxes/manage-taxes') ?>" class="menu-link">
                                <div data-i18n="Layouts">Tax</div>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (has_permissions('read', 'product')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/product/create-product')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/product/create-product') ?>" class="menu-link">
                                <div data-i18n="Layouts">Add Product</div>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (has_permissions('read', 'product')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/product/bulk-upload')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/product/bulk-upload') ?>" class="menu-link">
                                <div data-i18n="Layouts">Bulk Upload</div>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (has_permissions('read', 'product')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/product')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/product/') ?>" class="menu-link">
                                <div data-i18n="Layouts">Manage Products</div>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (has_permissions('read', 'product_faqs')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/product_faqs')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/product_faqs/') ?>" class="menu-link">
                                <div data-i18n="Layouts">Product FAQs</div>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (has_permissions('read', 'product_order')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/product/product-order')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/product/product-order') ?>" class="menu-link">
                                <div data-i18n="Layouts">Products Order</div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <!-- Flash Sale -->
        <?php if (has_permissions('read', 'flash_sale')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/flash_sale') || $current_url == base_url('admin/flash_sale/view_sale'))  ? 'active' : '' ?>">
                <a href="<?= base_url('admin/flash_sale/') ?>" class="menu-link">
                    <i class="ion-icon-flash-outline"></i>
                    <div data-i18n="Layouts">Flash Sale</div>
                </a>
            </li>
        <?php } ?>


        <!-- Point of sale -->
        <?php if (has_permissions('read', 'orders')) {
        ?>
            <li class="menu-item <?= ($current_url == base_url('admin/point_of_sale')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/point_of_sale/') ?>" class="menu-link">
                    <i class="ion-icon-calculator-outline"></i>
                    <div data-i18n="Layouts">Point Of Sale</div>
                </a>
            </li>
        <?php }
        ?>
        <!-- Media -->
        <?php if (has_permissions('read', 'media')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/media')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/media/') ?>" class="menu-link">
                    <i class="ion-icon-musical-notes-outline"></i>
                    <div data-i18n="Layouts">Media</div>
                </a>
            </li>
        <?php } ?>
        <!-- Sliders -->
        <?php if (has_permissions('read', 'home_slider_images')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/slider/manage-slider')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/slider/manage-slider') ?>" class="menu-link">
                    <i class="ion-icon-image-outline"></i>
                    <div data-i18n="Layouts">Sliders</div>
                </a>
            </li>
        <?php } ?>

        <!-- Offers -->
        <?php if (has_permissions('read', 'new_offer_images')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/offer') || $current_url == base_url('admin/offer_slider') || $current_url == base_url('admin/offer-slider/section-order')) ? 'active open' : '' ?>">
                <a href="#" class="menu-link menu-toggle">
                    <i class="ion-icon-gift-outline"></i>
                    <div data-i18n="Layouts">Offers</div>

                </a>
                <ul class="menu-sub">
                    <li class="menu-item <?= ($current_url == base_url('admin/offer')) ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/offer') ?>" class="menu-link">
                            <div data-i18n="Layouts">Offers</div>
                        </a>
                    </li>
                    <li class="menu-item <?= ($current_url == base_url('admin/offer_slider')) ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/offer_slider') ?>" class="menu-link">
                            <div data-i18n="Layouts">Offers Slider</div>
                        </a>
                    </li>
                    <li class="menu-item <?= ($current_url == base_url('admin/offer-slider/section-order')) ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/offer-slider/section-order') ?>" class="menu-link">
                            <div data-i18n="Layouts">Sections Order</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>


        <!-- manage stock -->
        <?php if (has_permissions('read', 'manage_stock')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/manage_stock')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/manage_stock') ?>" class="menu-link">
                    <i class="ion-icon-cube-outline"></i>
                    <div data-i18n="Layouts">Manage Stock</div>
                </a>
            </li>



        <?php } ?>


        <!-- Support Tickets -->
        <?php if (has_permissions('read', 'support_tickets')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/tickets/ticket-types') || $current_url == base_url('admin/tickets')) ? 'active open' : '' ?>">
                <a href="#" class="menu-link menu-toggle">
                    <i class="ion-icon-ticket-outline"></i>
                    <div data-i18n="Layouts">Support Tickets</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item <?= ($current_url == base_url('admin/tickets/ticket-types')) ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/tickets/ticket-types') ?>" class="menu-link">
                            <div data-i18n="Layouts">Ticket Types</div>
                        </a>
                    </li>
                    <li class="menu-item <?= ($current_url == base_url('admin/tickets')) ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/tickets') ?>" class="menu-link">
                            <div data-i18n="Layouts">Tickets</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <!-- Promo Code -->
        <?php if (has_permissions('read', 'promo_code')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/promo-code/manage-promo-code')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/promo-code/manage-promo-code') ?>" class="menu-link">
                    <i class="ion-icon-extension-puzzle-outline"></i>
                    <div data-i18n="Layouts">Promo Code</div>
                </a>
            </li>
        <?php } ?>

        <!-- Featured Sections -->
        <?php if (has_permissions('read', 'featured_section')) { ?>
            <li class="menu-item  <?= ($current_url == base_url('admin/featured-sections') || $current_url == base_url('admin/featured-sections/section-order')) ? 'active open' : '' ?>">
                <a href="#" class="menu-link menu-toggle">
                    <i class="ion-icon-server-outline"></i>
                    <div data-i18n="Layouts">Featured Sections</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item  <?= ($current_url == base_url('admin/featured-sections')) ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/featured-sections/') ?>" class="menu-link">
                            <div data-i18n="Layouts">Manage Sections</div>
                        </a>
                    </li>
                    <li class="menu-item  <?= ($current_url == base_url('admin/featured-sections/section-order')) ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/featured-sections/section-order') ?>" class="menu-link">
                            <div data-i18n="Layouts">Sections Order</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <!-- Customer -->
        <?php if (has_permissions('read', 'customers')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/customer') || $current_url == base_url('admin/customer/addresses') || $current_url == base_url('admin/transaction/view-transaction') || $current_url == base_url('admin/transaction/customer-wallet')) ? 'active open' : '' ?>">
                <a href="#" class="menu-link menu-toggle">
                    <i class="ion-icon-person-outline"></i>
                    <div data-i18n="Layouts">Customer</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item <?= ($current_url == base_url('admin/customer')) ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/customer/') ?>" class="menu-link">
                            <div data-i18n="Layouts">View Customers</div>

                        </a>
                    </li>
                    <li class="menu-item <?= ($current_url == base_url('admin/customer/addresses')) ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/customer/addresses') ?>" class="menu-link">
                            <div data-i18n="Layouts">Addresses</div>
                        </a>
                    </li>
                    <li class="menu-item <?= ($current_url == base_url('admin/transaction/view-transaction')) ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/transaction/view-transaction') ?>" class="menu-link">

                            <div data-i18n="Layouts">Transactions</div>
                        </a>
                    </li>
                    <li class="menu-item <?= ($current_url == base_url('admin/transaction/customer-wallet')) ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/transaction/customer-wallet') ?>" class="menu-link">

                            <div data-i18n="Layouts">Wallet Transactions</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>


        <!-- Return request -->
        <?php if (has_permissions('read', 'return_request')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/return-request')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/return-request') ?>" class="menu-link">
                    <i class="ion-icon-refresh-outline"></i>
                    <div data-i18n="Layouts">Return Requests</div>
                </a>
            </li>
        <?php } ?>


        <!-- Delivery Boy -->
        <?php if (has_permissions('read', 'delivery_boy') || has_permissions('read', 'fund_transfer')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/delivery-boys/manage-delivery-boy') || $current_url == base_url('admin/fund-transfer') || $current_url == base_url('admin/delivery-boys/manage-cash')) ? 'active open' : '' ?>">
                <a href="#" class="menu-link menu-toggle">
                    <i class="ion-icon-id-card-outline"></i>
                    <div data-i18n="Layouts">Delivery Boys</div>
                </a>
                <ul class="menu-sub">
                    <?php if (has_permissions('read', 'delivery_boy')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/delivery-boys/manage-delivery-boy')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/delivery-boys/manage-delivery-boy') ?>" class="menu-link ">
                                <div data-i18n="Layouts">Manage Delivery Boys</div>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (has_permissions('read', 'fund_transfer')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/fund-transfer')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/fund-transfer/') ?>" class="menu-link">
                                <div data-i18n="Layouts">Fund Transfer</div>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (has_permissions('read', 'delivery_boy')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/delivery-boys/manage-cash')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/delivery-boys/manage-cash') ?>" class="menu-link">
                                <div data-i18n="Layouts">Manage Cash Collection</div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>


        <!-- Payment Requests -->
        <?php if (has_permissions('read', 'return_request')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/payment-request')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/payment-request') ?>" class="menu-link">
                    <i class="ion-icon-cash-outline"></i>
                    <div data-i18n="Layouts">Payment Requests</div>
                </a>
            </li>
        <?php } ?>

        <!-- Send notification -->
        <?php if (has_permissions('read', 'send_notification')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/Notification-settings/manage-notifications')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/Notification-settings/manage-notifications') ?>" class="menu-link">
                    <i class="ion-icon-paper-plane-outline"></i>
                    <div data-i18n="Layouts">Send Notification</div>
                </a>
            </li>
        <?php } ?>

        <!-- Custom message -->
        <?php if (has_permissions('read', 'settings')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/custom_notification')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/custom_notification') ?>" class="menu-link">
                    <i class="ion-icon-notifications-outline"></i>
                    <div data-i18n="Layouts">Custom message</div>
                </a>
            </li>
        <?php } ?>


        <!-- System -->
        <?php if (has_permissions('read', 'media')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/Setting/system_page') || ($current_url == base_url('admin/setting') || $current_url == base_url('admin/email-settings') || $current_url == base_url('admin/payment-settings') || $current_url == base_url('admin/shipping-settings') || $current_url == base_url('admin/time-slots') || $current_url == base_url('admin/notification-settings') || $current_url == base_url('admin/contact-us') || $current_url == base_url('admin/about-us') || $current_url == base_url('admin/privacy-policy') || $current_url == base_url('admin/privacy-policy/return-policy') || $current_url == base_url('admin/privacy-policy/shipping-policy') || $current_url == base_url('admin/admin-privacy-policy') || $current_url == base_url('admin/delivery-boy-privacy-policy') || $current_url == base_url('admin/client-api-keys') || $current_url == base_url('admin/updater') || $current_url == base_url('admin/purchase-code'))) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/Setting/system_page/') ?>" class="menu-link">
                    <i class="ion-icon-cog-outline"></i>
                    <div data-i18n="Without menu">System</div>
                </a>
            </li>
        <?php } ?>

        <!-- web setting -->
        <li class="menu-item <?= $current_url == base_url('admin/Web_setting/web_settings_page') || ($current_url == base_url('admin/web-setting') || $current_url == base_url('admin/themes') || $current_url == base_url('admin/language') || $current_url == base_url('admin/web-setting/firebase')) ? 'active ' : '' ?>">
            <a href="<?= base_url('admin/Web_setting/web_settings_page/') ?>" class="menu-link">
                <i class="ion-icon-earth-outline"></i>
                <div data-i18n="Layouts">Web Settings</div>
            </a>

        </li>

        <!-- pickup location -->
        <?php if (has_permissions('read', 'pickup_location')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/Pickup_location/manage-pickup-locations')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/Pickup_location/manage-pickup-locations') ?>" class="menu-link">
                    <i class="ion-icon-car-sport-outline"></i>
                    <div data-i18n="Layouts">Pickup Location</div>
                </a>
            </li>
        <?php } ?>
        <!-- Location -->
        <?php if (has_permissions('read', 'area') || has_permissions('read', 'city') || has_permissions('read', 'zipcodes')) { ?>
            <li class="menu-item  <?= ($current_url == base_url('admin/area/manage-zipcodes') || $current_url == base_url('admin/area/manage-cities') || $current_url == base_url('admin/area/manage-areas') || $current_url == base_url('admin/area/manage_countries') || $current_url == base_url('admin/area/location-bulk-upload')) ? 'active open' : '' ?>">
                <a href="#" class="menu-link menu-toggle">
                    <i class="ion-icon-location-outline"></i>
                    <div data-i18n="Layouts">Location</div>
                </a>
                <ul class="menu-sub">
                    <?php if (has_permissions('read', 'zipcodes')) { ?>
                        <li class="menu-item <?= ($current_url == base_url('admin/area/manage-zipcodes')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/area/manage-zipcodes') ?>" class="menu-link">

                                <div data-i18n="Layouts">Zipcodes</div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (has_permissions('read', 'city')) { ?>
                        <li class="menu-item  <?= ($current_url == base_url('admin/area/manage-cities')) ? 'active' : '' ?> ">
                            <a href="<?= base_url('admin/area/manage-cities') ?>" class="menu-link">

                                <div data-i18n="Layouts">City</div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (has_permissions('read', 'area')) { ?>
                        <li class="menu-item  <?= ($current_url == base_url('admin/area/manage-areas')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/area/manage-areas') ?>" class="menu-link">

                                <div data-i18n="Layouts">Areas</div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (has_permissions('read', 'area')) { ?>
                        <li class="menu-item  <?= ($current_url == base_url('admin/area/manage_countries')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/area/manage_countries') ?>" class="menu-link">

                                <div data-i18n="Layouts">Countries</div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (has_permissions('read', 'area') && has_permissions('read', 'city') && has_permissions('read', 'zipcodes')) { ?>
                        <li class="menu-item  <?= ($current_url == base_url('admin/area/location-bulk-upload')) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/area/location-bulk-upload') ?>" class="menu-link">

                                <div data-i18n="Layouts">Bulk Upload </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <!-- Reports -->
        <li class="menu-item <?= ($current_url == base_url('admin/invoice/sales-invoice') || $current_url == base_url('admin/invoice/inventory-report')) ? 'active open' : '' ?>">
            <a href="#" class="menu-link menu-toggle">
                <i class="ion-icon-pie-chart-outline"></i>
                <div data-i18n="Layouts">Reports</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($current_url == base_url('admin/invoice/sales-invoice')) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/invoice/sales-invoice') ?>" class="menu-link">
                        <div data-i18n="Layouts">Sales Report</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == base_url('admin/invoice/inventory-report')) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/invoice/inventory-report') ?>" class="menu-link">
                        <div data-i18n="Layouts">Inventory Report</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- FAQ -->
        <?php if (has_permissions('read', 'faq')) { ?>
            <li class="menu-item <?= ($current_url == base_url('admin/faq')) ? 'active' : '' ?>">
                <a href="<?= base_url('admin/faq/') ?>" class="menu-link">
                    <i class="ion-icon-help-circle-outline"></i>
                    <div data-i18n="Layouts">FAQ</div>
                </a>
            </li>
            <?php }
        $userData = get_user_permissions($this->session->userdata('user_id'));
        if (!empty($userData)) {
            if ($userData[0]['role'] == 0 || $userData[0]['role'] == 1) {
            ?>
                <!-- System users -->
                <li class="menu-item <?= ($current_url == base_url('admin/system-users')) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/system-users/') ?>" class="menu-link">
                        <i class="ion-icon-person-circle-outline"></i>
                        <div data-i18n="Layouts">System Users</div>
                    </a>
                </li>
        <?php
            }
        } ?>
    </ul>


</aside>


<!-- /.sidebar -->
<!-- / Menu -->