<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Manage Brands</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active"><a href="<?= base_url('admin/brand/') ?>">Brands</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6"></div>
                <div class="form-group col-sm-6">
                    <a class="btn btn-xs btn-primary text-white float-sm-right" data-toggle="modal" data-target="#howItWorksModal" title="How it works">How to add brand?</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <div class="modal fade" id="howItWorksModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">How to add brand ?</h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body ">
                        <ol>
                            <li>First Admin has to click on add brand.</li>
                            <li>Then the Admin has to enter a unique name of the brand, if it already exists on the database then it will not accept the name.</li>
                            <li>Admin will have to upload the picture of the brand.</li>
                            <li>Admin will be have two options, either to upload a new image or to select from existing images.</li>
                            <li>Once image is chosen, Admin will then have to click on choose media.</li>
                            <li>Then the last step is to click on Add Brand.</li>
                            <li>If all steps are followed then brand will be added succesfully!!!.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- </section>
    <section class="content"> -->
        <div class="container-fluid">
            <div class="row">
                <div class="modal fade edit-modal-lg" id="brand_form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Brand</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">

                                </button>
                            </div>
                            <div class="modal-body p-0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 ">
                    <div class="card content-area p-4">
                        <div class="card-header border-0">
                            <div class="card-tools">
                                <a href="<?= base_url() . 'admin/brand/create-brand' ?>" class="btn btn-block  btn-outline-primary btn-sm">Add Brand</a>
                            </div>
                        </div>
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
                                        <th data-field="id" data-sortable="true" data-visible='false'>ID</th>
                                        <th data-field="name" data-sortable="false">Name</th>
                                        <th data-field="image" data-sortable="true">Image</th>
                                        <th data-field="status" data-sortable="true">Status</th>
                                        <th data-field="operate" data-sortable="true">Action</th>
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

    <!-- /.content -->
</div>