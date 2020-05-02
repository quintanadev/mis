<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <title>Portal MIS - Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Rodrigo Quintana" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= base_url('assets/media/logos/favicon.ico'); ?>">

        <!--begin::Global Theme Styles(used by all pages) -->
		<link href="<?= base_url('assets/css/plugins.bundle.css'); ?>" rel="stylesheet" type="text/css" />
        <!--end::Global Theme Styles -->

        <!-- Plugins css -->
        <link href="<?= base_url('assets/plugins/datatables/DataTables-1.10.12/css/dataTables.bootstrap4.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/plugins/datatables/Responsive-2.2.3/css/responsive.bootstrap4.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/plugins/ladda/ladda-themeless.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css'); ?>" rel="stylesheet" type="text/css" />

        <!-- Page css -->
        <link href="<?= base_url('assets/plugins/flatpickr/flatpickr.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/plugins/select2/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/plugins/quill/quill.core.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/plugins/quill/quill.bubble.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/plugins/quill/quill.snow.css'); ?>" rel="stylesheet" type="text/css" />
        
        <!-- App css -->
        <?php $skin = (isset($this->session->userdata('CONFIG_U')['site-skin']) ? $this->session->userdata('CONFIG_U')['site-skin'] : $this->session->userdata('CONFIG_G')['site-skin']); ?>
        <link href="<?= base_url('assets/css/ubold/bootstrap-' . $skin . '.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/css/ubold/icons-' . $skin . '.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/css/ubold/app-' . $skin . '.css'); ?>" rel="stylesheet" type="text/css" />

    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <?php // $this->load->view('partials/search'); ?>
                    <?php // $this->load->view('partials/notification'); ?>
                    <?php $this->load->view('partials/actions'); ?>
                    <?php $this->load->view('partials/filters'); ?>
                    <?php $this->load->view('partials/user'); ?>
                    <?php $this->load->view('partials/setting'); ?>
                </ul>

                <!-- LOGO -->
                <?php $this->load->view('partials/logo'); ?>
                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fe-menu"></i>
                        </button>
                    </li>
                    <?php // $this->load->view('partials/menu-top'); ?>
                </ul>
            </div>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">
                <div class="slimscroll-menu">
                    <!--- Sidemenu -->
                    <?php $this->load->view('partials/sidebar'); ?>
                    <!-- End Sidebar -->
                    <div class="clearfix"></div>
                </div>
                <!-- Sidebar -left -->
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <?php // $this->load->view('partials/page-title'); ?>
                        <div class="mb-3"></div>
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <?php for ($i = 0; $i < count($views); $i++) :
                                    $this->load->view($views[$i]);
                                endfor; ?>
                            </div>
                        </div>
                    
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php $this->load->view('partials/footer'); ?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        <?php $this->load->view('partials/right-sidebar'); ?>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        <!-- Pages Site js-->
        <?php $this->load->view('partials/scripts'); ?>
    </body>
</html>