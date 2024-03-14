<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h4>Manage Products FAQs</h4>
                </div>
                <div class="col-sm-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Product FAQs</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->

        <div class="container-fluid">
            <div class="row">



                <div class="col-md-5">
                    <div class="card card-info">
                        <!-- form start  -->
                        <form class="form-horizontal form-submit-event" action="<?= base_url('admin/product_faqs/add_faqs'); ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <?php if (!isset($fetched_data[0]['id']) && empty($fetched_data[0]['id'])) { ?>
                                    <div class="form-group row">
                                        <label for="attributes" class="col-sm-2 col-form-label">Select Product <span class='text-danger text-sm'>*</span></label>
                                        <div class="col-sm-10">
                                            <select name="product_id" class="search_product w-100" data-placeholder=" Type to search and select products">
                                                <?php
                                                if (isset($fetched_data[0]['id'])) {
                                                    $product_id = explode(",", $fetched_data[0]['product_ids']);

                                                    foreach ($product_details as $row) {
                                                ?>
                                                        <option value="<?= $row['id'] ?>" selected><?= $row['name'] ?></option>
                                                <?php
                                                    }
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } else {
                                ?>
                                    <input type="hidden" name="product_id" value="<?= @$fetched_data[0]['product_id'] ?>">
                                    <input type="hidden" name="edit_product_faq" value="<?= @$fetched_data[0]['id'] ?>">
                                <?php }   ?>
                                <div class="form-group row">
                                    <label for="question" class="col-sm-2 col-form-label">Question<span class='text-danger text-sm'>*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="question" value="<?= isset($fetched_data[0]['question']) ? @$fetched_data[0]['question'] : ''  ?>" placeholder="question" name="question">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="answer" class="col-sm-2 col-form-label">Answer<span class='text-danger text-sm'>*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="answer" value="<?= isset($fetched_data[0]['answer']) ? @$fetched_data[0]['answer'] : ''  ?>" placeholder="answer" name="answer">
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-success" id="submit_btn"><?= (isset($fetched_data[0]['id'])) ? 'Update Product Faq' : 'Add Product FAQ' ?></button>
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

                <div class="col-md-7 main-content">
                    <div class="card content-area p-4">

                        <div class="card-innr">
                            <div class="gaps-1-5x"></div>
                            <table class='table-striped' id='products_faqs_table' data-toggle="table" data-url="<?= base_url('admin/product_faqs/get_faqs_list') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel","csv"]' data-export-options='{
                            "fileName": "products-list",
                            "ignoreColumn": ["state"] 
                            }' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="user_id" data-sortable="false" data-visible='false'>User Id</th>
                                        <th data-field="product_id" data-sortable="false" data-visible='false'>Product Id</th>
                                        <th data-field="question" data-sortable="false">Question</th>
                                        <th data-field="answer" data-sortable="false">Answer</th>
                                        <th data-field="answered_by" data-sortable="false" data-visible='false'>Answered by</th>
                                        <th data-field="answered_by_name" data-sortable="false">Answered by Name</th>
                                        <th data-field="username" data-width='500' data-sortable="false" class="col-md-6">Username</th>
                                        <th data-field="date_added" data-sortable="false">Date added</th>
                                        <th data-field="operate" data-sortable="false">Operate</th>
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
<div id="product_faq_value_id" class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Product FAQs</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body p-0">
                <form class="form-horizontal form-submit-event" id="product_edit_faq_form" action="<?= base_url('admin/product/edit_product_faqs'); ?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <?php
                        if (isset($fetched_data[0]['id'])) { ?>
                            <input type="hidden" name="edit_product_faq" value="<?= @$fetched_data[0]['id'] ?>">
                        <?php  } ?>
                        <!-- <div class="form-group row">
                            <label for="question" class="col-sm-2 col-form-label">Question </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="question" placeholder="question" name="question" value="<?= @$fetched_data[0]['question'] ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="answer" class="col-sm-2 col-form-label">Answer <span class='text-danger text-sm'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="answer" placeholder="Answer" name="answer" value="<?= @$fetched_data[0]['answer'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <button type="submit" class="btn btn-success" id="submit_btn"><?= (isset($fetched_data[0]['id'])) ? 'Update Product Faq' : 'Add Product FAQ' ?></button>
                        </div> -->
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="form-group" id="error_box">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>