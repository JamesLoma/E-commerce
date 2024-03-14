<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h4>Manage Categories Order</h4>
                </div>
                <div class="col-sm-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Categories Orders</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 main-content">
                    <div class="card content-area p-4">
                        <div class="card-header border-0">
                        </div>
                        <div class="card-innr">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12 offset-md-3">
                                        <label for="subcategory_id" class="col-form-label p-2 fs-5 fw-bold">Category List</label>

                                        <div class="table-responsive">
                                            <table class="table table-borderless table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Row Order Id</th>
                                                        <th>Name</th>
                                                        <th>Image</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="move order-container" id="sortable">
                                                    <?php
                                                    $i = 0;
                                                    if (!empty($categories)) {
                                                        foreach ($categories as $row) {
                                                    ?>
                                                            <!-- <li class="list-group-item d-flex bg-gray-light align-items-center h-25" id="category_id-<?= $row['id'] ?>">
                                                                <div class="col-md-2 text-start"><span> <?= $i ?> </span></div>
                                                                <div class="col-md-3 text-center"><span> <?= $row['row_order'] ?> </span></div>
                                                                <div class="col-md-4 text-center"><span><?= $row['name'] ?></span></div>
                                                                <div class="col-md-3 text-center">
                                                                    <img src="<?= $row['image'] ?>" class="w-25">
                                                                </div>
                                                            </li> -->
                                                            <tr class="bg-gray-light align-items-center h-25" id="category_id-<?= $row['id'] ?>">
                                                                <td><span> <?= $i ?> </span></td>
                                                                <td><span> <?= $row['row_order'] ?> </span></td>
                                                                <td><span><?= $row['name'] ?></span></td>
                                                                <td><img src="<?= $row['image'] ?>" class="w-25"></td>
                                                            </tr>
                                                        <?php
                                                            $i++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <li class="list-group-item text-center h-25"> No Categories Exist </li>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="button" class="btn btn-block btn-success btn-lg mt-3" id="save_category_order">Save</button>
                                    </div>
                                </div>
                            </div><!-- .card-innr -->
                        </div><!-- .card -->
                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>