<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h4>Contact Us</h4>
                </div>
                <div class="col-sm-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Contact Us</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <!-- form start -->
                        <form class="form-horizontal form-submit-event" action="<?= base_url('admin/Contact_us/update-contact-settings'); ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body pad">
                                <label for="other_images">Contact Us </label>
                                <div class="mb-3">
                                    <textarea name="contact_input_description" class="textarea addr_editor" placeholder="Place some text here text_editor">  <?= output_escaping(str_replace('\r\n', '&#13;&#10;', $contact_info)) ?></textarea>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="form-group" id="error_box">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-success" id="submit_btn">Update Contact Info</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!--/.card-->
            </div>
            <!--/.col-md-12-->
        </div>
     
</section>
<!-- /.content -->
</div>