<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4> Offers Management </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Offers</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
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

                            <div class="card-tools">
                                <a href="<?= base_url() . 'admin/offer/' ?>" class="btn btn-block  btn-outline-primary btn-sm">Add Offer </a>
                            </div>
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

                            <div class="card-tools">
                                <a href="<?= base_url() . 'admin/offer/' ?>" class="btn btn-block  btn-outline-primary btn-sm">Add Popup Offer </a>
                            </div>

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
</div>