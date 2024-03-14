<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h4> Upload Offer Images </h4>
                </div>
                <div class="col-sm-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Offers</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-info">
                        <form class="form-horizontal form-submit-event" action="<?= base_url('admin/offer/add_offer'); ?>" method="POST" id="payment_setting_form" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">

                                    <?php if (isset($fetched_data[0]['id'])) {
                                    ?>
                                        <input type="hidden" name="edit_offer" value="<?= $fetched_data[0]['id'] ?>">
                                    <?php } ?>
                                    <label for="offer_type ">Select offer type <span class='text-danger text-sm'>*</span> </label>
                                    <select name="main_offer_type" required id="main_offer_type" class="mb-2 form-control type_event_trigger mt-2" required="">
                                        <option value="">Select Type</option>
                                        <option value="offer_slider" <?= (@$fetched_data[0]['type'] == "offer_slider") ? 'selected' : ' ' ?>>Offer Slider</option>
                                        <?php $settings = get_settings('system_settings', true);
                                        // echo "hii2";
                                        // print_R($settings);
                                        if (isset($settings['is_offer_popup_on']) && ($settings['is_offer_popup_on'] == '1')) {
                                        ?>
                                            <option value="popup_offer" <?= (@$fetched_data[0]['type'] == "popup_offer") ? 'selected' : ' ' ?>>Popup Offer</option>
                                        <?php }
                                        ?>
                                    </select>
                                    <label for="offer_type">Type <span class='text-danger text-sm'>*</span> </label>
                                    <select name="offer_type" id="offer_type" required class="form-control type_event_trigger mt-2" required="">
                                        <option value="">Select Type</option>
                                        <option value="default" <?= (@$fetched_data[0]['type'] == "default") ? 'selected' : ' ' ?>>Default</option>
                                        <option value="categories" <?= (@$fetched_data[0]['type'] == "categories") ? 'selected' : ' ' ?>>Category</option>
                                        <option value="all_products" <?= (@$fetched_data[0]['type'] == "all_products") ? 'selected' : ' ' ?>> All Product</option>
                                        <option value="products" <?= (@$fetched_data[0]['type'] == "products") ? 'selected' : ' ' ?>>Specific Product</option>
                                        <option value="brand" <?= (@$fetched_data[0]['type'] == "brand") ? 'selected' : ' ' ?>>Brand</option>
                                        <option id="offer_url" value="offer_url" <?= (@$fetched_data[0]['type'] == "offer_url") ? 'selected' : ' ' ?>>Offer URL</option>
                                    </select>
                                </div>
                                <?php
                                $min_discount = @$fetched_data[0]['min_discount'];
                                $max_discount = @$fetched_data[0]['max_discount'];
                                // print_r(@$fetched_data[0]['min_discount']);
                                // $offer_discount = ['offer_categories', 'offer_all_products'] 
                                ?>
                                <div id="type_add_html">
                                    <?php $hiddenStatus = (isset($fetched_data[0]['id']) && $fetched_data[0]['type']  == 'categories') ? '' : 'd-none' ?>
                                    <div class="form-group slider-categories <?= $hiddenStatus ?> ">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="category_id"> Categories <span class='text-danger text-sm'>*</span></label>
                                                <select id="category_parent" name="category_id">
                                                    <option value=""><?= (isset($categories) && empty($categories)) ? 'No Categories Exist' : 'Select Category' ?>
                                                    </option>
                                                    <?php
                                                    $selected_val = (isset($fetched_data[0]['id']) &&  !empty($fetched_data[0]['id'])) ? $fetched_data[0]['type_id'] : '';
                                                    $selected_vals = explode(',', $selected_val ?? '');
                                                    // echo $selected_vals;
                                                    echo get_categories_option_html($categories, $selected_vals);

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="offer_discount"></div> -->
                                    </div>
                                    <?php $hiddenStatus = (isset($fetched_data[0]['id']) && $fetched_data[0]['type']  == 'products') ? '' : 'd-none' ?>
                                    <div class="form-group row slider-products <?= $hiddenStatus ?>">
                                        <label for="product_id" class="control-label">Products <span class='text-danger text-sm'>*</span></label>
                                        <div class="col-md-12">
                                            <select name="product_id" class="search_offer_product w-100" data-placeholder=" Type to search and select products">
                                                <?php
                                                if (isset($fetched_data[0]['id']) && $fetched_data[0]['type']  == 'products') {
                                                    $product_details = fetch_details('products', ['id' => $fetched_data[0]['type_id']], 'id,name');
                                                    if (!empty($product_details)) {
                                                ?>
                                                        <option value="<?= $product_details[0]['id'] ?>" selected> <?= $product_details[0]['name'] ?></option>
                                                <?php
                                                    }
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php $hiddenStatus = (isset($fetched_data[0]['id']) && $fetched_data[0]['type']  == 'brand') ? '' : 'd-none' ?>
                                    <div class="form-group row slider-brand <?= $hiddenStatus ?>">
                                        <label for="brand_id" class="control-label">Brand <span class='text-danger text-sm'>*</span></label>
                                        <div class="col-md-12">
                                            <select name="brand_id" class="offer_brand_list w-100" data-placeholder=" Type to search and select brand">
                                                <?php
                                                if (isset($fetched_data[0]['id']) && $fetched_data[0]['type']  == 'brand') {
                                                    $product_details = fetch_details('brands', ['id' => $fetched_data[0]['type_id']], 'id,name');
                                                    if (!empty($product_details)) {
                                                ?>
                                                        <option value="<?= $product_details[0]['id'] ?>" selected> <?= $product_details[0]['name'] ?></option>
                                                <?php
                                                    }
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php $hiddenStatus = (isset($fetched_data[0]['id']) && $fetched_data[0]['type']  == 'all_products') ? '' : 'd-none' ?>
                                    <div class="form-group all_products <?= $hiddenStatus ?> ">
                                        <!-- <div class="offer_discount"></div> -->
                                    </div>
                                </div>

                                <div class="form-group row offer_discount d-none" id="min_max_section">
                                    <div class="form-group col-md-6">
                                        <label for="">Minimum offer Discount(%) <span class='text-danger text-sm'>*</span></label>
                                        <input type="number" class="form-control" name="min_discount" id="min_discount" min=1 max=100 value="<?= $min_discount ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Maximum offer Discount(%) <span class='text-danger text-sm'>*</span></label>
                                        <input type="number" class="form-control" name="max_discount" max=100 id="max_discount" min=1 max=100 value="<?= $max_discount ?>">
                                    </div>
                                </div>

                                <?php $hiddenStatus = (isset($fetched_data[0]['id']) && $fetched_data[0]['type']  == 'offer_url') ? '' : 'd-none' ?>
                                <div class="form-group offer-url <?= $hiddenStatus ?> ">

                                    <label for="slider_url"> Link <span class='text-danger text-sm'>*</span></label>
                                    <input type="text" class="form-control" placeholder="https://example.com" name="link" value="<?= isset($fetched_data[0]['link']) ? output_escaping($fetched_data[0]['link']) : "" ?>">
                                </div>

                                <div class="form-group mt-2">
                                    <div><label for="image">Offer Image <span class='text-danger text-sm'>*</span><small>(Recommended Size for offers : 1648 x 342 pixels) (Recommended Size for popup offers : 1000 x 1500 pixels)</small></label></div>
                                    <div class="col-sm-10 mt-2">
                                        <div class='col-md-3'><a class="uploadFile img btn btn-primary text-white btn-sm" data-input='image' data-isremovable='0' data-is-multiple-uploads-allowed='0' data-toggle="modal" data-target="#media-upload-modal" value="Upload Photo"><i class='fa fa-upload'></i> Upload</a></div>
                                        <?php
                                        if (file_exists(FCPATH  . @$fetched_data[0]['image']) && !empty(@$fetched_data[0]['image'])) { ?>
                                            <input type="hidden" name="image" value='<?= $fetched_data[0]['image'] ?>'>

                                            <?php $fetched_data[0]['image'] = get_image_url($fetched_data[0]['image'], 'thumb', 'sm');
                                            ?>
                                            <label class="text-danger mt-3">*Only Choose When Update is necessary</label>
                                            <div class="container-fluid row image-upload-section">
                                                <div class="col-md-3 col-sm-12 shadow p-3 mb-5 bg-white rounded m-4 text-center grow image">
                                                    <div class='image-upload-div'><img class="img-fluid mb-2" src="<?= $fetched_data[0]['image'] ?>" alt="Image Not Found"></div>
                                                </div>
                                            </div>
                                        <?php
                                        } else { ?>
                                            <div class="container-fluid row image-upload-section">
                                                <div class="col-md-3 col-sm-12 shadow p-3 mb-5 bg-white rounded m-4 text-center grow image d-none">
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col mb-2 mt-2" id="active_popup_offer">
                                    <input type="checkbox" name="popup_offer_status" class="align-middle simple_stock_management_status" <?= (isset($product_details[0]['id']) && $product_details[0]['stock_type'] != NULL) ? 'checked' : '' ?>> <span class="align-middle">Active Popup offer</span>
                                </div>
                                <div class="form-group">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-success" id="submit_btn"><?= (isset($fetched_data[0]['id'])) ? 'Update Offer' : 'Add Offer' ?></button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="form-group" id="error_box">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--/.card-->
                </div>

                <section class="content col-md-7">
                    <!-- <div class="container-fluid"> -->
                    <ul class="nav nav-tabs mt-3 ml-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#offers_table">Offers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#popup_offers_table">Popup offers</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="offers_table" class="tab-pane active"><br>
                            <div class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Offer Details</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">

                                            </button>
                                        </div>
                                        <div class="modal-body p-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 main-content">
                                <div class="card content-area p-4">
                                    <div class="card-header border-0">


                                    </div>
                                    <div class="card-innr">
                                        <div class="gaps-1-5x"></div>
                                        <table class='table-striped' data-toggle="table" data-url="<?= base_url('admin/offer/view_offers') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-query-params="queryParams">
                                            <thead>
                                                <tr>
                                                    <th data-field="id" data-sortable="true">ID</th>
                                                    <th data-field="type" data-sortable="false">Type</th>
                                                    <th data-field="type_id" data-sortable="true">Type id</th>
                                                    <th data-field="min_discount" data-sortable="true">Min Discount(%)</th>
                                                    <th data-field="max_discount" data-sortable="true">Max Discount(%)</th>
                                                    <th data-field="link" data-sortable="true">URL</th>

                                                    <th data-field="image" data-sortable="false">Image</th>
                                                    <th data-field="date_added" data-sortable="false">Created at</th>

                                                    <th data-field="operate" data-sortable="false">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div><!-- .card-innr -->
                                </div><!-- .card -->
                            </div>
                        </div>
                        <div class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit offer slider Section Details</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">

                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="popup_offers_table" class="tab-pane fade"><br>
                            <div class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Offer Details</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">

                                            </button>
                                        </div>
                                        <div class="modal-body p-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 main-content">
                                <div class="card content-area p-4">
                                    <div class="card-header border-0">



                                    </div>
                                    <div class="card-innr">
                                        <div class="gaps-1-5x"></div>
                                        <table class='table-striped' data-toggle="table" data-url="<?= base_url('admin/popup_offer/view_offers') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-query-params="queryParams">

                                            <thead>
                                                <tr>
                                                    <th data-field="id" data-sortable="true">ID</th>
                                                    <th data-field="type" data-sortable="false">Type</th>
                                                    <th data-field="type_id" data-sortable="true">Type id</th>
                                                    <th data-field="min_discount" data-sortable="true">Min Discount(%)</th>
                                                    <th data-field="max_discount" data-sortable="true">Max Discount(%)</th>
                                                    <th data-field="link" data-sortable="true">URL</th>
                                                    <th data-field="image" data-sortable="false">Image</th>
                                                    <th data-field="date_added" data-sortable="false">Created at</th>
                                                    <th data-field="status" data-sortable="false">Status</th>
                                                    <th data-field="operate" data-sortable="false">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div><!-- .card-innr -->
                                </div><!-- .card -->
                            </div>
                        </div>

                    </div>
                    <!-- /.tab content -->
                    <!-- </div>/.container-fluid -->


                    <!-- /.content -->
                </section>
                <!--/.col-md-12-->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>