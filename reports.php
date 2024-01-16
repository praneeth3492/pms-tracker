<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["manager_id"])) {
    header("Location: login.php");
    exit;
}
$manager_id = $_SESSION["manager_id"];
// Prepare and execute the query
$stmt = $conn->prepare("SELECT manager_name FROM managers WHERE manager_id = ?");
$stmt->bind_param("i", $manager_id);
$stmt->execute();
// Fetch the result
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $manager_name = $row["manager_name"];
} else {
    $manager_name = "Manager not found";
}
$client_id = $_GET['client_id'] ?? null;
$sum_values = [];
$client_data = [];
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from_year = $_POST['from_year'];
    $from_month = $_POST['from_month'];
    $to_year = $_POST['to_year'];
    $to_month = $_POST['to_month'];
    // SQL query
    $query = "SELECT  
SUM(search_views) AS total_search_views,
SUM(calls) AS total_calls,
SUM(directions) AS total_directions,
(google_reviews) AS total_google_reviews,
(average_ratings) AS total_average_ratings,
(review_responses) AS total_review_responses,
SUM(clicks) AS total_clicks,
(gbp_ranking) AS total_gbp_ranking,
(fb_followers) AS total_fb_followers,
(fb_engagement) AS total_fb_engagement,
(instagram_followers) AS total_instagram_followers,
(instagram_engagement) AS total_instagram_engagement,
SUM(medical_blogs) AS total_medical_blogs,
SUM(case_studies) AS total_case_studies,
SUM(promotional_videos) AS total_promotional_videos,
SUM(social_media_creatives) AS total_social_media_creatives,
(website_pagespeed) AS total_website_pagespeed,
SUM(backlinks) AS total_backlinks,
SUM(citations) AS total_citations,
SUM(website_security) AS total_website_security,
(website_performance) AS total_website_performance,
(website_accessibility) AS total_website_accessibility,
(website_best_practices) AS total_website_best_practices,
(keyword_text1) AS total_keyword_text1,
(keyword_ranking1) AS total_keyword_ranking1,
(keyword_text2) AS total_keyword_text2,
(keyword_ranking2) AS total_keyword_ranking2,
(keyword_text3) AS total_keyword_text3,
(keyword_ranking3) AS total_keyword_ranking3,
(keyword_text4) AS total_keyword_text4,
(keyword_ranking4) AS total_keyword_ranking4,
(keyword_text5) AS total_keyword_text5,
(keyword_ranking5) AS total_keyword_ranking5,
(keyword_text6) AS total_keyword_text6,
(keyword_ranking6) AS total_keyword_ranking6,
(keyword_text7) AS total_keyword_text7,
(keyword_ranking7) AS total_keyword_ranking7,
(keyword_text8) AS total_keyword_text8,
(keyword_ranking8) AS total_keyword_ranking8,
(website_seo) AS total_website_seo
           FROM client_performance
           WHERE ((year_id >= ? AND month_id >= ?) AND (year_id <= ? AND month_id <= ?)) and client_id=$client_id";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("iiii", $from_year, $from_month, $to_year, $to_month);
    $stmt->execute();
    $result = $stmt->get_result();
    $sum_values = $result->fetch_assoc();
    $stmt->close();
} else {
    // Handle error in query preparation
    echo "Error in query preparation: " . $conn->error;
}
}

if ($client_id) {
$sql = "SELECT * FROM client_performance WHERE client_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $client_data = $result->num_rows > 0 ? $result->fetch_assoc() : [];
    $stmt->close();
} else {
    // Handle error in query preparation
    echo "Error in query preparation: " . $conn->error;
}

$newq = "SELECT website_seo, website_best_practices, website_accessibility, 
                website_performance, website_pagespeed, instagram_engagement, 
                instagram_followers, fb_engagement, fb_followers, gbp_ranking, 
                review_responses, average_ratings, google_reviews, keyword_text1, keyword_ranking1,keyword_text2, keyword_ranking2,keyword_text3, keyword_ranking3,keyword_text4, keyword_ranking4,keyword_text5, keyword_ranking5,keyword_text6, keyword_ranking6,keyword_text7, keyword_ranking7,keyword_text8, keyword_ranking8
         FROM client_performance 
         WHERE ((year_id >= ? AND month_id >= ?) AND (year_id <= ? AND month_id <= ?)) 
         AND client_id = $client_id 
         ORDER BY year_id DESC, month_id DESC 
         LIMIT 1";



if ($stmt = $conn->prepare($newq)) {
    $stmt->bind_param("iiii", $from_year, $from_month, $to_year, $to_month);
    $stmt->execute();
    $resultq = $stmt->get_result();
    $latest_record = $resultq->fetch_assoc();
    $stmt->close();

    // Debugging
    // echo '<pre>'; var_dump($latest_record); echo '</pre>';
} else {
    // Handle error in query preparation
    echo "Error in query preparation: " . $conn->error;
}
//$row = mysql_fetch_assoc($result); 

//$maximum = $row['maximum'];




}

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Plugins css -->
        <link href="../plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />
    <style>

.number {
    font-size: 25px;
    font-style: italic;
    color: #333;
}

.spacer {
    margin-right: 0px; /* Adjust the space as needed */
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
                        <!--<button type="button" class="btn btn-primary d-none d-lg-block ml-2">-->
                        <!--    <i class="mdi mdi-pencil-outline mr-1"></i> Create Reports-->
                        <!--</button>-->
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
                                <span class="d-none d-sm-inline-block ml-1"><?php echo htmlspecialchars($manager_name); ?></span>
                                <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">

                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                    <span>Inbox</span>
                                    <span>
                                        <span class="badge badge-pill badge-success">3</span>
                                    </span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                    <span>Profile</span>
                                    <span>
                                        <span class="badge badge-pill badge-info">1</span>
                                    </span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                    Settings
                                </a>
                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                    <span>Lock Account</span>
                                </a>
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

        <form action="reports.php?client_id=<?php echo htmlspecialchars($client_id); ?>" method="post">
            <input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id; ?>">
            <!-- Add the necessary input fields for the client's data here with the pre-filled values -->
            <div class="row">           
              <div class="col-md-3">
    <div class="form-group">
    <label for="from_year">From Year:</label>
        <select name="from_year" id="from_year" class="form-control">
               <?php for ($i = 2023; $i <= 2025; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
    </div>
</div>
    <div class="col-md-3">
        <div class="form-group">
        <label for="from_month">From Month:</label>
            <select name="from_month" id="from_month" class="form-control">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0, 0, 0, $i, 10)); ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
        <label for="to_year">To Year:</label>
            <select name="to_year" id="to_year" class="form-control">
            <?php for ($i = 2023; $i <= 2025; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
        <label for="to_month">To Month:</label>
            <select name="to_month" id="to_month" class="form-control">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0, 0, 0, $i, 10)); ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div><br>
    <div class="col-md-2">
    <input type="submit" class="btn btn-primary d-none d-lg-block ml-2" value="Generate Report">   
    </div>
                <!-- Add the rest of the new fields here -->   
<div class="main" id="pdfContent">
<div class="row">
    <div class="col-sm-6"><div class="header">
    <img src="/reports/assets/images/logo_og.png" alt="Logo" style="width: 150px; height: auto;"> <!-- Adjust the path and style as needed -->
</div></div>

<div class="col-sm-6">
    <div class="date text-right">
        <h3><?php echo date("F d, Y"); ?></h3> <!-- Outputs date in format: Month 01, Year -->
    </div>
</div>                </div>
                           
<hr>
<h2 class="mt-5">Performance Report of   ( <?php echo $name; ?> )</h2> 
<?php 
if (!empty($from_month) && !empty($from_year) && !empty($to_month) && !empty($to_year)) {
    // Array mapping month numbers to month names
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March',
        4 => 'April',   5 => 'May',      6 => 'June',
        7 => 'July',    8 => 'August',   9 => 'September',
        10 => 'October', 11 => 'November', 12 => 'December'
    ];

    // Convert month numbers to month names
    $from_month_name = $months[(int)$from_month];
    $to_month_name = $months[(int)$to_month];

    echo "<h4>Date Range: $from_month_name $from_year - $to_month_name $to_year</h4>";
}
?>
 
        <hr>
                <div class="row mt-4">
                <div class="container-fluid" >
                    <h2 class="card-title">GOOGLE</h2>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3"> Search Views</h6>
                                            <p class="number">
                                            <?php echo $sum_values['total_search_views'] ?? ''; ?> <br></p>
                                           </span>
                                        </div>                                        
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/search.png" alt="Directions Icon" class="large-icon" />
                                        </div>
                                        </div>
                                    </div> <!-- end row -->                                     
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3"> 
Clicks:</h6><p class="number">
                                            <?php echo $sum_values['total_clicks'] ?? ''; ?></p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/clicks.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div>                                
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">Direction Requests</h6>
                                            <p class="number"> <?php echo $sum_values['total_directions'] ?? ''; ?></p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/directions.png" alt="Directions Icon" class="large-icon" />
                                        </div>
                                        </div>
                                    </div> <!-- end row -->                                  
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->


                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">Calls</h6>
                                            <p class="number"><?php echo $sum_values['total_calls'] ?? ''; ?></p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/phone_call2.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                 
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-3"> 
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">GBP Ranking</h6>
                                            <p class="number">   <?php echo $latest_record['gbp_ranking'] ?? ''; ?></p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/gbp.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                 
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">Google Reviews:</h6>
                                            <p class="number"> <?php echo $latest_record['google_reviews'] ?? ''; ?>
                                             
                                        </p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/google_reviews.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                 
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">Average Ratings:</h6>
                                            <p class="number"><?php echo $latest_record['average_ratings'] ?? ''; ?> </p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/rating.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                 
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">Review Responses:</h6>
                                            <p class="number"> 
                                                <?php echo $latest_record['review_responses'] ?? ''; ?>  </p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/review_response.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                 
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
            
                </div>
                </div>
                <br>

                <div class="container-fluid">
                    <h4 class="card-title">FACEBOOK & INSTAGRAM</h4>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3"> Facebook Followers</h6>
                                            <p class="number"> 
                                                
                                            <?php echo $latest_record['fb_followers'] ?? ''; ?> </p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/facebook.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                 
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3"> Facebook Engagement</h6>
                                            <p class="number"> 
                                            <?php echo $latest_record['fb_engagement'] ?? ''; ?>
                                             </p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/likes.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                  
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col--> 

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">Instagram Followers</h6>
                                            <p class="number"> 
                                            <?php echo $latest_record['instagram_followers'] ?? ''; ?>
                                                
                                        </p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/insta.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                 
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">Instagram Engagement</h6>
                                            <p class="number"> 
                                            <?php echo $latest_record['instagram_engagement'] ?? ''; ?> </p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/insta_followers.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                 
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        
                <div class="container-fluid">
                    <h4 class="card-title">OUTREACH/CONTENT  </h4>
                    <div class="row">
                    <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">Medical Blogs</h6>
                                            <p class="number"> <?php echo $sum_values['total_medical_blogs'] ?? ''; ?></p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/blog.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                  
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">
Case Studies</h6>
<p class="number">  <?php echo $sum_values['total_case_studies'] ?? ''; ?></p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/casestudies.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                     
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

               
 
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3"> Promo Videos</h6>
                                            <p class="number"><?php echo $sum_values['total_promotional_videos'] ?? ''; ?></p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/promotional_videos.png" alt="Directions Icon" class="large-icon" />
                                        </div>
                                        </div>
                                    </div> <!-- end row -->                                    
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3"> 
SM Creatives</h6>
<p class="number">   <?php echo $sum_values['total_social_media_creatives'] ?? ''; ?></p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/social_media_creatives.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                 
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col--> 

                        </div>
            </div>                       

                    </div>
                </div>
 
                <div class="container-fluid">
                    <h4 class="card-title">WEBSITE PERFORMANCE</h4>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3"> Website PageSpeed</h6>
                                            <p class="number">
                                            <?php echo $latest_record['website_pagespeed'] ?? ''; ?>  </p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/web_speed.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                   
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3"> Backlinks</h6>
                                            <p class="number"> 
                                                <?php echo $sum_values['total_backlinks'] ?? ''; ?></p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/backlinks.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row -->                                 
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">Citations</h6>
                                            <p class="number"> <?php echo $sum_values['total_citations'] ?? ''; ?></p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/citation.png" alt="Directions Icon" class="large-icon" />
                                        </div>                                      
                                    </div> <!-- end row -->
                                    </div> <!-- end row --> 
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->


                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">Website Security</h6>
                                            <p class="number"> <?php echo $sum_values['total_website_security'] ?? ''; ?></p>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon">
                                        <img src="assets/images/icons/web_security.png" alt="Directions Icon" class="large-icon" />
                                        </div>
                                        </div>
                                    </div> <!-- end row -->                                  
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                    </div>
                </div>

                <br><br><br><br>

               


              

                <div class="container-fluid">
                    <h4 class="card-title">WEBSITE SEO</h4>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3"> Performance</h6>
                                            <p class="number">   
                                            <?php echo $latest_record['website_performance'] ?? ''; ?>
                                             </p>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge badge-soft-success">      <?php echo $latest_record['website_performance'] ?? ''; ?></span>  <div class="chart-container">
    <canvas id="seoChart" style="height: 50px;"></canvas>
</div>
                                        </div>                                      
                                    </div> <!-- end row -->
                                    <div id="sparkline1" class="mt-3"></div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3"> Accessibility</h6>
                                            <p class="number"> 
                                            <?php echo $latest_record['website_accessibility'] ?? ''; ?>
                                             </p>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge badge-soft-success">        
                                            <?php echo $latest_record['website_accessibility'] ?? ''; ?>
                                            </span>
                                            <div class="chart-container">
    <canvas id="secondMetricChart" style="height: 50px;"></canvas>
</div>
                                        </div>
                                    </div> <!-- end row -->

                                    <div id="sparkline1" class="mt-3"></div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->



                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">Best Practices</h6>
                                            <p class="number">  <?php echo $latest_record['website_best_practices'] ?? ''; ?>   </p>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge badge-soft-success">
                                                <?php echo $latest_record['website_best_practices'] ?? ''; ?>
                                            </span> 
                                            <div class="chart-container">
    <canvas id="thirdMetricChart" style="height: 50px;"></canvas>
</div>
                                        </div>
                                    </div> <!-- end row -->

                                    <div id="sparkline1" class="mt-3"></div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        
                         


                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase font-size-12 text-muted mb-3">SEO</h6>

                                            <p class="number">  <?php echo $latest_record['website_seo'] ?? ''; ?>     </p>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge badge-soft-success">  <?php echo $latest_record['website_seo'] ?? ''; ?>  </span>
                                            <div class="chart-container">
                                            <canvas id="fourthMetricChart" style="height: 50px;"></canvas>
</div>
                                        </div>
                                    </div> <!-- end row -->

                           <div id="sparkline1" class="mt-3"></div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->  
                        </div> <!-- end col-->

                    </div>
                </div>
               

                <div class="container-fluid">
                    <h4 class="card-title">KEYWORD RANKING</h4>
                    <div class="row">


                <div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-uppercase font-size-12 text-muted mb-3">  <?php echo $latest_record['keyword_text1'] ?? ''; ?></h6>
                    <p class="number">
  
    <span class="spacer"></span>
    <?php echo $latest_record['keyword_ranking1'] ?? ''; ?>
</p>
                    <p class="number">   </p>
        
                </div>
                <div class="col-auto">
                    <div class="icon">
                        <!-- Icon for Keyword Text -->
                        <img src="assets/images/icons/keyword_icon.png" alt="Keyword Icon" class="large-icon" />
                    </div>
                </div>
            </div> <!-- end row -->                                  
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div> <!-- end col-->


<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-uppercase font-size-12 text-muted mb-3">  <?php echo $latest_record['keyword_text2'] ?? ''; ?></h6>
                    <p class="number">
  
    <span class="spacer"></span>
    <?php echo $latest_record['keyword_ranking2'] ?? ''; ?>
</p>
                    <p class="number">   </p>
        
                </div>
                <div class="col-auto">
                    <div class="icon">
                        <!-- Icon for Keyword Text -->
                        <img src="assets/images/icons/keyword_icon.png" alt="Keyword Icon" class="large-icon" />
                    </div>
                </div>
            </div> <!-- end row -->                                  
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div> <!-- end col-->
<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-uppercase font-size-12 text-muted mb-3">    <?php echo $latest_record['keyword_text3'] ?? ''; ?></h6>
                    <p class="number">

    <span class="spacer"></span>
    <?php echo $latest_record['keyword_ranking3'] ?? ''; ?>
</p>
                    <p class="number">   </p>
        
                </div>
                <div class="col-auto">
                    <div class="icon">
                        <!-- Icon for Keyword Text -->
                        <img src="assets/images/icons/keyword_icon.png" alt="Keyword Icon" class="large-icon" />
                    </div>
                </div>
            </div> <!-- end row -->                                  
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div> <!-- end col-->

<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-uppercase font-size-12 text-muted mb-3">   <?php echo $latest_record['keyword_text4'] ?? ''; ?></h6>
                    <p class="number">
 
    <span class="spacer"></span>
    <?php echo $latest_record['keyword_ranking4'] ?? ''; ?>
</p>
                    <p class="number">   </p>
        
                </div>
                <div class="col-auto">
                    <div class="icon">
                        <!-- Icon for Keyword Text -->
                        <img src="assets/images/icons/keyword_icon.png" alt="Keyword Icon" class="large-icon" />
                    </div>
                </div>
            </div> <!-- end row -->                                  
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div> <!-- end col-->

<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-uppercase font-size-12 text-muted mb-3">    <?php echo $latest_record['keyword_text5'] ?? ''; ?></h6>
                    <p class="number">

    <span class="spacer"></span>
    <?php echo $latest_record['keyword_ranking5'] ?? ''; ?>
</p>
                    <p class="number">   </p>
        
                </div>
                <div class="col-auto">
                    <div class="icon">
                        <!-- Icon for Keyword Text -->
                        <img src="assets/images/icons/keyword_icon.png" alt="Keyword Icon" class="large-icon" />
                    </div>
                </div>
            </div> <!-- end row -->                                  
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div> <!-- end col-->

<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-uppercase font-size-12 text-muted mb-3">  <?php echo $latest_record['keyword_text6'] ?? ''; ?></h6>
                    <p class="number">
  
    <span class="spacer"></span>
    <?php echo $latest_record['keyword_ranking6'] ?? ''; ?>
</p>
                    <p class="number">   </p>
        
                </div>
                <div class="col-auto">
                    <div class="icon">
                        <!-- Icon for Keyword Text -->
                        <img src="assets/images/icons/keyword_icon.png" alt="Keyword Icon" class="large-icon" />
                    </div>
                </div>
            </div> <!-- end row -->                                  
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div> <!-- end col-->

<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-uppercase font-size-12 text-muted mb-3"> <?php echo $latest_record['keyword_text7'] ?? ''; ?></h6>
                    <p class="number"> <?php echo $latest_record['keyword_ranking7'] ?? ''; ?> </p>
                    <p class="number">   </p>
        
                </div>
                <div class="col-auto">
                    <div class="icon">
                        <!-- Icon for Keyword Text -->
                        <img src="assets/images/icons/keyword_icon.png" alt="Keyword Icon" class="large-icon" />
                    </div>
                </div>
            </div> <!-- end row -->                                  
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div> <!-- end col-->

<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-uppercase font-size-12 text-muted mb-3"> <?php echo $latest_record['keyword_text8'] ?? ''; ?></h6>
                    <p class="number"> <?php echo $latest_record['keyword_ranking8'] ?? ''; ?> </p>
                    <p class="number">   </p>
        
                </div>
                <div class="col-auto">
                    <div class="icon">
                        <!-- Icon for Keyword Text -->
                        <img src="assets/images/icons/keyword_icon.png" alt="Keyword Icon" class="large-icon" />
                    </div>
                </div>
            </div> <!-- end row -->                                  
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div> <!-- end col-->
</div>
                </div>

 


                <div class="col-sm-6">
                <h4>Reporting  Manager: <?php echo htmlspecialchars($manager_name); ?></h4>
            </div>

                </div>
            </div> 
        </div>        
       
    </div></div> </div>
    <button id="generatePdfButton" class="btn btn-primary d-none d-lg-block ml-2">Generate PDF</button>
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
                                Made with Love :  Praneeth
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</body>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {     
        document.getElementById('generatePdfButton').addEventListener('click', (e) => {
            e.preventDefault(); // Prevent default action       

            // Get client name and current date
            var clientName = '<?php echo $name; ?>'; // Replace 'client_name' with the actual client name variable
            var currentDate = new Date().toISOString().slice(0, 10); // Format: YYYY-MM-DD

            // Create the filename
            var filename = clientName + '_' + currentDate + '.pdf';
            var element = document.getElementById('pdfContent');  

            html2pdf(element, {
                margin: 10,
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            }).catch(function(error) {
                console.error('Error generating PDF:', error);
            });
        });
    });
</script> 
<script>
    document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
</script>

<script>
    // SEO Chart
    var totalSeoValue = <?php echo json_encode($latest_record['website_performance'] ?? 0); ?>;
    createDonutChart('seoChart', totalSeoValue, '#4caf50');
    // Second Metric Chart
    var totalSecondMetricValue = <?php echo json_encode($latest_record['website_accessibility'] ?? 0); ?>;
    createDonutChart('secondMetricChart', totalSecondMetricValue, '#ff9800');
    // Third Metric Chart
    var totalThirdMetricValue = <?php echo json_encode($latest_record['website_best_practices'] ?? 0); ?>;
    createDonutChart('thirdMetricChart', totalThirdMetricValue, '#2196f3');
    // Fourth Metric Chart
    var totalFourthMetricValue = <?php echo json_encode($latest_record['website_seo'] ?? 0); ?>;
    createDonutChart('fourthMetricChart', totalFourthMetricValue, '#9c27b0');

    function createDonutChart(canvasId, totalValue, color) {
        var ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [totalValue, 100 - totalValue],
                    backgroundColor: [color, '#e9ecef'],
                    borderWidth: 1
                }]
            },
            options: {
                cutout: '80%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
</script>
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
                   
                    $("#directions").val(data.directions);
                    $("#google_reviews").val(data.google_reviews);
                    $("#average_ratings").val(data.average_ratings);
                    $("#review_responses").val(data.review_responses);
                    $("#geo_grid_rankings").val(data.geo_grid_rankings);
                    $("#online_authority").val(data.online_authority);
                    $("#fb_likes").val(data.fb_likes);
                    $("#fb_shares").val(data.fb_shares);
                    $("#fb_reach").val(data.fb_reach);
                    $("#instagram_followers").val(data.instagram_followers);
                    $("#instagram_engagement").val(data.instagram_engagement);
                    $("#instagram_reach").val(data.instagram_reach);
                    $("#monthly_posts").val(data.monthly_posts);
                    $("#citations").val(data.citations);
                    $("#medical_blogs").val(data.medical_blogs);
                    $("#animation_videos").val(data.animation_videos);
                    $("#testimonial_videos").val(data.testimonial_videos);
                    $("#educational_videos").val(data.educational_videos);
                    $("#case_studies").val(data.case_studies);
                    $("#website_performance").val(data.website_performance);
                    $("#website_accessibility").val(data.website_accessibility);
                    $("#website_best_practices").val(data.website_best_practices);
                    $("#website_seo").val(data.website_seo);
                    $("#keyword_rankings").val(data.keyword_rankings);
                    $("#keyword_text1").val(data.keyword_text1);
                    $("#keyword_ranking1").val(data.keyword_ranking1);
                    $("#keyword_text2").val(data.keyword_text2);
                    $("#keyword_ranking2").val(data.keyword_ranking2);
                    $("#keyword_text3").val(data.keyword_text3);
                    $("#keyword_ranking3").val(data.keyword_ranking3);
                    $("#keyword_text4").val(data.keyword_text4);
                    $("#keyword_ranking4").val(data.keyword_ranking4);
                    $("#keyword_text5").val(data.keyword_text5);
                    $("#keyword_ranking5").val(data.keyword_ranking5);
                    $("#keyword_text6").val(data.keyword_text6);
                    $("#keyword_ranking6").val(data.keyword_ranking6);
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
    // Run this code when the DOM is fully loaded
    </script>
</html>