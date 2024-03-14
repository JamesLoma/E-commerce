<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-8">
                    <h4>Manage Pickup Location</h4>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Pickup Location</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <!-- form start -->
                        <form class="form-horizontal form-submit-event" action="<?= base_url('admin/pickup_location/add_pickup_location'); ?>" method="POST" id="add_product_form" enctype="multipart/form-data">
                            <?php
                            if (isset($fetched_data[0]['id'])) {
                            ?>
                                <input type="hidden" id="edit_pickup_location" name="edit_pickup_location" value="<?= @$fetched_data[0]['id'] ?>">
                                <input type="hidden" id="update_id" name="update_id" value="1">
                            <?php
                            }
                            ?>

                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label for="area_name" class="control-label col-md-12">Pickup Location <span class='text-danger text-xs'>*</span></label>
                                        <input type="text" class="form-control" name="pickup_location" placeholder="The nickname of the new pickup location. Max 36 characters." id="pickup_location" value="<?= (isset($fetched_data[0]['pickup_location']) ? $fetched_data[0]['pickup_location'] : '') ?>">
                                    </div>

                                    <div class="col-3">
                                        <label for="area_name" class="control-label col-md-12">Name <span class='text-danger text-xs'>*</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="The shipper's name." id="name" value="<?= (isset($fetched_data[0]['name']) ? $fetched_data[0]['name'] : '') ?>">
                                    </div>

                                    <div class="col-3">
                                        <label for="area_name" class="control-label col-md-12">Email <span class='text-danger text-xs'>*</span></label>
                                        <input type="text" class="form-control" name="email" placeholder="The shipper's email address." id="email" value="<?= (isset($fetched_data[0]['email']) ? $fetched_data[0]['email'] : '') ?>">
                                    </div>

                                    <div class="col-3">
                                        <label for="area_name" class="control-label col-md-12">Phone <span class='text-danger text-xs'>*</span></label>
                                        <input type="number" class="form-control" name="phone" placeholder="Shipper's phone number." id="phone" value="<?= (isset($fetched_data[0]['phone']) ? $fetched_data[0]['phone'] : '') ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label for="area_name" class="control-label col-md-12">City <span class='text-danger text-xs'>*</span></label>
                                        <input type="text" class="form-control" name="city" placeholder="Pickup location city name." id="city" value="<?= (isset($fetched_data[0]['city']) ? $fetched_data[0]['city'] : '') ?>">
                                    </div>

                                    <div class="col-3">
                                        <label for="area_name" class="control-label col-md-12">State <span class='text-danger text-xs'>*</span></label>
                                        <input type="text" class="form-control" name="state" placeholder="Pickup location state name." id="state" value="<?= (isset($fetched_data[0]['state']) ? $fetched_data[0]['state'] : '') ?>">
                                    </div>

                                    <div class="col-3">
                                        <label for="area_name" class="control-label col-md-12">Country <span class='text-danger text-xs'>*</span></label>
                                        <input type="text" class="form-control" name="country" placeholder="Pickup location country." id="country" value="<?= (isset($fetched_data[0]['country']) ? $fetched_data[0]['country'] : '') ?>">
                                    </div>

                                    <div class="col-3">
                                        <label for="area_name" class="control-label col-md-12">Pincode <span class='text-danger text-xs'>*</span></label>
                                        <input type="text" class="form-control" name="pincode" placeholder="Pickup location pincode." id="pincode" value="<?= (isset($fetched_data[0]['pin_code']) ? $fetched_data[0]['pin_code'] : '') ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="area_name" class="control-label col-md-12">Address <span class='text-danger text-xs'>*</span></label>
                                        <textarea class="form-control" name="address" placeholder="Shipper's primary address. Max 80 characters." id="address" value="<?= (isset($fetched_data[0]['address']) ? $fetched_data[0]['address'] : '') ?>"><?= (isset($fetched_data[0]['address']) ? $fetched_data[0]['address'] : '') ?></textarea>
                                    </div>

                                    <div class="col-6">
                                        <label for="area_name" class="control-label col-md-12">Address 2 </label>
                                        <textarea class="form-control" name="address2" placeholder="Additional address details." id="address2" value="<?= (isset($fetched_data[0]['address_2']) ? $fetched_data[0]['address_2'] : '') ?>"><?= (isset($fetched_data[0]['address_2']) ? $fetched_data[0]['address_2'] : '') ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="area_name" class="control-label col-md-12">Latitude</span></label>
                                        <input type="text" class="form-control" name="latitude" placeholder="Pickup location Latitude." id="latitude" value="<?= (isset($fetched_data[0]['latitude']) ? $fetched_data[0]['latitude'] : '') ?>">
                                    </div>

                                    <div class="col-6">
                                        <label for="area_name" class="control-label col-md-12">Longitude</span></label>
                                        <input type="text" class="form-control" name="longitude" placeholder="Pickup location Longitude." id="longitude" value="<?= (isset($fetched_data[0]['longitude']) ? $fetched_data[0]['longitude'] : '') ?>">
                                    </div>
                                </div>
                               
                                <div class="form-group row mt-3">
                                    <div class="col-6">
                                        <button type="reset" class="btn btn-warning">Reset</button>
                                        <button type="submit" class="btn btn-success" id="submit_btn"><?= (isset($fetched_data[0]['id'])) ? 'Update Pickup Location' : 'Add Pickup Location' ?></button>
                                    </div>
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
                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Pickup Location</h5>
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
                        <h4 class="card-title">Pickup Location Details</h4>
                    </div>
                    <div class="card-innr">
                        <div class="gaps-1-5x"></div>
                        <div class="mt-4">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#verifyPickupLocations">Need to verify the pickup Locations</button>
                        </div>

                        <table class='table-striped' data-toggle="table" data-url="<?= base_url('admin/pickup_location/view_pickup_location') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-export-types='["txt","excel"]' data-export-options='{
                        "fileName": "area-list",
                        "ignoreColumn": ["operate"] 
                        }' data-maintain-selected="true" data-query-params="queryParams">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="pickup_location" data-sortable="true">Pickup Locations</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="email" data-sortable="true">Email</th>
                                    <th data-field="phone" data-sortable="true">Phone</th>
                                    <th data-field="address">Address</th>
                                    <th data-field="address2">Address 2</th>
                                    <th data-field="city" data-sortable="true">City</th>
                                    <th data-field="pin_code" data-sortable="true">Pincode</th>
                                    <th data-field="verified">Verified</th>
                                    <th data-field="operate">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- .card-innr -->
                </div><!-- .card -->
            </div>
        </div>
        <!-- /.row -->
       
    </section>
    <!-- /.content -->
</div>

<!-- Modal for verify the pickup Locations -->

<div class="modal fade" id="verifyPickupLocations" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Need to verify the pickup Locations</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body ">
                <ol>
                    <li> After adding the pickup location you need to verify the pickup location on shiprocket dashboard.</li>
                    <li> Note: You can verify unverified pickup locations from <a href="https://app.shiprocket.in/company-pickup-location?redirect_url=" target="_blank">shiprocket dashboard </a>. New number in pickup location has to be verified once, Later additions of pickup locations with a same number will not require verification.</li>
                    <li> After verifying the pickup location in shiprocket, you need to verify that location in table.</li>
                    <li> You will find Verified column in pickup location table in this page.</li>
                </ol>
            </div>
        </div>
    </div>
</div>