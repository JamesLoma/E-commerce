<?php $current_version = get_current_version(); ?>
<nav class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <ul class="navbar-nav">

            <li class="nav-item my-auto">
                <span class="badge bg-primary">v <?= (isset($current_version) && !empty($current_version)) ? $current_version : '1.0' ?></span>
            </li>
            <?php
            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
            ?>
                <li class="nav-item my-auto m-2">
                    <span class="badge bg-danger">Demo mode</span>
                </li>
            <?php } ?>
        </ul>


        <ul class="navbar-nav flex-row align-items-center ms-auto">

            <!-- Place this tag where you want the button to render. -->
            <!-- google translate  -->
            <!-- <div id="refresh_notification"></div>
            <li class="nav-item dropdown" id="refresh_notification">
                <div id="list" class="dropdown-menu dropdown-menu-end py-0 dropdown-menu-lg"></div>
            </li> -->
            <div id="google_translate_element"></div>





            <!-- start send admin notification  -->
            <?php
            $notifications = fetch_details('system_notification',  NULL,  '*',  '3', '0',  'read_by', 'ASC',  '',  '');
            $count_noti = fetch_details('system_notification',  ["read_by" => 0],  'count(id) as total');
            ?>

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i id="refresh_notification"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-2" id="list">
                    <?php if ($this->ion_auth->is_admin()) { ?>

                        <a class="dropdown-item" href="#">
                            <div class="d-flex">

                            </div>
                        </a>

                        <a class="dropdown-item">
                            <i class="fas fa-user-circle mr-2 fa-lg"></i> Profile
                        </a>
                        <a href="<?= base_url('admin/home/logout') ?>" class="dropdown-item">
                            <i class="fa fa-sign-out-alt mr-2 fa-lg"></i> Log Out
                        </a>

                    <?php } else { ?>
                        <a href="#" class="dropdown-item">Welcome <b><?= ucfirst($this->ion_auth->user()->row()->username) ?> </b>! </a>
                        <a href="<?= base_url('delivery_boy/home/profile') ?>" class="dropdown-item"><i class="fas fa-user mr-2"></i> Profile </a>
                        <a href="<?= base_url('delivery_boy/home/logout') ?>" class="dropdown-item "><i class="fa fa-sign-out-alt mr-2"></i> Log Out </a>
                    <?php } ?>
                </div>
            </li>




            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <div class="form-control mr-sm-2 d-flex p-0">
                        <div class="avatar avatar-online">
                            <img src=<?= base_url("/assets/admin/img/avatars/Admin_Profile.png") ?> alt class="w-px-40 h-auto rounded-circle avatar avatar-online" />
                        </div>
                        <b>
                            <p class="image-text">Hi, <?= ucfirst($this->ion_auth->user()->row()->username) ?></p>
                        </b>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <?php if ($this->ion_auth->is_admin()) { ?>

                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src=<?= base_url("/assets/admin/img/avatars/Admin_Profile.png") ?> alt class="w-px-40 h-auto rounded-circle avatar avatar-online" />
                                    </div>
                                </div>

                                <div class="flex-grow-1 p-2">
                                    <b>
                                        <p class="image-text"> <?= ucfirst($this->ion_auth->user()->row()->username) ?></p>
                                    </b>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>

                        <a href="<?= base_url('admin/home/profile') ?>" class="dropdown-item">
                            <i class="fas fa-user-circle mr-2 fa-lg"></i> Profile
                        </a>
                        <a href="<?= base_url('admin/home/logout') ?>" class="dropdown-item">
                            <i class="fa fa-sign-out-alt mr-2 fa-lg"></i> Log Out
                        </a>

                    <?php } else { ?>
                        <a href="#" class="dropdown-item">Welcome <b><?= ucfirst($this->ion_auth->user()->row()->username) ?> </b>! </a>
                        <a href="<?= base_url('delivery_boy/home/profile') ?>" class="dropdown-item"><i class="fas fa-user mr-2"></i> Profile </a>
                        <a href="<?= base_url('delivery_boy/home/logout') ?>" class="dropdown-item "><i class="fa fa-sign-out-alt mr-2"></i> Log Out </a>
                    <?php } ?>
                </div>
            </li>


            <!--/ User -->
        </ul>
    </div>
</nav>