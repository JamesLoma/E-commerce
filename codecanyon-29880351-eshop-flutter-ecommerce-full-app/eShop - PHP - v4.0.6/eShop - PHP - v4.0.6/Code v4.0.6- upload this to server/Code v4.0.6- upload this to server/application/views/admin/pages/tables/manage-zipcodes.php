    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <section class="content-header mt-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h4>Manage Zipcodes</h4>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-end">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                            <li class="breadcrumb-item active">Zipcodes</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <!-- form start -->
                            <form class="form-horizontal form-submit-event" action="<?= base_url('admin/area/add_zipcode'); ?>" method="POST" id="add_product_form" enctype="multipart/form-data">
                                <?php
                                if (isset($fetched_data[0]['id'])) {
                                ?>
                                    <input type="hidden" id="edit_zipcode" name="edit_zipcode" value="<?= @$fetched_data[0]['id'] ?>">
                                    <input type="hidden" id="update_id" name="update_id" value="1">
                                <?php
                                }
                                ?>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="city_name">Zipcode <span class='text-danger text-sm'>*</span></label>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?= (isset($fetched_data[0]['zipcode']) ? $fetched_data[0]['zipcode'] : '') ?>">
                                        </div>
                                    </div>
                                    <div class="row city_list_select mt-2">
                                        <div class="form-group col-md-4">
                                            <label for="city" class="control-label">City <span class='text-danger text-xs'>*</span></label>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <select class="form-control" name="city" id="city_list">
                                                <option value=" ">Select City</option>
                                                <?php foreach ($city as $row) { ?>
                                                    <option value="<?= $row['id'] ?>" <?= (isset($fetched_data[0]['city_id']) && $row['id'] == $fetched_data[0]['city_id']) ? 'selected' : ' ' ?>><?= $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="form-group col-md-4">
                                            <label for="minimum_free_delivery_order_amount" class="control-label">Minimum Free Delivery Order Amount <span class='text-danger text-xs'>*</span></label>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <input type="number" class="form-control" name="minimum_free_delivery_order_amount" id="minimum_free_delivery_order_amount" min="0" value="<?= (isset($fetched_data[0]['minimum_free_delivery_order_amount']) ? $fetched_data[0]['minimum_free_delivery_order_amount'] : '') ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="form-group col-md-4">
                                            <label for="delivery_charges" class="control-label">Delivery Charges <span class='text-danger text-xs'>*</span></label>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <input type="number" class="form-control" name="delivery_charges" id="delivery_charges" min="0" value="<?= (isset($fetched_data[0]['delivery_charges']) ? $fetched_data[0]['delivery_charges'] : '') ?>">
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="form-group">
                                            <button type="reset" class="btn btn-warning">Reset</button>
                                            <button type="submit" class="btn btn-success" id="submit_btn"><?= (isset($fetched_data[0]['id'])) ? 'Update Zipcode' : 'Add Zipcode' ?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="form-group" id="error_box">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--/.card-->
                    </div>
                    <div class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Zipcode</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 main-content">
                        <div class="card content-area p-4">
                            <div class="card-head">
                                <h4 class="card-title">Zipcode Details</h4>
                            </div>
                            <div class="card-innr">
                                <div class="row col-md-6 mt-3">
                                    <div class="row col-md-4 pull-right">
                                        <a href="#" class="btn btn-success sync-zipcode-with-area">Sync Zipcode with Area</a>
                                    </div>
                                </div>
                                <div class="gaps-1-5x"></div>
                                <table class='table-striped' data-toggle="table" data-url="<?= base_url('admin/area/view_zipcodes') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "zipcodes-list",
                            "ignoreColumn": ["operate"] 
                            }' data-query-params="queryParams">
                                    <thead>
                                        <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="zipcode" data-sortable="false">Zipcode</th>
                                        <th data-field="city_name" data-sortable="false">City Name</th>
                                        <th data-field="minimum_free_delivery_order_amount" data-sortable="false">Minimum Free Delivery Order Amount</th>
                                        <th data-field="delivery_charges" data-sortable="false">Delivery Charges</th>
                                        <th data-field="operate" data-sortable="true">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div><!-- .card-innr -->
                        </div><!-- .card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>