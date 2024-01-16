<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["manager_id"])) {
    header("Location: login.php");
    exit;
}

$client_id = $_GET['client_id'];

// Fetch the client's data from the database if necessary
$sql = "SELECT * FROM client_performance WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
$client_data = [];

if ($result->num_rows > 0) {
    $client_data = $result->fetch_assoc();
}

$stmt->close();
// $conn->close();

$manager_id = $_SESSION["manager_id"];

// Fetch the manager's data
$sql = "SELECT * FROM managers WHERE manager_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $manager_id);
$stmt->execute();
$result = $stmt->get_result();
$manager_data = $result->fetch_assoc();
$stmt->close();

// Fetch the manager's name from the database
$sql = "SELECT manager_name FROM managers WHERE manager_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $manager_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $manager_name = $row['manager_name'];
    }
} else {
    $manager_name = "Unknown Manager"; // Default value in case no manager is found with the given ID
}

$stmt->close();

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

        <!-- Plugins css -->
        <link href="../plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />
    <style>.title {
    font-weight: bold;
    font-style: normal;
    font-family: Arial, sans-serif;
    font-size: 18px; /* Example font size */
    color: #333; /* Example text color, a dark gray */
    margin-bottom: 10px; /* Example spacing below the title */
}
        </style>

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
                <?php include 'sidebar.php'; ?>

            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
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
                <h2 class="mt-5">Edit Fields for Client <?php echo $name; ?></h2>
        <hr>

        <form action="update_fields.php" method="post" id="add-fields-form">
            <input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id; ?>">

            <!-- Add the necessary input fields for the client's data here with the pre-filled values -->
            <div class="row">

            <?php
            $sql = "SELECT * FROM months";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            $performanceSql = "SELECT * from client_performance WHERE client_id = ?";
            $stmt1 = $conn->prepare($performanceSql);
            $stmt1->bind_param("i", $client_id);
            $stmt1->execute();
            $resultPerformance = $stmt1->get_result();

            $disabled = '';

            if ($resultPerformance->num_rows > 0) {
                $disabled = 'disabled';
            }

            ?>
              


                

<div class="container">
<div class="row">
<div class="col-md-4">
    <div class="form-group">
        <label for="month_id">Month</label>
        <select name="month_id" id="month_id" class="form-control">
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0, 0, 0, $i, 10)); ?></option>
            <?php endfor; ?>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="year_id">Year</label>
        <select name="year_id" id="year_id" class="form-control">
            <?php for ($i = 2023; $i <= 2025; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
    </div>
</div>
</div>
    <!-- GOOGLE Section -->
    <h4 class="card-title">GOOGLE</h4>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="search_views">Search Views:</label>
                <input type="number" class="form-control" id="search_views" name="search_views" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="clicks">Clicks:</label>
                <input type="number" class="form-control" id="clicks" name="clicks" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="directions">Directions:</label>
                <input type="number" class="form-control" id="directions" name="directions" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="calls">Calls:</label>
                <input type="number" class="form-control" id="calls" name="calls" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="gbp_ranking">GBP Ranking:</label>
                <input type="number" class="form-control" id="gbp_ranking" name="gbp_ranking" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="google_reviews">Google Reviews:</label>
                <input type="number" class="form-control" id="google_reviews" name="google_reviews" value="">
            </div>
        </div>
        <div class="col-md-3">
    <div class="form-group">
        <label for="average_ratings">Average Ratings:</label>
        <input type="number" class="form-control" id="average_ratings" name="average_ratings" step="0.01" min="0" max="999.99">
    </div>
</div>


        <div class="col-md-3">
            <div class="form-group">
                <label for="review_responses">Review Responses:</label>
                <input type="number" class="form-control" id="review_responses" name="review_responses" value="">
            </div>
        </div>
    </div>

    <!-- FACEBOOK & INSTAGRAM Section -->
    <h4 class="card-title">FACEBOOK & INSTAGRAM</h4>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="fb_followers">Facebook Followers:</label>
                <input type="number" class="form-control" id="fb_followers" name="fb_followers" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="fb_engagement">Facebook Engagement:</label>
                <input type="number" class="form-control" id="fb_engagement" name="fb_engagement" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="instagram_followers">Instagram Followers:</label>
                <input type="number" class="form-control" id="instagram_followers" name="instagram_followers" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="instagram_engagement">Instagram Engagement:</label>
                <input type="number" class="form-control" id="instagram_engagement" name="instagram_engagement" value="">
            </div>
        </div>
    </div>

    <!-- OUTREACH/CONTENT Section -->
    <h4 class="card-title">OUTREACH/CONTENT</h4>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="medical_blogs">Medical Blogs:</label>
                <input type="number" class="form-control" id="medical_blogs" name="medical_blogs" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="case_studies">Case Studies:</label>
                <input type="number" class="form-control" id="case_studies" name="case_studies" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="promotional_videos">Promotional Videos:</label>
                <input type="number" class="form-control" id="promotional_videos" name="promotional_videos" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="social_media_creatives">Social Media Creatives:</label>
                <input type="number" class="form-control" id="social_media_creatives" name="social_media_creatives" value="">
            </div>
        </div>
    </div>

    <!-- WEBSITE PERFORMANCE Section -->
    <h4 class="card-title">WEBSITE PERFORMANCE</h4>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="website_pagespeed">Website PageSpeed:</label>
                <input type="number" class="form-control" id="website_pagespeed" name="website_pagespeed" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="backlinks">Backlinks:</label>
                <input type="number" class="form-control" id="backlinks" name="backlinks" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="citations">Citations:</label>
                <input type="number" class="form-control" id="citations" name="citations" value="">
            </div>
        </div>
      

    <div class="col-md-3">
            <div class="form-group">
                <label for="citations">Website Security:</label>
                <input type="number" class="form-control" id="website_security" name="website_security" value="">
            </div>
        </div>
    </div>

    <!-- WEBSITE SEO Section -->
    <h4 class="card-title">WEBSITE SEO</h4>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="website_performance">Website Performance:</label>
                <input type="number" class="form-control" id="website_performance" name="website_performance" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="website_accessibility">Website Accessibility:</label>
                <input type="number" class="form-control" id="website_accessibility" name="website_accessibility" value="">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="website_best_practices">Website Best Practices:</label>
                <input type="number" class="form-control" id="website_best_practices" name="website_best_practices" value="">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="website_seo">Website SEO:</label>
                <input type="number" class="form-control" id="website_seo" name="website_seo" value="">
            </div>
        </div>
    </div>
         
 

 
            <h4 class="card-title">Keywords</h4>
<div class="row">
    <?php for ($i = 1; $i <= 8; $i++): ?>
        <div class="col-md-3">
            <div class="form-group">
                <label for="keyword_text<?php echo $i; ?>">Keyword Text <?php echo $i; ?>:</label>
                <input type="text" class="form-control" id="keyword_text<?php echo $i; ?>" name="keyword_text<?php echo $i; ?>" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="keyword_ranking<?php echo $i; ?>">Keyword Ranking <?php echo $i; ?>:</label>
                <input type="number" class="form-control" id="keyword_ranking<?php echo $i; ?>" name="keyword_ranking<?php echo $i; ?>" value="">
            </div>
        </div>
    <?php endfor; ?>
 
            

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="manager_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>

                   
                  

                </div>
            </div>
        </div>
    </div></div> 
                        
    </div>              

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
    $(document).ready(function() {
        // Trigger the AJAX call when either the month or year dropdown changes
        $("select[name='month_id'], select[name='year_id']").change(function(event) {
            event.preventDefault();

            const month = $("select[name='month_id']").val();
            const year = $("select[name='year_id']").val();
            const clientId = $("#client_id").val(); // Make sure this ID matches your client ID input

            $.ajax({
                type: "POST",
                url: "fetch_client_performance_by_month2.php",
                data: { month: month, year: year, client_id: clientId },
                dataType: "json",
                success: function(data) {
                    // Populate the input fields with the fetched data
                    $("#search_views").val(data.search_views);
                    $("#calls").val(data.calls);
                    $("#directions").val(data.directions);
                    $("#google_reviews").val(data.google_reviews);
                    $("#average_ratings").val(data.average_ratings);
                    $("#review_responses").val(data.review_responses);

                    // New fields
                    $("#clicks").val(data.clicks);
                    $("#gbp_ranking").val(data.gbp_ranking);
                    $("#fb_followers").val(data.fb_followers);
                    $("#fb_engagement").val(data.fb_engagement);
                    $("#instagram_followers").val(data.instagram_followers);
                    $("#instagram_engagement").val(data.instagram_engagement);
                    $("#promotional_videos").val(data.promotional_videos);
                    $("#social_media_creatives").val(data.social_media_creatives);
                    $("#website_pagespeed").val(data.website_pagespeed);
                    $("#backlinks").val(data.backlinks);
                    $("#website_security").val(data.website_security);
                    $("#citations").val(data.citations);

                    $("#medical_blogs").val(data.medical_blogs);
                    $("#case_studies").val(data.case_studies);
                    $("#website_performance").val(data.website_performance);
                    $("#website_accessibility").val(data.website_accessibility);
                    $("#website_best_practices").val(data.website_best_practices);
                    $("#website_seo").val(data.website_seo);

                    $("#keyword_text1").val(data.keyword_text1);
                    $("#keyword_ranking1").val(data.keyword_ranking1);

                    $("#keyword_text2").val(data.keyword_text2);
                    $("#keyword_ranking2").val(data.keyword_ranking2);

                    $("#keyword_text3").val(data.keyword_text3);
                    $("#keyword_ranking3").val(data.keyword_ranking3);

       
                    $("#keyword_ranking4").val(data.keyword_ranking4);
                    $("#keyword_text4").val(data.keyword_text4);

                    $("#keyword_ranking5").val(data.keyword_ranking5);
                    $("#keyword_text5").val(data.keyword_text5);

                    $("#keyword_ranking6").val(data.keyword_ranking6);
                    $("#keyword_text6").val(data.keyword_text6);

               
                    $("#keyword_text7").val(data.keyword_text7);
                    $("#keyword_ranking7").val(data.keyword_ranking7);
                    
                    $("#keyword_text8").val(data.keyword_text8);
                    $("#keyword_ranking8").val(data.keyword_ranking8);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    }); 
</script>


</html>