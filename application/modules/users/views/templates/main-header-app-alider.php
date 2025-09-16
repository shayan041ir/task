<!-- app header code -->

<div class="main-header side-header sticky nav nav-item">
    <div class="container-fluid main-container ">
        <div class="main-header-left ">
            <div class="app-sidebar__toggle mobile-toggle" data-bs-toggle="sidebar">
                <a class="open-toggle" href="javascript:void(0);"><i class="header-icons"
                        data-eva="menu-outline"></i></a>
                <a class="close-toggle" href="javascript:void(0);"><i class="header-icons"
                        data-eva="close-outline"></i></a>
            </div>
            <div class="responsive-logo">
                <a href="index.html" class="header-logo"><img src="<?= base_url('assets/img/brand/logo.png') ?>"
                        class="logo-11" alt="logo"></a>
                <a href="index.html" class="header-logo"><img src="<?= base_url('assets/img/brand/logo-white.png') ?>"
                        class="logo-1" alt="logo"></a>
            </div>
        </div>
        <button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
            aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
        </button>
        <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0  mg-lg-s-auto">
            <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                <div class="main-header-right">
                    <div class="dropdown nav-item main-layout">
                        <a href="javascript:void(0)" class="new theme-layout nav-link-bg layout-setting">
                            <span class="dark-layout"><i class="fe fe-moon"></i></span>
                            <span class="light-layout"><i class="fe fe-sun"></i></span>
                        </a>
                    </div>
                    <div class="nav nav-item  navbar-nav-right mg-lg-s-auto">
                        <div class="nav-item full-screen fullscreen-button">
                            <a class="new nav-link full-screen-link" href="javascript:void(0);"><i
                                    class="fe fe-maximize"></i></a>
                        </div>

                        <div class="dropdown main-profile-menu nav nav-item nav-link">
                            <a class="profile-user d-flex" href="javascript:void(0)"><img src="<?= base_url('assets/img/users/11.jpg') ?>"
                                    alt="user-img" class="rounded-circle mCS_img_loaded"><span></span></a>

                            <div class="dropdown-menu">
                                <div class="main-header-profile header-img bg-primary rounded-top-5 p-3">
                                    <h6> ممد دولوپ</h6><span> طراح سایت</span>
                                </div>
                                <a class="dropdown-item" href="profile.html"><i class="fe fe-user"></i> پروفایل من</a>
                                <a class="dropdown-item" href="editprofile.html"><i class="fe fe-edit"></i> ویرایش
                                    پروفایل</a>
                                <a class="dropdown-item" href="profile.html"><i class="fe fe-clock"></i> ورود های
                                    فعال</a>
                                <a class="dropdown-item" href="profile.html"><i class="fe fe-settings"></i> تنطیمات
                                    حساب</a>
                                <a class="dropdown-item" href="login.html"><i class="fe fe-log-out"></i> خروج</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End app header Code -->
<!-- app sidebar Code -->

<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<div class="sticky">
    <aside class="app-sidebar sidebar-scroll">
        <div class="main-sidebar-header active">
            <a class="desktop-logo logo-light active" href="index.html"><img
                    src="<?= base_url('assets/img/brand/logo.png') ?>" class="main-logo" alt="logo"></a>
            <a class="logo-icon mobile-logo icon-dark active" href="index.html"><img
                    src="<?= base_url('assets/img/brand/favicon-white.png') ?>" alt="logo"></a>
        </div>
        <div class="main-sidemenu">
            <div class="main-sidebar-loggedin">
                <div class="app-sidebar__user">
                    <div class="dropdown user-pro-body text-center">
                        <div class="user-pic">
                            <img src="<?= base_url('assets/img/users/11.jpg') ?>" alt="user-img"
                                class="rounded-circle mCS_img_loaded">
                        </div>
                        <div class="user-info mb-4">
                            <?php
                            if (isset($user) && !empty($user)):
                                // echo '<pre>';
                                // print_r($user);
                                // echo '</pre>';
                                ?>
                                <h6 class=" mb-0 text-dark"><?= html_escape($user->name); ?></h6>
                                <script>
                                    console.log('User Data:', <?php echo json_encode($user); ?>);
                                </script>
                                <span
                                    class="text-muted app-sidebar__user-name text-sm"><?= html_escape($user->email); ?></span>
                                <?php
                            elseif (isset($admin) && !empty($admin)):
                                // echo '<pre>';
                                // print_r($admin);
                                // echo '</pre>';
                                ?>
                                <script>
                                    console.log('Admin Data:', <?php echo json_encode($admin); ?>);
                                </script>
                                <h6 class=" mb-0 text-dark">
                                    <?= html_escape($admin->name); ?>
                                </h6>
                                <span
                                    class="text-muted app-sidebar__user-name text-sm"><?= html_escape($admin->email); ?></span>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="side-menu ">
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="<?= site_url('admin/users') ?>"><i
                            class="side-menu__icon  bx bx-landscape"></i><span
                            class="side-menu__label">داشبورد</span></a>
                </li>
                <?php 
                    // بررسی نقش کاربر از سشن یا متغیر user/admin
                    $role = null;
                    if (isset($user) && !empty($user)) {
                        $role = $user->role;
                    } elseif (isset($admin) && !empty($admin)) {
                        $role = $admin->role;
                    } elseif (isset($_SESSION['user_role'])) {
                        $role = $_SESSION['user_role'];
                    } elseif (function_exists('get_instance')) {
                        $CI = get_instance();
                        $role = $CI->session->userdata('user_role');
                    }
                    if ($role === 'admin'):
                ?>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="<?= site_url('admin/users/list') ?>"><i
                            class="side-menu__icon  bx bx-landscape"></i><span
                            class="side-menu__label">لیست کاربران</span></a>
                </li>
                <?php
                    endif;
                ?>

            </ul>
        </div>
    </aside>
</div>
<!-- End app sidebar Code -->

<?php
$this->load->view('templates/footer');
?>