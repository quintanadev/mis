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

        <!-- App css -->
        <link href="<?= base_url('assets/css/ubold/bootstrap-' . $this->session->userdata('CONFIG_G')['site_skin'] . '.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/css/ubold/icons-' . $this->session->userdata('CONFIG_G')['site_skin'] . '.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/css/ubold/app-' . $this->session->userdata('CONFIG_G')['site_skin'] . '.css'); ?>" rel="stylesheet" type="text/css" />

        <!--begin::Global Theme Styles(used by all pages) -->
		<link href="<?= base_url('assets/css/plugins.bundle.css'); ?>" rel="stylesheet" type="text/css" />
        <!--end::Global Theme Styles -->

        <!-- Plugins css -->
        <link href="<?= base_url('assets/plugins/flatpickr/flatpickr.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/plugins/datatables/DataTables-1.10.12/css/dataTables.bootstrap4.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/plugins/datatables/Responsive-2.2.3/css/responsive.bootstrap4.css'); ?>" rel="stylesheet" type="text/css" />
        
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <?php // $this->load->view('partials/search'); ?>
                    <?php // $this->load->view('partials/notification'); ?>
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

        <!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#2c77f4",
						"light": "#ffffff",
						"dark": "#282a3c",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>
        <!-- end::Global Config -->
        
        <!-- Vendor js -->
        <script src="<?= base_url('assets/plugins/jquery.min.js'); ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/js/vendor.min.js'); ?>"></script>

        <!-- App js-->
        <script src="<?= base_url('assets/js/app.min.js'); ?>"></script>
        <script src="<?= base_url('assets/js/site/app-custom.js'); ?>"></script>
        
        <!-- Pages Site js-->
        <?php $this->load->view('partials/scripts'); ?>
    </body>
</html>