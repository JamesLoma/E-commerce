<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Manage Orders</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div id="product_faq_value_id" class="modal fade edit-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-m ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Manage Digital Product</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">

                                </button>
                            </div>

                            <div class="modal-body ">
                                <form class="form-horizontal form-submit-event" action="<?= base_url('admin/orders/send_digital_product'); ?>" method="POST" enctype="multipart/form-data">

                                    <div class="card-body">
                                        <input type="hidden" name="order_id" value="<?= $this->input->get('edit_id') ?>">
                                        <div class="row form-group">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="product_name">Customer Email-ID </label>
                                                    <input type="text" class="form-control" id="email" name="email" value="<?= $fetched[0]['email'] ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="product_name">Message </label>
                                                    <input type="text" class="form-control" id="message" placeholder="Enter Message for email" name="message" value="">
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2" id="digital_media_container">
                                                <label for="image" class="ml-2">File <span class='text-danger text-sm'>*</span></label>
                                                <div class='col-md-6'><a class="uploadFile img btn btn-primary text-white btn-sm" data-input='pro_input_file' data-isremovable='1' data-media_type='archive,document' data-is-multiple-uploads-allowed='0' data-toggle="modal" data-target="#media-upload-modal" value="Upload Photo"><i class='fa fa-upload'></i> Upload</a></div>
                                                <div class="container-fluid row image-upload-section">
                                                    <div class="col-md-6 col-12 shadow p-3 mb-5 bg-white rounded m-4 text-center grow image d-none">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success mt-3" id="submit_btn" value="Save"><?= labels('send_mail', 'Send Mail') ?></button>
                                    </div>
                                </form>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="form-group" id="error_box">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 main-content">
                    <div class="card content-area p-4">
                        <div class="card-innr">
                            <div class="gaps-1-5x row d-flex adjust-items-center">
                                <h5 class="col">Order Outlines</h5>

                                <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label>Date and time range:</label>
                                        <div class="input-group col-md-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="text" class="form-control float-right" id="datepicker">
                                            <input type="hidden" id="start_date" class="form-control float-right">
                                            <input type="hidden" id="end_date" class="form-control float-right">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Filter By payment  -->
                                    <div class="form-group col-md-4">
                                        <div>
                                            <label>Filter By Payment Method</label>
                                            <select id="payment_method" name="payment_method" placeholder="Select Payment Method" required="" class="form-control">
                                                <option value="">All Payment Methods</option>
                                                <option value="Paypal">Paypal</option>
                                                <option value="RazorPay">RazorPay</option>
                                                <option value="Paystack">Paystack</option>
                                                <option value="Flutterwave">Flutterwave</option>
                                                <option value="Paytm">Paytm</option>
                                                <option value="Stripe">Stripe</option>
                                                <option value="bank_transfer">Direct Bank Transfers</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 d-flex align-items-center pt-4">
                                        <button type="button" class="btn btn-outline-primary btn-sm text-primary" onclick="status_date_wise_search()">Filter</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <input type='hidden' id='order_user_id' value='<?= (isset($_GET['user_id']) && !empty($_GET['user_id'])) ? $_GET['user_id'] : '' ?>'>
                        <input type='hidden' id='order_seller_id' value='<?= (isset($_GET['seller_id']) && !empty($_GET['seller_id'])) ? $_GET['seller_id'] : '' ?>'>
                        <div class="row col-md-6">
                            <div class="row col-md-4 pull-right">
                                <a href="#" class="btn btn-primary btn-sm add_promo_code_discount" title="If you found Promo Code Discount not crediting using cron job you can update Promo Code Discount from here!">Settle Promo Code Discount</a>
                            </div>
                        </div>
                        <hr>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#orders_table">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#order_items_table">Order Items</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="orders_table" class="tab-pane active"><br>
                                <table class='table-striped' data-toggle="table" data-url="<?= base_url('admin/orders/view_digital_product_orders') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="o.id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel","csv"]' data-export-options='{"fileName": "orders-list","ignoreColumn": ["state"] }' data-query-params="orders_query_params">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable='true' data-footer-formatter="totalFormatter">Order ID</th>
                                            <th data-field="user_id" data-sortable='true' data-visible="false">User ID</th>
                                            <th data-field="qty" data-sortable='true' data-visible="false">Qty</th>
                                            <th data-field="name" data-sortable='true'>User Name</th>
                                            <th data-field="sellers" data-sortable='true'>Sellers</th>
                                            <th data-field="mobile" data-sortable='true' data-visible='false'>Mobile</th>
                                            <th data-field="notes" data-sortable='false' data-visible='false'>O. Notes</th>
                                            <th data-field="items" data-sortable='true' data-visible="false">Items</th>
                                            <th data-field="total" data-sortable='true' data-visible="true">Total(<?= $curreny ?>)</th>
                                            <th data-field="delivery_charge" data-sortable='true' data-footer-formatter="delivery_chargeFormatter">D.Charge</th>
                                            <th data-field="wallet_balance" data-sortable='true' data-visible="true">Wallet Used(<?= $curreny ?>)</th>
                                            <th data-field="promo_code" data-sortable='true' data-visible="false">Promo Code</th>
                                            <th data-field="promo_discount" data-sortable='true' data-visible="true">Promo disc.(<?= $curreny ?>)</th>
                                            <!-- <th data-field="discount" data-sortable='true' data-visible="true">Discount <?= $curreny ?>(%)</th> -->
                                            <th data-field="final_total" data-sortable='true'>Final Total(<?= $curreny ?>)</th>
                                            <th data-field="payment_method" data-sortable='true' data-visible="true">Payment Method</th>
                                            <th data-field="address" data-sortable='true' data-visible='false'>Address</th>
                                            <th data-field="delivery_date" data-sortable='true' data-visible='false'>Delivery Date</th>
                                            <th data-field="delivery_time" data-sortable='true' data-visible='false'>Delivery Time</th>
                                            <th data-field="date_added" data-sortable='true'>Order Date</th>
                                            <th data-field="operate">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div id="order_items_table" class="tab-pane fade"><br>
                                <table class='table-striped' data-toggle="table" data-url="<?= base_url('admin/orders/view_digital_product_order_items') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="oi.id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel","csv"]' data-export-options='{"fileName": "order-item-list","ignoreColumn": ["state"] }' data-query-params="orders_query_params">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable='true' data-footer-formatter="totalFormatter">ID</th>
                                            <th data-field="order_item_id" data-sortable='true'>Order Item ID</th>
                                            <th data-field="order_id" data-sortable='true'>Order ID</th>
                                            <th data-field="user_id" data-sortable='true' data-visible="false">User ID</th>
                                            <th data-field="seller_id" data-sortable='true' data-visible="false">Seller ID</th>
                                            <th data-field="is_credited" data-sortable='true' data-visible="false">Commission</th>
                                            <th data-field="quantity" data-sortable='true' data-visible="false">Quantity</th>
                                            <th data-field="username" data-sortable='true'>User Name</th>
                                            <th data-field="seller_name" data-sortable='true'>Seller Name</th>
                                            <th data-field="product_name" data-sortable='true'>Product Name</th>
                                            <th data-field="mobile" data-sortable='true' data-visible='false'>Mobile</th>
                                            <th data-field="sub_total" data-sortable='true' data-visible="true">Total(<?= $curreny ?>)</th>
                                            <th data-field="delivery_boy" data-sortable='true' data-visible='false'>Deliver By</th>
                                            <th data-field="delivery_boy_id" data-sortable='true' data-visible='false'>Delivery Boy Id</th>
                                            <th data-field="product_variant_id" data-sortable='true' data-visible='false'>Product Variant Id</th>
                                            <th data-field="delivery_date" data-sortable='true' data-visible='false'>Delivery Date</th>
                                            <th data-field="delivery_time" data-sortable='true' data-visible='false'>Delivery Time</th>
                                            <th data-field="updated_by" data-sortable='true' data-visible="true">Updated by</th>
                                            <th data-field="status" data-sortable='true' data-visible='false'>Status</th>
                                            <th data-field="active_status" data-sortable='true' data-visible='true'>Active Status</th>
                                            <th data-field="date_added" data-sortable='true'>Order Date</th>
                                            <th data-field="operate">Action</th>
                                            <th data-field="send_mail">Send Mail</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                    </div><!-- .card-innr -->
                </div><!-- .card -->
            </div>
        </div>
        <!-- /.row -->
</div><!-- /.container-fluid -->

</section>
<!-- /.content -->
</div>