<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h4> Manage Promo Code</h4>
                </div>
                <div class="col-sm-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Manage Promo Code</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->

        <div class="container-fluid">
            <div class="row">
                <div class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Manage Promo Code</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body ">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 main-content">
                    <div class="card content-area p-4">
                        <div class="card-header border-0">
                            <div class="card-tools">
                                <a href="<?= base_url() . 'admin/promo-code/' ?>" class="btn btn-block btn-primary btn-sm">Add Promo Code</a>
                            </div>
                        </div>
                        <div class="card-innr">
                            <div class="gaps-1-5x"></div>
                            <table class='table-striped' data-toggle="table" data-url="<?= base_url('admin/promo_code/view_promo_code') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "promocode-list",
                            "ignoreColumn": ["state"] 
                            }' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="promo_code" data-sortable="false">Promo Code</th>
                                        <th data-field="image" data-sortable="false">Image</th>
                                        <th data-field="message" data-sortable="true">Message</th>
                                        <th data-field="start_date" data-sortable="true">Start Date</th>
                                        <th data-field="end_date" data-sortable="true">End Date</th>
                                        <th data-field="no_of_users" data-sortable="true" data-visible='false'>No .of users</th>
                                        <th data-field="min_order_amt" data-sortable="true" data-visible='false'>Minimum order amount</th>
                                        <th data-field="discount" data-sortable="true">Discount</th>
                                        <th data-field="discount_type" data-sortable="true">Discount type</th>
                                        <th data-field="max_discount_amt" data-sortable="true" data-visible='false'>Max discount amount</th>
                                        <th data-field="repeat_usage" data-sortable="true" data-visible='false'>Repeat usage</th>
                                        <th data-field="no_of_repeat_usage" data-sortable="true" data-visible='false'>No of repeat usage</th>
                                        <th data-field="status" data-sortable="true">Status</th>
                                        <th data-field="is_cashback" data-sortable="true">Is Cashback</th>
                                        <th data-field="list_promocode" data-sortable="true">View Promocode</th>
                                        <th data-field="operate" data-sortable="false">Actions</th>
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
