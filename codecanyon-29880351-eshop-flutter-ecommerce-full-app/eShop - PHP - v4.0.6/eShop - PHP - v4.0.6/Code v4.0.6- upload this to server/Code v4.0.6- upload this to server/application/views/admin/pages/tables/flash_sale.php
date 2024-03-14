<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h4>Manage Flash Sale</h4>
                </div>
                <div class="col-sm-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Flash Sale </li>
                    </ol>
                </div>
            </div>

        </div><!-- /.container-fluid -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-info">
                        <!-- form start -->
                        <form class="form-horizontal form-submit-event" action="<?= base_url('admin/flash_sale/add_flash_sale'); ?>" method="POST" id="add_product_form" enctype="multipart/form-data">
                            <?php if (isset($fetched_data[0]['id'])) { ?>
                                <input type="hidden" name="edit_flash_sale" value="<?= @$fetched_data[0]['id'] ?>">
                            <?php } ?>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="title" class="control-label">Title <span class='text-danger text-sm'>*</span></label>
                                    <div class="col-md-12 mt-2">
                                        <input type="text" class="form-control" name="title" id="title" value="<?= (isset($fetched_data[0]['title']) ? $fetched_data[0]['title'] : '') ?>" placeholder="Title">
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label for="short_description" class="control-label">Short description <span class='text-danger text-sm'>*</span></label>
                                    <div class="col-md-12 mt-2">
                                        <textarea class="form-control" name="short_description" id="short_description" value="<?= (isset($fetched_data[0]['short_description']) ? $fetched_data[0]['short_description'] : '') ?>" placeholder="Short description"><?= (isset($fetched_data[0]['short_description']) ? $fetched_data[0]['short_description'] : '') ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group row mt-2">
                                    <label for="short_description" class="control-label">Discount(%) <span class='text-danger text-sm'>*</span></label>
                                    <div class="col-md-12 mt-2">
                                        <input type="number" class="form-control" min=1 max=100 name="discount" id="discount" value="<?= (isset($fetched_data[0]['discount']) ? $fetched_data[0]['discount'] : '') ?>" placeholder="Discount(%)">
                                    </div>
                                </div>

                                <div class="form-group row mt-2">
                                    <div class="form-group col-6  mt-2">
                                        <label for="">Start Date <span class='text-danger text-sm'>*</span></label>

                                        <input type="datetime-local" class="form-control mt-2" name="start_date" id="start_date" min="<?= date('Y-m-d\TH:i') ?>" value="<?= @$fetched_data[0]['start_date'] ?>">

                                    </div>
                                    <div class="form-group col-6 mt-2">
                                        <label for="">End Date <span class='text-danger text-sm'>*</span></label>

                                        <input type="datetime-local" class="form-control mt-2" name="end_date" id="end_date" min="<?= date('Y-m-d\TH:i') ?>" value="<?= @$fetched_data[0]['end_date'] ?>">
                                    </div>
                                </div>



                                <label for="product_ids" class="control-label mt-2">Products * (If the product is already on sale, then it will not show up on the list)</label>
                                <div class="form-group row mt-2">
                                    <select name="product_ids[]" class="search_flash_sale_product w-100" multiple data-placeholder=" Type to search and select products" onload="multiselect()">
                                        <?php
                                        if (isset($fetched_data[0]['id'])) {
                                            $product_id = explode(",", $fetched_data[0]['product_ids'] ?? '');

                                            foreach ($product_details as $row) {
                                        ?>
                                                <option value="<?= $row['id'] ?>" selected><?= $row['name'] ?></option>
                                        <?php
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="image">Main Image <span class='text-danger text-sm'>*</span></label>
                                    <div class="col-sm-10 mt-4">
                                        <div class='col-md-3'><a class="uploadFile img btn btn-primary text-white btn-sm" data-input='image' data-isremovable='0' data-is-multiple-uploads-allowed='0' data-toggle="modal" data-target="#media-upload-modal" value="Upload Photo"><i class='fa fa-upload'></i> Upload</a></div>
                                        <?php
                                        if (file_exists(FCPATH . @$fetched_data[0]['image']) && !empty(@$fetched_data[0]['image'])) {
                                        ?>
                                            <label class="text-danger mt-3">*Only Choose When Update is necessary</label>
                                            <div class="container-fluid row image-upload-section">
                                                <div class="col-md-3 col-sm-12 shadow p-3 mb-5 bg-white rounded m-4 text-center grow image">
                                                    <div class='image-upload-div'><img class="img-fluid mb-2" src="<?= BASE_URL() . $fetched_data[0]['image'] ?>" alt="Image Not Found"></div>
                                                    <input type="hidden" name="image" value='<?= $fetched_data[0]['image'] ?>'>
                                                </div>
                                            </div>
                                        <?php
                                        } else { ?>
                                            <div class="container-fluid row image-upload-section">
                                                <div class="col-md-3 col-sm-12 shadow p-3 mb-5 bg-white rounded m-4 text-center grow image d-none"></div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-success" id="submit_btn"><?= (isset($fetched_data[0]['id'])) ? 'Update Flash Sale' : 'Add Flash Sale' ?></button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center form-group">
                                <div id="error_box">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-7 main-content">
                    <div class="card content-area p-4">
                        <div class="card-head">
                            <h4 class="card-title">Flash Sale</h4><br><br>
                            <button type="button" class="btn btn-primary" id="settle_flash_sale">Settle Flash Sale</button>
                        </div>
                        <!-- <div class="col-6">
                       
                    </div> -->

                        <div class="card-innr">
                            <div class="col-md-12"></div>
                            <table class='table-striped' data-toggle="table" data-url="<?= base_url('admin/Flash_sale/get_flash_list') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="title" data-sortable="true">Title</th>
                                        <th data-field="slug" data-sortable="true">Slug</th>
                                        <th data-field="short_description" data-sortable="false">Short description</th>
                                        <th data-field="discount" data-sortable="false">Discount(%)</th>
                                        <th data-field="product_ids" data-sortable="true">Product ids</th>
                                        <th class="col-md-1" data-field="image" data-sortable="true">Image</th>
                                        <th data-field="start_date" data-sortable="true">Starting Date</th>
                                        <th data-field="end_date" data-sortable="true">Ending Date</th>
                                        <th data-field="date" data-sortable="false">created Date</th>
                                        <th data-field="status" data-sortable="true">Status</th>
                                        <th data-field="operate">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div><!-- .card-innr -->
                    </div><!-- .card -->
                </div>
                <!--/.card-->
            </div>
            <div id="tryrun" class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Flash Sale Details</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- how it works model -->




        </div>
        <!-- /.row -->
    </section>
</div><!-- /.container-fluid -->
<!-- /.content -->