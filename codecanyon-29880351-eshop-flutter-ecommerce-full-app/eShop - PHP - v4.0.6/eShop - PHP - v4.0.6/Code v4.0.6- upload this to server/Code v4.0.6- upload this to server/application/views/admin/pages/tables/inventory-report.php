<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-8">
                    <h4>View Inventory Report</h4>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Inventory Report</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 main-content">
                    <div class="card content-area p-4">
                        <div class="card-innr">
                            <!-- <div class="gaps-1-5x row d-flex adjust-items-center">

                            </div> -->
                            <?php $currency_symbol = get_settings('currency'); ?>

                            <table class='table-striped' data-toggle="table" data-url="<?= base_url('admin/Invoice/get_inventory_list') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="final_total" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{"fileName": "inventory-list" }' data-query-params="inventory_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="product_name" data-sortable='true'>Product Name</th>
                                        <th data-field="product_variant_id" data-sortable='false'>Product Variant Id</th>
                                        <th data-field="unit_of_measure" data-sortable='false'>Unit Of Measure</th>
                                        <th data-field="total_units_sold" data-sortable='false'>Total Units Sold</th>
                                        <th data-field="final_total" data-sortable='true'>Total Sales (<?= $currency_symbol ?>)</th>
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