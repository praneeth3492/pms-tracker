<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["manager_id"])) {
    header("Location: login.php");
    exit;
}
$client_id = $_GET['client_id'];
$manager_id = $_SESSION["manager_id"];
//getting task
$sql = "SELECT * FROM client_manager WHERE client_id = ? and manager_id = $manager_id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
 
$stmt->execute();
$result = $stmt->get_result();
$TaskDetails = [];

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $TaskDetails[0] = $row['tasks_id1'];
        $TaskDetails[1] = $row['tasks_id2'];
        $TaskDetails[2] = $row['tasks_id3'];
        $TaskDetails[3] = $row['tasks_id4'];
        $TaskDetails[4] = $row['tasks_id5'];
        $TaskDetails[5] = $row['tasks_id6'];
        $TaskDetails[6] = $row['tasks_id7'];
        $TaskDetails[7] = $row['tasks_id8'];
    }
}
 

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


<?php
session_start();
if (!isset($_SESSION['manager_id']) || !isset($_SESSION['manager_name'])) {
    header("Location: login.php");
    exit;
}
require_once "config.php";
$client_id = $_GET['client_id'];
$fields = [
    'project_name', 'project_logo', 'project_type', 'domain_names', 
    'mobile_no', 'locations', 'whatsapp_no', 'addresses', 
    'extinct_photos', 'team_size', 'equip_photos', 'credentials', 
    'list_of_services', 'website', 'gmb_accounts', 'facebook_yn', 
    'instagram_yn', 'youtube_yn'
];

// Query to fetch project details
$sql = "SELECT * FROM project_details WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Count non-empty fields
    $filledFields = 0;
    foreach ($fields as $field) {
        if (!empty($row[$field])) {
            $filledFields++;
        }
    }

    // Calculate percentage
    $totalFields = count($fields);
 
    $project_details_percentage = round(($filledFields / $totalFields) * 100);
} else {
    // Handle case where no project details are found
    $project_details_percentage = 0;
}

// Close statement and connection if necessary
$stmt->close();
// $conn->close();

$client_id = $_GET['client_id'];// Assuming you use 'dr_id' as the identifier
$fields = [
    'dr_name', 'qualifications', 'specialisation', 'expertise', 'experience', 
    'dr_photos', 'dr_resume', 'insurance', 'facilities', 'diagnostics', 
    'health_packages', 'multiple_gbp', 'multiple_dr', 'project_start_date', 
    'proposed_launch_date'
];

// Query to fetch doctor details
$sql = "SELECT * FROM drs_details WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Count non-empty fields
    $filledFields = 0;
    foreach ($fields as $field) {
        if (!empty($row[$field])) {
            $filledFields++;
        }
    }

    // Calculate percentage
    $totalFields = count($fields);
    $drs_details_percentage = round(($filledFields / $totalFields) * 100);
} else {
    // Handle case where no doctor details are found
    $drs_details_percentage = 0;
}

// Close statement and connection if necessary
$stmt->close();
// $conn->close();

$client_id = $_GET['client_id'];

// Define the fields in the content_development table
$fields = [
    't10_keywords', 'website_content', 'medical_blogs', 'reviews_content', 
    'review_replies', 'sm_master_file', 'sm_oneliners', 'supporting_text', 
    'hashtags', 'gmb_descriptions', 'gmb_qa', 'fb_page_descriptions', 
    'video_scripts'
];

// Query to fetch content development details
$sql = "SELECT * FROM content_development WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Count non-empty fields
    $filledFields = 0;
    foreach ($fields as $field) {
        if (!empty($row[$field])) {
            $filledFields++;
        }
    }

    // Calculate percentage
    $totalFields = count($fields);
    $content_development_percentage = round(($filledFields / $totalFields) * 100);
} else {
    // Handle case where no content development details are found
    $content_development_percentage = 0;
}

// Close statement and connection if necessary
$stmt->close();

$client_id = $_GET['client_id']; // Ensure this is the correct identifier for your use case
$fields = [
    'gbp', 'existing', 'new', 'connected_email', 'optimisation_gmb', 
    'gmb_links', 'fb_page', 'optimisation_fb', 'fb_page_link', 'instagram', 
    'optimisation_instagram', 'instagram_link', 'fb_instagram_connection', 
    'youtube_channel', 'optimisation_youtube', 'youtube_channel_link', 
    'publer', 'oviond'
];

// Query to fetch access optimise details
$sql = "SELECT * FROM access_optimise WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Count non-empty fields
    $filledFields = 0;
    foreach ($fields as $field) {
        if (!empty($row[$field])) {
            $filledFields++;
        }
    }

    // Calculate percentage
    $totalFields = count($fields);
    $access_optimise_percentage = round(($filledFields / $totalFields) * 100);
} else {
    // Handle case where no access optimise details are found
    $access_optimise_percentage = 0;
}

// Close statement and connection if necessary
$stmt->close();

$client_id = $_GET['client_id']; // Ensure this is the correct identifier for your use case
$fields = [
    'website_speed', 'website_score', 'appointment_system', 'website_backlinks', 
    'online_citations', 'medical_blogs', 'case_studies', 'promotional_videos', 
    'gbp_rank', 'google_reviews', 'reviews_rating', 'search_views', 
    'profile_clicks', 'driving_directions', 'phone_calls', 'fb_followers', 
    'instagram_followers', 'youtube_videos_ranking', 't10_keywords_rankings'
];

// Query to fetch project insights details
$sql = "SELECT * FROM project_insights WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Count non-empty fields
    $filledFields = 0;
    foreach ($fields as $field) {
        if (!empty($row[$field])) {
            $filledFields++;
        }
    }

    // Calculate percentage
    $totalFields = count($fields);
    $project_insights_percentage = round(($filledFields / $totalFields) * 100);
} else {
    // Handle case where no project insights details are found
    $project_insights_percentage = 0;
}

// Close statement and connection if necessary
$stmt->close();

$client_id = $_GET['client_id']; // Ensure this is the correct identifier for your use case
$fields = [
    'domain_name', 'created_got_access', 'wireframe', 'website_design', 
    'aptmt_system', 'reviews_widget', 'medical_seo', 'technical_seo', 
    'beta_website', 'website_testing', 'page_load_speed', 'website_score'
];

// Query to fetch website details
$sql = "SELECT * FROM website WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Count non-empty fields
    $filledFields = 0;
    foreach ($fields as $field) {
        if (!empty($row[$field])) {
            $filledFields++;
        }
    }

    // Calculate percentage
    $totalFields = count($fields);
    $website_percentage = round(($filledFields / $totalFields) * 100);
} else {
    // Handle case where no website details are found
    $website_percentage = 0;
}

// Close statement and connection if necessary
$stmt->close();
$client_id = $_GET['client_id']; // Ensure this is the correct identifier for your use case
$fields = [
    'client_check_list', 'website_launch_date', 'sm_posts_blueprint', 
    'sm_posts_scheduling', 'project_launch_date', 'welcome_kit', 'client_sign_off'
];
// Query to fetch project_launch details
$sql = "SELECT * FROM project_launch WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Count non-empty fields
    $filledFields = 0;
    foreach ($fields as $field) {
        if (!empty($row[$field])) {
            $filledFields++;
        }
    }
    // Calculate percentage
    $totalFields = count($fields);
    $project_launch_percentage = round(($filledFields / $totalFields) * 100);
} else {
    // Handle case where no project_launch details are found
    $project_launch_percentage = 0;
}
// Close statement and connection if necessary
$stmt->close();
?>
<!-- HTML and rest of your PHP code goes here... -->
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
.project-box {
    background-color: #f5f5f5;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    min-height: 200px; /* Adjust as needed */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.project-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
}
.project-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
    text-align: center;
}
.circular-progress {
    position: relative;
    width: 80px; /* Adjust the size as needed */
    height: 80px;
    margin-bottom: 10px;
}
.circular-chart {
    width: 100%;
    height: 100%;
}
.circle-bg {
    fill: none;
    stroke: #e6e6e6;
    stroke-width: 2;
}
.circle {
    fill: none;
    stroke: #4caf50; /* You can choose a different color if you prefer */
    stroke-width: 2;
    stroke-linecap: round;
    transition: stroke-dasharray 0.3s ease;
}
.project-description {
    font-size: 14px;
    color: #666;
    margin-top: 10px;
}
/* Additional styles for different card types */
.project-box.project-details { background-color: #AEBDCA; }
.project-box.project-insights { background-color: #F0EBE3; }
.project-box.drs-details  { background-color: #AEBDCA; }
.project-box.access-optimize { background-color: #F0EBE3; }
.project-box.website { background-color: #AEBDCA; }
.project-box.project-launch { background-color: #F0EBE3; }
.project-box.quality-check { background-color: #AEBDCA; }
.percentage-bar {
    background-color: #f0e5d8;
    height: 10px;
    width: 100%;
    position: relative;
    border-radius: 5px;
}
.percentage-fill {
    background-color: #000000;
    height: 100%;
    position: absolute;
    border-radius: 5px;
}
/* Style the cards */
.card {
    border: 1px solid #ddd;
    padding: 20px;
    text-align: center;
    margin-bottom: 20px;
}

.card h4 {
    font-weight: bold;
    margin-bottom: 10px;
}

.card p.text-center {
    color: #777;
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
<div class="card-container">  
<!-- Cards go here -->
                <div class="row">
                <?php
                 if (str_contains($TaskDetails[3],'project_details')){
                ?> 
                <div class="col-md-12">
    <div class="project-box project-details justify-content-center align-items-center">
        <a href="project_details.php?client_id=<?php echo htmlspecialchars($client_id); ?>">
            <h3 class="project-title">Project Details</h3>
        </a>
        <div class="percentage-bar">
            <div class="percentage-fill" style="width: <?php echo $project_details_percentage; ?>%;"></div>
        </div>
        <p class="project-description"><?php echo $project_details_percentage; ?>%</p>
    </div>
</div>

<?php
                 }
 ?> 

<?php
                 if (str_contains($TaskDetails[2],'drs_details')){
                ?> 
<div class="col-md-12">
    <div class="project-box drs-details justify-content-center align-items-center">
        <a href="drs_details.php?client_id=<?php echo htmlspecialchars($client_id); ?>">
            <h3 class="project-title">Dr/s Details</h3>
        </a>
        <div class="percentage-bar">
        <div class="percentage-fill" style="width: <?php echo $drs_details_percentage; ?>%;"></div>
        </div>
        <p class="project-description"><?php echo $drs_details_percentage; ?>%</p>
    </div>
</div>
<?php
                 }
 ?> 

                <?php
                 if (str_contains($TaskDetails[0],'access_optimise')){
                ?> 
<div class="col-md-12">
    <div class="project-box access-optimize justify-content-center align-items-center">
    <a href="access_optimise.php?client_id=<?php echo htmlspecialchars($client_id); ?>">     
            <h3 class="project-title">Access & Optimize</h3>
        </a>
        <div class="percentage-bar">
        <div class="percentage-fill" style="width: <?php echo $access_optimise_percentage; ?>%;"></div>
        </div>
        <p class="project-description"><?php echo $access_optimise_percentage; ?>%</p>
        
    </div>
</div>

<?php
                 }
 ?> 

<?php
                 if (str_contains($TaskDetails[4],'project_insights')){
                ?> 

<div class="col-md-12">
    <div class="project-box project-insights justify-content-center align-items-center">
        <a href="project_insights.php?client_id=<?php echo htmlspecialchars($client_id); ?>">
            <h3 class="project-title">Project Insights</h3>
        </a>
        <div class="percentage-bar">
        <div class="percentage-fill" style="width: <?php echo $project_insights_percentage; ?>%;"></div>
        </div>
        <p class="project-description"><?php echo $project_insights_percentage; ?>%</p>
    </div>
</div>
<?php
                 }
 ?> 
  <?php
                 if (str_contains($TaskDetails[1],'content_development')){
                ?> 
<div class="col-md-12">
    <div class="project-box project-launch justify-content-center align-items-center">
        <a href="content_development.php?client_id=<?php echo htmlspecialchars($client_id); ?>">
            <h3 class="project-title">Content Development </h3>
        </a>
        <div class="percentage-bar">
        <div class="percentage-fill" style="width: <?php echo $content_development_percentage; ?>%;"></div>
        </div>
        <p class="project-description"><?php echo $content_development_percentage; ?>%</p>
    </div>
</div> 


<?php
                 }
 ?> 
  <?php
                 if (str_contains($TaskDetails[7],'website')){
                ?> 
<div class="col-md-12">
    <div class="project-box website justify-content-center align-items-center">
        <a href="website.php?client_id=<?php echo htmlspecialchars($client_id); ?>">
            <h3 class="project-title">Website</h3>
        </a>
        <div class="percentage-bar">
        <div class="percentage-fill" style="width: <?php echo $website_percentage; ?>%;"></div>
        </div>
        <p class="project-description"><?php echo $website_percentage; ?>%</p>
    </div>
</div>
<?php
                 }
 ?> 
  <?php
                 if (str_contains($TaskDetails[6],'quality_check')){
                ?> 
<div class="col-md-12">
    <div class="project-box quality-check justify-content-center align-items-center">
        <a href="quality_check.php?client_id=<?php echo htmlspecialchars($client_id); ?>">
            <h3 class="project-title">Quality Check</h3>
        </a>
        <div class="percentage-bar">
        <div class="percentage-fill" style="width: <?php echo $quality_check_percentage; ?>%;"></div>
        </div>
        <p class="project-description"><?php echo $quality_check_percentage; ?>%</p>
    </div>
</div>
<?php
                 }
 ?> 
  <?php
                 if (str_contains($TaskDetails[5],'project_launch')){
                ?> 
<div class="col-md-12">
    <div class="project-box project-launch justify-content-center align-items-center">
        <a href="project_launch.php?client_id=<?php echo htmlspecialchars($client_id); ?>">
            <h3 class="project-title">Project Launch</h3>
        </a>
        <div class="percentage-bar">
        <div class="percentage-fill" style="width: <?php echo $project_launch_percentage; ?>%;"></div>
        </div>
        <p class="project-description"><?php echo $project_launch_percentage; ?>%</p>
    </div>
</div>
<?php
                 }
 ?> 
        </div></div>  
        </form>
                </div>
            </div>
        </div>
    </div></div>                         
    </div>      </div> <!-- container-fluid -->
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

    


</html>