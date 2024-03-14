<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-2">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h4>System Settings</h4>
                </div>
                <div class="col-sm-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active">System settings</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <div class="container-fluid">
            <div class="row">

                <form class="form-horizontal form-submit-event" action="<?= base_url('admin/setting/update_system_settings') ?>" method="POST" id="system_setting_form" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-md-8 ">

                                <div class="card">
                                    <b class="m-2">
                                        System Settings
                                    </b>
                                    <hr>

                                    <input type="hidden" id="system_configurations" name="system_configurations" required="" value="1" aria-required="true">
                                    <input type="hidden" id="system_timezone_gmt" name="system_timezone_gmt" value="<?= (isset($settings['system_timezone_gmt']) && !empty($settings['system_timezone_gmt'])) ? $settings['system_timezone_gmt'] : '+05:30'; ?>" aria-required="true">
                                    <input type="hidden" id="system_configurations_id" name="system_configurations_id" value="13" aria-required="true">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class="mb-2" for="app_name">App Name <span class='text-danger text-xs'>*</span></label>
                                                <input type="text" class="form-control mb-2" name="app_name" value="<?= (isset($settings['app_name'])) ? $settings['app_name'] : '' ?>" placeholder="Name of the App - used in whole system" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="mb-2" for="support_number">Support Number <span class='text-danger text-xs'>*</span></label>
                                                <input type="number" class="form-control mb-2" name="support_number" value="<?= (isset($settings['support_number'])) ? $settings['support_number'] : '' ?>" placeholder="Customer support mobile number - used in whole system" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="mb-2" for="support_email">Support Email <span class='text-danger text-xs'>*</span></label>
                                                <input type="text" class="form-control mb-2" name="support_email" value="<?= (isset($settings['support_email'])) ? $settings['support_email'] : '' ?>" placeholder="Customer support email - used in whole system" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="mb-2" class="system_timezone" for="system_timezone">System Timezone <span class='text-danger text-xs'>*</span></label>
                                                <select id="system_timezone" name="system_timezone" required class="form-control col-md-12">
                                                    <option value=" ">--Select Timezones--</option>
                                                    <?php
                                                    foreach ($timezone as $zone) {
                                                        $checked = (isset($settings['system_timezone']) &&  $settings['system_timezone'] == $zone[2])  ? 'selected' : '';
                                                    ?>
                                                        <option value="<?= $zone[2] ?>" <?= $checked ?> data-gmt="<?= $zone[1] ?>"><?= $zone[0] . ' - GMT ' . $zone[1] . ' - ' . $zone[2] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="mb-2" for="tax_name">Tax Name <small>( This will be visible on your invoice )</small></label>
                                                <input type="text" class="form-control mb-2" name="tax_name" value="<?= (isset($settings['tax_name'])) ? $settings['tax_name'] : '' ?>" placeholder='Example : GST Number / VAT / TIN Number' />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="mb-2" for="tax_number">Tax Number </label>
                                                <input type="text" class="form-control mb-2" name="tax_number" value="<?= (isset($settings['tax_number'])) ? $settings['tax_number'] : '' ?>" placeholder='Example : GSTIN240000120' />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="mb-2" for="max_items_cart"> Low stock limit <small>(Product will be considered as low stock)</small>
                                                    <!-- <a type="button" data-toggle="tooltip" data-placement="top" title=" Below this user will be charged based on Delivery Charge">
                                         <i class="fas fa-info-circle"></i></a>
                                         <button type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Tooltip on top">Tooltip : Top</button> -->
                                                </label>
                                                <input type="number" min="0" class="form-control mb-2" name="low_stock_limit" value="<?= (isset($settings['low_stock_limit'])) ? $settings['low_stock_limit'] : '5' ?>" placeholder='Product low stock limit' min='1' />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="mb-2" for="address"> Address <span class='text-danger text-xs'>*</span></label>
                                                <textarea type="text" class="form-control mb-2" id="address" placeholder="Address" name="address"><?= isset($settings['address']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $settings['address'])) : ""; ?></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="mb-2" for="latitude">Latitude <span class='text-danger text-xs'>*</span></label>
                                                <input type="text" class="form-control mb-2" name="latitude" value="<?= (isset($settings['latitude'])) ? $settings['latitude'] : '' ?>" placeholder="Latitude" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="mb-2" for="longitude">Longitude <span class='text-danger text-xs'>*</span></label>
                                                <input type="text" class="form-control mb-2" name="longitude" value="<?= (isset($settings['longitude'])) ? $settings['longitude'] : '' ?>" placeholder="Longitude" />
                                            </div>

                                            <div class="form-group col-md-6 ml-1">
                                                <label class="mb-2" for="">Max days to return item</label>
                                                <input type="number" min="0" class="form-control mb-2" name="max_product_return_days" value="<?= (isset($settings['max_product_return_days'])) ? $settings['max_product_return_days'] : '' ?>" placeholder='Max days to return item' />
                                            </div>

                                            <div class="form-group col-md-6 ">
                                                <label class="mb-2" for="minimum_cart_amt">Minimum Cart Amount(<?= $currency ?>) <span class='text-danger text-xs'>*</span>
                                                    <!-- <a type="button" data-toggle="tooltip" data-placement="top" title=" Below this user will be charged based on Delivery Charge"> -->
                                                    <!-- <i class="fas fa-info-circle"></i></a> -->
                                                    <!-- <button type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Tooltip on top">Tooltip : Top</button> -->
                                                </label>
                                                <input type="number" min="0" class="form-control mb-2" name="minimum_cart_amt" value="<?= (isset($settings['minimum_cart_amt'])) ? $settings['minimum_cart_amt'] : '' ?>" placeholder='Minimum Cart Amount' min='0' />
                                            </div>

                                            <div class="form-group col-md-6 ml-1">
                                                <label class="mb-2" for="max_items_cart"> Maximum Items Allowed In Cart <span class='text-danger text-xs'>*</span>
                                                    <!-- <a type="button" data-toggle="tooltip" data-placement="top" title=" Below this user will be charged based on Delivery Charge">
                                         <i class="fas fa-info-circle"></i></a>
                                         <button type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Tooltip on top">Tooltip : Top</button> -->
                                                </label>
                                                <input type="number" min="0" class="form-control mb-2" name="max_items_cart" value="<?= (isset($settings['max_items_cart'])) ? $settings['max_items_cart'] : '' ?>" placeholder='Maximum Items Allowed In Cart' min='0' />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-4 ">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="row">
                                            <b>
                                                Logo & Other Settings
                                            </b>
                                            <hr>
                                            <div class="col-md-12 form-group">
                                                <div class="col-md-12 form-group mt-4">
                                                    <b>Logo</b>
                                                    <div class="d-flex ">
                                                        <div class='col-md-8 border refer_and_earn_border'><a class="" data-input='logo' data-isremovable='0' data-is-multiple-uploads-allowed='0' data-toggle="modal" data-target="#media-upload-modal" value="Upload Photo"><i class='bx bx-image-add box-icon-height'></i> </a> <br><b>Drop your image here, or</b> browse<br> Larger than 120x120 & smaller than 150x150<br></div>
                                                        <?php
                                                        if (!empty($logo)) {
                                                        ?>

                                                            <div class=" image-upload-section store_settings">
                                                                <div class='upload-media-div shadow mx-2 bg-white rounded  text-center grow image'><img class="img-fluid " src="<?= BASE_URL() . $logo ?>" alt="Image Not Found"></div>
                                                                <input type="hidden" name="logo" id='logo' value='<?= $logo ?>'>
                                                            </div>
                                                        <?php
                                                        } else { ?>
                                                            <div class="container-fluid row image-upload-section">
                                                                <div class="">
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 form-group mt-4">
                                                    <b>Favicon</b>
                                                    <div class="d-flex ">
                                                        <div class='col-md-8 border refer_and_earn_border'><a class="" data-input='favicon' data-isremovable='0' data-is-multiple-uploads-allowed='0' data-toggle="modal" data-target="#media-upload-modal" value="Upload Photo"><i class='bx bx-image-add box-icon-height'></i> </a> <br><b>Drop your image here, or</b> browse<br> Larger than 120x120 & smaller than 150x150<br></div>
                                                        <?php
                                                        if (!empty($favicon)) {
                                                        ?>

                                                            <div class=" image-upload-section store_settings col-md-4">


                                                                <div class='upload-media-div shadow mx-2 bg-white rounded  text-center grow image'><img class="img-fluid " src="<?= BASE_URL() . $favicon ?>" alt="Image Not Found"></div>
                                                                <input type="hidden" name="favicon" id='favicon' value='<?= $favicon ?>'>


                                                            </div>
                                                        <?php
                                                        } else { ?>
                                                            <div class="container-fluid row image-upload-section">
                                                                <div class="">
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12 d-flex justify-content-between mt-5">
                                                    <label class="mb-2" for="cart_btn_on_list"> Enable Cart Button on Products List view? </label>
                                                    <div class="">

                                                        <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="cart_btn_on_list" <?= (isset($settings['cart_btn_on_list']) && $settings['cart_btn_on_list'] == '1') ? 'Checked' : ''  ?> /></a>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12 d-flex justify-content-between mt-5">
                                                    <div class="row">
                                                        <label class="mb-2" for="expand_product_images"> Expand Product Images? </label>
                                                        <small>Image will be stretched in the product image boxes</small>
                                                    </div>

                                                    <div class="">


                                                        <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="expand_product_images" <?= (isset($settings['expand_product_images']) && $settings['expand_product_images'] == '1') ? 'Checked' : ''  ?> /></a>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12 d-flex justify-content-between mt-4">
                                                    <label class="mb-2" for="local_pickup"> Enable Local / Store Pickup ? </label>
                                                    <?php if (isset($shiprocket_settings['local_shipping_method']) && $shiprocket_settings['local_shipping_method'] == 1) { ?>
                                                        <div class="">
                                                            <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="local_pickup" <?= (isset($settings['local_pickup']) && $settings['local_pickup'] == '1') ? 'Checked' : ''  ?> /></a>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="">
                                                            <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"><input type="checkbox" name="local_pickup" class="form-check-input " role="switch" disabled></a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--/.card-->
                        </div>
                    </div>

                    <div class="col-md-12  mt-4">
                        <div class="row">

                            <div class="col-md-8 ">
                                <div class="card card-body">
                                    <b class="m-2">
                                        Delivery Settings
                                    </b>
                                    <hr>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php $class = isset($settings['area_wise_delivery_charge']) && $settings['area_wise_delivery_charge'] == '1' ? 'col-md-12' : 'col-md-12' ?>
                                            <div>
                                                <div class="form-group area_wise_delivery_charge d-flex justify-content-between <?= $class ?>">
                                                    <label class="mb-2" for="area_wise_delivery_charge">Area Wise Delivery Charge <small>( Enable / Disable )</small></label>



                                                    <input type="checkbox" class="form-check-input" id="area_wise_delivery_charge" value="area_wise_delivery_charge" role="switch" name="area_wise_delivery_charge" <?= (isset($settings['area_wise_delivery_charge']) && $settings['area_wise_delivery_charge'] == '1') ? 'Checked' : '' ?> data-bootstrap-switch />






                                                </div>
                                            </div>

                                            <?php $d_none = isset($settings['area_wise_delivery_charge']) && $settings['area_wise_delivery_charge'] == '1' ? 'd-none' : '' ?>
                                            <div class="form-group col-md-6 delivery_charge <?= $d_none ?>">
                                                <label class="mb-2" for="delivery_charge">Delivery Charge Amount (<?= $currency ?>) <span class='text-danger text-xs'>*</span></label>
                                                <input type="number" min="0" class="form-control mb-2" name="delivery_charge" value="<?= (isset($settings['delivery_charge'])) ? $settings['delivery_charge'] : '' ?>" placeholder='Delivery Charge on Shopping' min='0' />
                                            </div>
                                            <div class="form-group col-md-6 min_amount <?= $d_none ?>">
                                                <label class="mb-2" for="min_amount">Minimum Amount for Free Delivery (<?= $currency ?>) <span class='text-danger text-xs'>*</span>
                                                </label>
                                                <input type="number" min="0" class="form-control mb-2" name="min_amount" value="<?= (isset($settings['min_amount'])) ? $settings['min_amount'] : ''  ?>" placeholder='Minimum Order Amount for Free Delivery' min='0' />
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label class="mb-2" for="">Delivery Boy Bonus (%)</label>
                                                <input type="number" min="0" class="form-control mb-2" name="delivery_boy_bonus_percentage" value="<?= (isset($settings['delivery_boy_bonus_percentage'])) ? $settings['delivery_boy_bonus_percentage'] : '' ?>" placeholder='Delivery Boy Bonus' />
                                            </div>
                                            <div class="form-group col-md-6 mt-5 d-flex justify-content-between">
                                                <label class="mb-2" for="is_delivery_boy_otp_setting_on"> Order Delivery OTP System
                                                </label>



                                                <a class=" form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="is_delivery_boy_otp_setting_on" <?= (isset($settings['is_delivery_boy_otp_setting_on']) && $settings['is_delivery_boy_otp_setting_on'] == '1') ? 'Checked' : ''  ?> /></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 ">
                                <div class="card card-body">

                                    <div class="row">

                                        <div class="col-md-12 form-group">
                                            <b class="m-2">
                                                Application Versions
                                            </b>
                                            <hr>

                                            <div class="form-group col-md-12 d-flex justify-content-between mt-3">

                                                <label class="mb-2" for="is_version_system_on">Version System Status </label>
                                                <div class="">


                                                    <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="is_version_system_on" <?= (isset($settings['is_version_system_on']) && $settings['is_version_system_on'] == '1') ? 'Checked' : '' ?> /></a>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <labelclass="mb-2" for="current_version">Current Version Of Android APP <span class='text-danger text-xs'>*</span></label>
                                                    <input type="text" class="form-control mb-2" name="current_version" value="<?= (isset($settings['current_version'])) ? $settings['current_version'] : '' ?>" placeholder='Current For Version For Android APP' />
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="mb-2" for="current_version">Current Version Of IOS APP <span class='text-danger text-xs'>*</span></label>
                                                <input type="text" class="form-control mb-2" name="current_version_ios" value="<?= (isset($settings['current_version_ios'])) ? $settings['current_version_ios'] : '' ?>" placeholder='Current Version For IOS APP' />
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="card card-body">
                                    <b class="m-2">
                                        Refer & Earn Settings
                                    </b>
                                    <hr>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-4 d-flex justify-content-between mt-5">
                                                <label class="mb-2" for="is_refer_earn_on"> Refer & Earn Status? </label>
                                                <div class="">


                                                    <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="is_refer_earn_on" <?= (isset($settings['is_refer_earn_on']) && $settings['is_refer_earn_on'] == '1') ? 'Checked' : ''  ?> /></a>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4 mt-3">
                                                <label class="mb-2" for="refer_earn_method">Refer & Earn Method </label>
                                                <select name="refer_earn_method" class="form-control mb-2">
                                                    <option value="">Select</option>
                                                    <option value="percentage" <?= (isset($settings['refer_earn_method']) && $settings['refer_earn_method'] == "percentage") ? "selected" : "" ?>>Percentage</option>
                                                    <option value="amount" <?= (isset($settings['refer_earn_method']) && $settings['refer_earn_method'] == "amount") ? "selected" : "" ?>>Amount</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 mt-3">
                                                <label class="mb-2" for="min_refer_earn_order_amount"> Minimum Refer & Earn Order Amount (<?= $currency ?>) </label>
                                                <input type="text" name="min_refer_earn_order_amount" class="form-control mb-2" value="<?= (isset($settings['min_refer_earn_order_amount']) && $settings['min_refer_earn_order_amount'] != '') ? $settings['min_refer_earn_order_amount'] : ''  ?>" placeholder="Amount of order eligible for bonus" />
                                            </div>

                                            <div class="form-group col-md-4 mt-4">
                                                <label class="mb-2" for="refer_earn_bonus">Refer & Earn Bonus (<?= $currency ?> OR %)</label>
                                                <input type="text" class="form-control mb-2" name="refer_earn_bonus" value="<?= (isset($settings['refer_earn_bonus'])) ? $settings['refer_earn_bonus'] : '' ?>" placeholder='In amount or percentages' />
                                            </div>

                                            <div class="form-group col-md-4 mt-4">
                                                <label class="mb-2" for="max_refer_earn_amount">Maximum Refer & Earn Amount (<?= $currency ?>)</label>
                                                <input type="text" class="form-control mb-2" name="max_refer_earn_amount" value="<?= (isset($settings['max_refer_earn_amount'])) ? $settings['max_refer_earn_amount'] : '' ?>" placeholder='Maximum Refer & Earn Bonus Amount' />
                                            </div>

                                            <div class="form-group col-md-4 mt-4">
                                                <label class="mb-2" for="refer_earn_bonus_times">Number of times Bonus to be given to the cusomer</label>
                                                <input type="text" class="form-control mb-2" name="refer_earn_bonus_times" value="<?= (isset($settings['refer_earn_bonus_times'])) ? $settings['refer_earn_bonus_times'] : '' ?>" placeholder='No of times customer will get bonus' />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="row">

                            <div class="col-md-4 ">
                                <div class="card card-body">

                                    <div class="row">

                                        <div class="col-md-12 form-group">
                                            <b class="m-2">
                                                Country Currency
                                            </b>
                                            <hr>

                                            <div class="form-group col-md-12">
                                                <label class="mb-2" for="supported_locals">Country Currency Code</label>
                                                <select name="supported_locals" class="form-control mb-2">
                                                    <?php
                                                    $CI = &get_instance();
                                                    $CI->config->load('eshop');
                                                    $supported_methods = $CI->config->item('supported_locales_list');
                                                    foreach ($supported_methods as $key => $value) {
                                                        $text = "$key - $value "; ?>
                                                        <option value="<?= $key ?>" <?= (isset($settings['supported_locals']) && !empty($settings['supported_locals']) && $key == $settings['supported_locals']) ? "selected" : "" ?>><?= $key . ' - ' . $value ?></option>
                                                    <?php  }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-12 mt-4">
                                                <label class="mb-2" for="currency">Store Currency ( Symbol or Code - $ or USD - Anyone ) <span class='text-danger text-xs'>*</span></label>
                                                <input type="text" class="form-control mb-2" name="currency" value="<?= (isset($settings['currency'])) ? $settings['currency'] : '' ?>" placeholder="Either Symbol or Code - For Example $ or USD" />
                                            </div>



                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="col-md-4 ">
                                <div class=" card card-body">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-12 form-group">
                                                <b class="m-2">
                                                    Welcome Wallet Balance </b>
                                                <hr>

                                                <div class="form-group col-md-12 d-flex justify-content-between">
                                                    <label class="mb-2" for="welcome_wallet_balance_on"> Wallet Balance Status? </label>
                                                    <div class="">

                                                        <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="welcome_wallet_balance_on" <?= (isset($settings['welcome_wallet_balance_on']) && $settings['welcome_wallet_balance_on'] == '1') ? 'Checked' : ''  ?> /></a>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12 mt-3">
                                                    <label class="mb-2" for="wallet_balance_amount"> Wallet Balance Amount (<?= $currency ?>) </label>
                                                    <input type="text" name="wallet_balance_amount" class="form-control mb-2" value="<?= (isset($settings['wallet_balance_amount']) && $settings['wallet_balance_amount'] != '') ? $settings['wallet_balance_amount'] : ''  ?>" placeholder="Amount of Welcome Wallet Balance" />
                                                </div>



                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="col-md-4 ">
                                <div class="card card-body">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-12 form-group">
                                                <b class="m-2">
                                                    Upload Other Attachments </b>
                                                <hr>

                                                <div class="form-group col-md-12 d-flex justify-content-between">
                                                    <label class="mb-2" for="allow_order_attachments"> Allow Upload Order Attachment? </label>
                                                    <div class="">

                                                        <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="allow_order_attachments" <?= (isset($settings['allow_order_attachments']) && $settings['allow_order_attachments'] == '1') ? 'Checked' : ''  ?> /></a>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12 mt-3">
                                                    <label class="mb-2" for="upload_limit"> Maximum upload limit </label>
                                                    <input type="number" min="0" name="upload_limit" min="1" class="form-control mb-2" value="<?= (isset($settings['upload_limit']) && $settings['upload_limit'] != '') ? $settings['upload_limit'] : ''  ?>" max="10" placeholder="Maximum upload limit" />
                                                </div>



                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12 mt-4">

                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="card card-body">

                                    <b class="m-2">
                                        Maintenance Mode
                                    </b>

                                    <p class="text-danger"> [ If you enable Maintenance Mode of App then your App will be "Under Maintenance" ] </p>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <b class="m-2">
                                                Customer App
                                            </b>
                                            <hr>

                                            <div class="form-group col-md-12">
                                                <div class="d-flex justify-content-between">
                                                    <label class="mb-2" for="is_customer_app_under_maintenance"> Customer App</label>
                                                    <div class="">


                                                        <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="is_customer_app_under_maintenance" <?= (isset($settings['is_customer_app_under_maintenance']) && $settings['is_customer_app_under_maintenance'] == '1') ? 'Checked' : ''  ?> /></a>
                                                    </div>
                                                </div>
                                                <label class="mb-2 mt-4" for="message_for_customer_app"> Message for Customer App</label>
                                                <div class="card-body p-0">
                                                    <textarea type="text" class="form-control mb-2" id="message_for_customer_app" placeholder="Message for Customer App" name="message_for_customer_app"><?= isset($settings['message_for_customer_app']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $settings['message_for_customer_app'])) : ""; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <b class="m-2">
                                                Delivery Boy App</b>
                                            <hr>
                                            <div class="form-group col-md-12">
                                                <div class="d-flex justify-content-between">
                                                    <label class="mb-2" for="is_delivery_boy_app_under_maintenance"> Delivery boy App</label>
                                                    <div class="">

                                                        <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="is_delivery_boy_app_under_maintenance" <?= (isset($settings['is_delivery_boy_app_under_maintenance']) && $settings['is_delivery_boy_app_under_maintenance'] == '1') ? 'Checked' : ''  ?> /></a>
                                                    </div>
                                                </div>
                                                <label class="mb-2 mt-4" for="message_for_delivery_boy_app"> Message for Delivery boy App</label>
                                                <div class="card-body p-0">
                                                    <textarea type="text" class="form-control mb-2" id="message_for_delivery_boy_app" placeholder="Message for Delivery boy App" name="message_for_delivery_boy_app"><?= isset($settings['message_for_delivery_boy_app']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $settings['message_for_delivery_boy_app'])) : ""; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mt-5">
                                            <b class="m-2">
                                                Admin App</b>
                                            <hr>

                                            <div class="form-group col-md-12">
                                                <div class="d-flex justify-content-between">
                                                    <label class="mb-2" for="is_admin_app_under_maintenance"> Admin App</label>
                                                    <div class="">

                                                        <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="is_admin_app_under_maintenance" <?= (isset($settings['is_admin_app_under_maintenance']) && $settings['is_admin_app_under_maintenance'] == '1') ? 'Checked' : ''  ?> /></a>
                                                    </div>
                                                </div>
                                                <label class="mb-2 mt-4" for="message_for_admin_app"> Message for Admin App</label>
                                                <div class="card-body p-0">
                                                    <textarea type="text" class="form-control mb-2" id="message_for_admin_app" placeholder="Message for Admin App" name="message_for_admin_app"><?= isset($settings['message_for_admin_app']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $settings['message_for_admin_app'])) : ""; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mt-5">
                                            <b class="m-2">
                                                Web maintenance mode</b>
                                            <hr>


                                            <div class="form-group col-md-12">
                                                <div class="d-flex justify-content-between">
                                                    <label class="mb-2" for="is_web_under_maintenance"> Web maintenance mode</label>
                                                    <div class="">


                                                        <a class="toggle form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="is_web_under_maintenance" <?= (isset($settings['is_web_under_maintenance']) && $settings['is_web_under_maintenance'] == '1') ? 'Checked' : ''  ?> /></a>
                                                    </div>
                                                </div>
                                                <label class="mb-2 mt-4" for="message_for_web"> Message for Web maintenance mode </label>
                                                <div class="card-body p-0">
                                                    <textarea type="text" class="form-control mb-2" id="message_for_web" placeholder="Message for Web maintenance mode" name="message_for_web"><?= isset($settings['message_for_web']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $settings['message_for_web'])) : ""; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="col-md-12 mt-4">

                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="card card-body">



                                    <h3 class="m2"> Cron URL for Discount Codes </h3>
                                    <hr>
                                    <div class="row">

                                        <div class="form-group col-md-6">
                                            <div class="col-md-12 d-flex justify-content-between">
                                                <label class="mb-2 col-md-6" for="app_name">Add Promo Code Discount URL <span class='text-danger text-xs'>*</span> <small>(Set this URL at your server cron job list for "once a day")</small></label>
                                                <a class="btn btn-xs btn-primary text-white" style="height:fit-content" data-toggle="modal" data-target="#howItWorksModal" title="How it works">How Promo Code Discount works?</a>
                                            </div>
                                            <input type="text" class="form-control mb-2" name="app_name" value="<?= base_url('admin/cron_job/settle_cashback_discount') ?>" disabled />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="col-md-12 d-flex justify-content-between">
                                                <label class="mb-2 col-md-6" for="app_name">Add Flash Sale Active/Deactive URL <span class='text-danger text-xs'>*</span> <small>(Set this URL at your server cron job list for "every five minute")</small></label>

                                                <a class="btn btn-xs btn-primary text-white" style="height:fit-content" data-toggle="modal" data-target="#howFlashSaleWorksModal" title="How it works">How Flash Sale works?</a>
                                            </div>
                                            <input type="text" class="form-control mb-2" name="app_name" value="<?= base_url('admin/cron_job/fetch_active_flash_sale') ?>" disabled />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="card card-body">
                                    <b class="m-2">
                                        Offer Popup</b>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-6 d-flex justify-content-between">
                                            <label class="mb-2" for="is_offer_popup_on"> Offer popup? </label>
                                            <a class=" form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="is_offer_popup_on" <?= (isset($settings['is_offer_popup_on']) && $settings['is_offer_popup_on'] == true) ? 'Checked' : ''  ?> /></a>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="mb-2" for="offer_popup_method">Offer popup Method </label>
                                            <select name="offer_popup_method" class="form-control mb-2">
                                                <option value="">Select</option>
                                                <option value="refresh" <?= (isset($settings['offer_popup_method']) && $settings['offer_popup_method'] == "refresh") ? "selected" : "" ?>>Appears upon refresh</option>
                                                <option value="session_storage" <?= (isset($settings['offer_popup_method']) && $settings['offer_popup_method'] == "session_storage") ? "selected" : "" ?>>Appears once</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="card card-body">
                                        <b class="m-2">
                                            Social login ?</b>
                                        <hr>
                                        <div class="row">
                                            <div class="form-group col-md-12 d-flex justify-content-between">
                                                <label class="mb-2" for="social_login"> Google </label>
                                                <a class=" form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="google_login" <?= (isset($settings['google_login']) && $settings['google_login'] == true) ? 'Checked' : ''  ?> /></a>
                                                <label class="mb-2" for="social_login"> Facebook </label>
                                                <a class=" form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="facebook_login" <?= (isset($settings['facebook_login']) && $settings['facebook_login'] == true) ? 'Checked' : ''  ?> /></a>
                                                <label class="mb-2" for="social_login"> Apple </label>
                                                <a class=" form-switch  mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " role="switch" name="apple_login" <?= (isset($settings['apple_login']) && $settings['apple_login'] == true) ? 'Checked' : ''  ?> /></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="card card-body">
                                        <b class="m-2">
                                            Share Whatsapp Number</b>
                                        <hr>
                                        <div class="row">
                                            <div class="form-group col-md-12 d-flex justify-content-between">
                                                <label class="mb-2" for="social_login">Whatsapp</label>
                                                <a class="form-switch mr-1 mb-1" title="Deactivate" href="javascript:void(0)"> <input type="checkbox" class="form-check-input " id="whatsapp_status" role="switch" name="whatsapp_status" <?= (isset($settings['whatsapp_status']) && $settings['whatsapp_status'] == true) ? 'Checked' : ''  ?>/></a>
                                            </div>
                                            <div>
                                                <input type="number" class="form-control <?= (isset($settings['whatsapp_status']) && $settings['whatsapp_status'] == 1) ? '' : 'collapse'  ?>" name="whatsapp_number" id="whatapp_number_input" placeholder="Whatsapp Number" value="<?= isset($settings['whatsapp_number']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $settings['whatsapp_number'])) : ""; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4 d-flex justify-content-end">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary" id="submit_btn">Update Settings</button>
                    </div>
                </form>
                <!--/.col-md-12-->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>