<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h4>Manage offer slider </h4>
                </div>
                <div class="col-sm-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Offer slider</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-info">
                        <!-- form start -->
                        <form class="form-horizontal form-submit-event" action="<?= base_url('admin/offer_slider/add_offer_slider'); ?>" method="POST" enctype="multipart/form-data">
                            <?php if (isset($fetched_data[0]['id'])) { ?>
                                <input type="hidden" id="edit_offer_slider" name="edit_offer_slider" value="<?= @$fetched_data[0]['id'] ?>">
                                <input type="hidden" id="update_id" name="update_id" value="1">
                            <?php } ?>
                            <div class="card-body">
                                <div class="form-group row">
                                    <?php
                                    $style = ['default', 'style_1', 'style_2', 'style_3', 'style_4'];
                                    ?>
                                    <label for="style" class="control-label">Style <span class='text-danger text-sm'>*</span></label>
                                    <div class="col-md-12 mt-2">
                                        <select name="style" class="form-control">
                                            <option value=" ">Select Style</option>
                                            <?php foreach ($style as $row) { ?>
                                                <option value="<?= $row ?>" <?= (isset($fetched_data[0]['style']) && $fetched_data[0]['style'] == $row) ? 'Selected' : '' ?>><?= ucwords(str_replace('_', ' ', $row)) ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php ?>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="product_ids" class="control-label">Offers *</label>
                                    <div class="col-md-12 mt-2">
                                        <select name="offer_ids[]" id="search_offer" class="search_offer w-100" multiple data-placeholder=" Type to search and select offers" onload="multiselect()">
                                            <?php
                                            if (isset($fetched_data[0]['id'])) {
                                                $product_id = explode(",", $fetched_data[0]['offer_ids'] ?? '');
                                                foreach ($product_details as $row) {
                                                    $row['min_discount'] = (isset($row['min_discount']) && !empty($row['min_discount'])) ? $row['min_discount'] : 0;
                                                    $row['max_discount'] = (isset($row['max_discount']) && !empty($row['max_discount'])) ? $row['max_discount'] : 0;
                                                    $option = '<div class="row">
                                                        <div class="col-md-1 align-self-center">
                                                            <div class=""><img class="img-fluid" src="' . base_url($row['image']) . '"></div>
                                                        </div>
                                                        <div class="col-md-11 align-self-center "><div class="">Min - Max Discount : ' . $row['min_discount'] . '% - ' . $row['max_discount'] . '% </div><small class="">ID - ' . $row['id'] . ' </small> | <small class="">Type - ' . $row['type'] . ' </small> 
                                                        </div>
                                                    </div>';
                                            ?>
                                                    <option value="<?= $row['id'] ?>" data-select2-text='<?= $option ?>' selected><?= $option ?></option>
                                            <?php
                                                }
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-success" id="submit_btn"><?= (isset($fetched_data[0]['id'])) ? 'Update offer slider Section' : 'Add offer slider Section' ?></button>
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
                            <h4 class="card-title">Offer slider Section</h4>
                        </div>
                        <div class="card-innr">
                            <div class="gaps-1-5x"></div>
                            <table class='table-striped' data-toggle="table" data-url="<?= base_url('admin/offer_slider/get_offer_slider_list') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="style" data-sortable="false">Style</th>
                                        <th data-field="offer_ids" data-sortable="true">Offer ids</th>
                                        <th data-field="date" data-sortable="false">Date</th>
                                        <th data-field="operate">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div><!-- .card-innr -->
                    </div><!-- .card -->
                </div>
                <!--/.card-->
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

        </div>
        <!-- /.row -->
    </section>
</div><!-- /.container-fluid -->
<!-- /.content -->