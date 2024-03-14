<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h4>Manage Brands</h4>
                </div>
                <div class="col-sm-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Brands</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->




        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card ">
                        <!-- form start -->
                        <form class="form-horizontal form-submit-event" action="<?= base_url('admin/brand/add_brand'); ?>" method="POST" id="add_product_form" enctype="multipart/form-data">
                            <?php if (isset($fetched_data[0]['id'])) { ?>
                                <input type="hidden" name="edit_brand" value="<?= @$fetched_data[0]['id'] ?>">
                            <?php } ?>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="brand_input_name" class="col-sm-2 col-form-label">Name <span class='text-danger text-sm'>*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control mb-2" id="brand_input_name" placeholder="Brand Name" name="brand_input_name" value="<?= isset($fetched_data[0]['name']) ? output_escaping($fetched_data[0]['name']) : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="image">Main Image <span class='text-danger text-sm'>*</span><small>(Recommended Size : 131 x 131 pixels)</small></label>
                                    <div class="col-sm-10">
                                        <div class='col-md-3 mt-4'><a class="uploadFile img btn btn-primary text-white btn-sm" data-input='brand_input_image' data-isremovable='0' data-is-multiple-uploads-allowed='0' data-toggle="modal" data-target="#media-upload-modal" value="Upload Photo"><i class='fa fa-upload'></i> Upload</a></div>
                                        <?php
                                        if (file_exists(FCPATH . @$fetched_data[0]['image']) && !empty(@$fetched_data[0]['image'])) {
                                        ?>
                                            <label class="text-danger mt-3">*Only Choose When Update is necessary</label>
                                            <div class="container-fluid row image-upload-section col-md-4">
                                                <div class="upload-media-div shadow mx-2 bg-white rounded  text-center grow image">
                                                    <div class='image-upload-div'><img class="img-fluid mb-2" src="<?= BASE_URL() . $fetched_data[0]['image'] ?>" alt="Image Not Found"></div>
                                                    <input type="hidden" name="brand_input_image" value='<?= $fetched_data[0]['image'] ?>'>
                                                </div>
                                            </div>
                                        <?php
                                        } else { ?>
                                            <div class="container-fluid row image-upload-section col-md-4">
                                                <div class="upload-media-div shadow mx-2 bg-white rounded  text-center grow image d-none"></div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-success" id="submit_btn"><?= (isset($fetched_data[0]['id'])) ? 'Update Brand' : 'Add Brand' ?></button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="form-group" id="error_box">
                                </div>
                            </div>

                    </div>
                    <!-- /.card-footer -->
                </div>
                <div class="col-md-7">

                    <!-- form start -->
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="modal fade edit-modal-lg" id="brand_form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Brand</h5>
                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="card content-area p-4">

                                        <div class="card-innr" id="list_view_html">
                                            <div class="card-head">
                                                <h4 class="card-title">Brands</h4>
                                            </div>
                                            <div class="gaps-1-5x"></div>
                                            <table class='table-striped' id='brand_table' data-toggle="table" data-url="brand_list" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel","csv"]' data-export-options='{
                        "fileName": "brand-list",
                        "ignoreColumn": ["state"] 
                        }' data-query-params="brand_query_params">
                                                <thead>
                                                    <tr>
                                                        <th data-field="id" data-sortable="true" data-visible='true'>ID</th>
                                                        <th data-field="name" data-sortable="true">Name</th>
                                                        <th data-field="image" data-sortable="false">Image</th>
                                                        <th data-field="status" data-sortable="false">Status</th>
                                                        <th data-field="operate" data-sortable="false">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div><!-- .card-innr -->
                                    </div><!-- .card-innr -->
                                </div><!-- .card -->
                            </div>
                        </div>


                        <!-- /.row -->



                    </section>

                    <!-- /.card-footer -->
                </div>
                <!--/.card-->
            </div>
            <!--/.col-md-12-->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>