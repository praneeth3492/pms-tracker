<?php
session_start();
require_once "config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION["manager_id"])) {
    header("Location: login.php");
    exit;
}

// Check if client_id is present in the URL
if (!isset($_GET['client_id']) || !is_numeric($_GET['client_id'])) {
    echo "A valid Client ID is required.";
    exit;
}

$client_id = intval($_GET['client_id']);

// Fetch client data
$clientSql = "SELECT * FROM clients WHERE client_id = ?";
$stmt = $conn->prepare($clientSql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$clientResult = $stmt->get_result();
if ($clientResult->num_rows > 0) {
    $clientData = $clientResult->fetch_assoc();
    $name = $clientData['client_name'];
} else {
    echo "No client found with ID: " . $client_id;
    exit;
}
$stmt->close();

// Fetch manager data
$manager_id = $_SESSION["manager_id"];
$managerSql = "SELECT manager_name FROM managers WHERE manager_id = ?";
$stmt = $conn->prepare($managerSql);
$stmt->bind_param("i", $manager_id);
$stmt->execute();
$managerResult = $stmt->get_result();
$manager_name = ($managerResult->num_rows > 0) ? $managerResult->fetch_assoc()['manager_name'] : "Unknown Manager";
$stmt->close();

// HTML and other PHP code continues...
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>DrSmart - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="MyraStudio" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/theme.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="index.html" class="logo">
                        <span>
                            <img src="assets/images/logo-light.png" alt="" height="15">
                        </span>
                        <i>
                            <img src="assets/images/logo-small.png" alt="" height="24">
                        </i>
                    </a>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <?php include 'sidebar.php'; ?>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->
        <div class="main-content">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-sm mr-2 d-lg-none header-item" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <div class="header-breadcumb">
                             
                            <h2 class="header-title">Overview</h2>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        
                        <button type="button" class="btn btn-primary d-none d-lg-block ml-2">
                            <i class="mdi mdi-pencil-outline mr-1"></i> Create Reports
                        </button>

                        <div class="dropdown d-inline-block ml-2">
                            <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge badge-danger badge-pill">6</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0"> Notifications </h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small"> View All</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="" class="text-reset">
                                        <div class="media py-2 px-3">
                                            <img src="assets/images/users/avatar-2.jpg"
                                                class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-1">Samuel Coverdale</h6>
                                                <p class="font-size-12 mb-1">You have new follower on Instagram</p>
                                                <p class="font-size-12 mb-0 text-muted"><i class="mdi mdi-clock-outline"></i> 2 min ago</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="" class="text-reset">
                                        <div class="media py-2 px-3">
                                            <div class="avatar-xs mr-3">
                                                <span class="avatar-title bg-success rounded-circle">
                                                    <i class="mdi mdi-cloud-download-outline"></i>
                                                </span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-1">Download Available !</h6>
                                                <p class="font-size-12 mb-1">Latest version of admin is now available. Please download here.</p>
                                                <p class="font-size-12 mb-0 text-muted"><i class="mdi mdi-clock-outline"></i> 4 hours ago</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="" class="text-reset">
                                        <div class="media py-2 px-3">
                                            <img src="assets/images/users/avatar-3.jpg"
                                                class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-1">Victoria Mendis</h6>
                                                <p class="font-size-12 mb-1">Just upgraded to premium account.</p>
                                                <p class="font-size-12 mb-0 text-muted"><i class="mdi mdi-clock-outline"></i> 1 day ago</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-top">
                                    <a class="btn btn-sm btn-light btn-block text-center" href="javascript:void(0)">
                                        <i class="mdi mdi-arrow-down-circle mr-1"></i> Load More..
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block ml-2">
                            <button type="button" class="btn header-item" id="page-header-user-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                    alt="Header Avatar">
                                <span class="d-none d-sm-inline-block ml-1"><?php echo $manager_name; ?></span>
                                <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">

                                 
                                
                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                    <span>Log Out</span>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </header>
               <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
 
        <div class="main">
        <?php
                $clientSql = "SELECT * from clients WHERE client_id = ?";
                // $client_id = $_SESSION['client_id'];
                $stmt1 = $conn->prepare($clientSql);
                $stmt1->bind_param("i", $client_id);
                $stmt1->execute();
                $clientData = $stmt1->get_result();
                $data =  $clientData->fetch_assoc();
                $name = $data['client_name'];
                ?>
            <div class="container-fluid">
                <!-- /# row -->
                <div id="main-content">
                <h2 class="mt-5">Website for Client ( <?php echo $name; ?> )</h2>
        <hr>
                    <form id="add-website-form">
    <div class="row">
        <!-- Project Name -->
        <div class="col-md-4">
    <div class="form-group">
        <label for="domain_name">Domain Name</label>
        <input type="text" name="domain_name" id="domain_name" class="form-control" placeholder="Domain Name">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="created_got_access">Created/Got Access (Y/N)</label>
        <select name="created_got_access" id="created_got_access" class="form-control">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="wireframe">Wireframe (Y/N)</label>
        <select name="wireframe" id="wireframe" class="form-control">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="website_design">Website Design (Y/N)</label>
        <select name="website_design" id="website_design" class="form-control">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="aptmt_system">Appointment System (Y/N)</label>
        <select name="aptmt_system" id="aptmt_system" class="form-control">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
</div>


<div class="col-md-4">
    <div class="form-group">
        <label for="reviews_widget">Reviews Widget (Y/N)</label>
        <select name="reviews_widget" id="reviews_widget" class="form-control">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="medical_seo">Medical SEO (Y/N)</label>
        <select name="medical_seo" id="medical_seo" class="form-control">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="technical_seo">Technical SEO (Y/N)</label>
        <select name="technical_seo" id="technical_seo" class="form-control">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="beta_website">Beta Website (Y/N)</label>
        <select name="beta_website" id="beta_website" class="form-control">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="website_testing">Website Testing (Y/N)</label>
        <select name="website_testing" id="website_testing" class="form-control">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="page_load_speed">Page Load Speed (Y/N)</label>
        <select name="page_load_speed" id="page_load_speed" class="form-control">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="website_score">Website Score (Y/N)</label>
        <select name="website_score" id="website_score" class="form-control">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
    </div>
</div>
    
      <!-- Client ID (Hidden) -->
      <div class="col-md-4">
            <input type="hidden" name="client_id" id="client_id" value="<?php echo ($client_id); ?>">
        </div>

    <div class="col-md-4">
        <input type="submit" value="Submit" class="btn btn-primary">
    </div>
</form>

    <div id="add-website-message"></div>
 
 
<div id="website-details-list"></div>
                    </div>
                </div>                    
                </div>
            </div>
            </div>
            <!-- end row-->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    2023 © DrSmart.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-right d-none d-sm-block">
               Made with Love: Praneeth
                    </div>
                </div>
            </div>
        </div>
    </footer>
    </div>
    <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!-- Overlay-->
    <div class="menu-overlay"></div>
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/metismenu.min.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/simplebar.min.js"></script>
    <!-- Sparkline Js-->
    <script src="../plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- Morris Js-->
    <script src="../plugins/morris-js/morris.min.js"></script>
    <!-- Raphael Js-->
    <script src="../plugins/raphael/raphael.min.js"></script>
    <!-- Custom Js -->
    <script src="assets/pages/dashboard-demo.js"></script>
    <!-- App js -->
    <script src="assets/js/theme.js"></script>
</body>
 
<script>
        $("#add-website-form").submit(function(event) {
    event.preventDefault();
    const formData = $(this).serialize(); // Serialize form data

    $.ajax({
        type: "POST",
        url: "add_website_action.php", // Your PHP script to handle the form submission
        data: formData,
        success: function(response) {
            $("#add-website-message").html(response);
            fetchDrDetails(); // Refresh the list of project details
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
});

$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: "fetch_website_details.php", // Adjust to your PHP script
        data: { client_id: $("#client_id").val() }, // Ensure client_id is being sent
        success: function(response) {
            // Populate the form fields with the response data
            $("input[name='domain_name']").val(response.domain_name);
$("select[name='created_got_access']").val(response.created_got_access);
$("select[name='wireframe']").val(response.wireframe);
$("select[name='website_design']").val(response.website_design);
$("select[name='aptmt_system']").val(response.aptmt_system);
$("select[name='reviews_widget']").val(response.reviews_widget);
$("select[name='medical_seo']").val(response.medical_seo);
$("select[name='technical_seo']").val(response.technical_seo);
$("select[name='beta_website']").val(response.beta_website);
$("select[name='website_testing']").val(response.website_testing);
$("select[name='page_load_speed']").val(response.page_load_speed);
$("select[name='website_score']").val(response.website_score);


        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
});



    </script>

 
</html>