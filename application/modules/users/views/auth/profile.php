<?php $this->load->view('/templates/head.php'); ?>

<body class="main-body app sidebar-mini ltr">

    <!-- Loader -->
    <div id="global-loader">
        <img src="<?= base_url('assets/img/loaders/loader-4.svg') ?>" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->
    <!-- page -->
    <div class="page custom-index">

        <?php $this->load->view('/templates/main-header-app-alider.php'); ?>

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div>
                        <h4 class="content-title mb-2 mb-xl-0">داشبورد 02</h4>
                    </div>
                    <div class="d-flex my-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">صفحه اصلی</a></li>
                                <li class="breadcrumb-item active " aria-current="page">داشبورد 02</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- /breadcrumb -->
                <!-- main-content-body -->
                <div class="main-content-body">
                  <div class="card p-4">
                    <h3>پروفایل</h3>
                    <p>نام: <?= html_escape($user->name); ?></p>
                    <p>ایمیل: <?= html_escape($user->email); ?></p>
                    <p>نقش: <?= html_escape($user->role); ?></p>
                    <a href="<?= site_url('logout');?>" class="btn btn-secondary">خروج</a>
                  </div>
                </div>
                <!-- /row -->


            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->
      
        <!-- Footer code -->

        <div class="main-footer ht-45">
            <div class="container-fluid pd-t-0 ht-100p">
                <span>   <a href="javascript:void(0);" class="text-primary">ادمینِتو</a>. طراحی شده با عشق <span class="fa fa-heart text-danger"></span> توسط  <a href="javascript:void(0);"> برنامه نویسان  </a> ادمینِتو</span>
            </div>
        </div>            <!-- End Footer -->

    </div>
    <!-- End Page -->
<?php $this->load->view('/templates/footer.php'); ?>