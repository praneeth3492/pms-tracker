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
                <h2 class="mt-5">Project Details for Client ( <?php echo $name; ?> )</h2>
        <hr>
                    <form id="add-project-details-form">
    <div class="row">
        <!-- Project Name -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="project_name">Project Name</label>
                <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Project Name" value="<?php echo $name; ?>" >
            </div>
        </div>

        <!-- Project Logo URL -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="project_logo">Project Logo URL</label>
                <input type="text" name="project_logo" id="project_logo" class="form-control" placeholder="Project Logo URL" value="<?php echo isset($project_data['project_logo']) ? $project_data['project_logo'] : ''; ?>">
            </div>
        </div>

        <!-- Project Type -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="project_type">Project Type</label>
                <select name="project_type" id="project_type" class="form-control">
                    <option value="type1" <?php echo (isset($project_data['project_type']) && $project_data['project_type'] == 'type1') ? 'selected' : ''; ?>>Type 1</option>
                    <option value="type2" <?php echo (isset($project_data['project_type']) && $project_data['project_type'] == 'type2') ? 'selected' : ''; ?>>Type 2</option>
                    <!-- Add other project types as needed -->
                </select>
            </div>
        </div>

        <!-- Domain Names -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="domain_names">Domain Names</label>
                <input type="text" name="domain_names" id="domain_names" class="form-control" placeholder="Domain Names" value="<?php echo isset($project_data['domain_names']) ? $project_data['domain_names'] : ''; ?>">
            </div>
        </div>

        <!-- Mobile No -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="mobile_no">Mobile No</label>
                <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Mobile No" value="<?php echo isset($project_data['mobile_no']) ? $project_data['mobile_no'] : ''; ?>">
            </div>
        </div>

        <!-- Locations -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="locations">Locations</label>
                <input type="text" name="locations" id="locations" class="form-control" placeholder="Locations" value="<?php echo isset($project_data['locations']) ? $project_data['locations'] : ''; ?>">
            </div>
        </div>

        <!-- WhatsApp No -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="whatsapp_no">WhatsApp No</label>
                <input type="text" name="whatsapp_no" id="whatsapp_no" class="form-control" placeholder="WhatsApp No" value="<?php echo isset($project_data['whatsapp_no']) ? $project_data['whatsapp_no'] : ''; ?>">
            </div>
        </div>

        <!-- Addresses -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="addresses">Addresses</label>
                <input type="text" name="addresses" id="addresses" class="form-control" placeholder="Addresses" value="<?php echo isset($project_data['addresses']) ? $project_data['addresses'] : ''; ?>">
            </div>
        </div>

        <!-- Extinct Photos URL -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="extinct_photos">Extinct Photos Canva URL</label>
                <input type="text" name="extinct_photos" id="extinct_photos" class="form-control" placeholder="Extinct Photos URL" value="<?php echo isset($project_data['extinct_photos']) ? $project_data['extinct_photos'] : ''; ?>">
            </div>
        </div>

        <!-- Team Size -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="team_size">Team Size</label>
                <input type="number" name="team_size" id="team_size" class="form-control" placeholder="Team Size" value="<?php echo isset($project_data['team_size']) ? $project_data['team_size'] : ''; ?>">
            </div>
        </div>

        <!-- Equipment Photos URL -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="equip_photos">Equipment Photos Canva URL</label>
                <input type="text" name="equip_photos" id="equip_photos" class="form-control" placeholder="Equipment Photos URL" value="<?php echo isset($project_data['equip_photos']) ? $project_data['equip_photos'] : ''; ?>">
            </div>
        </div>

        <!-- Credentials -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="credentials">Counter Info</label>
                <input type="text" name="credentials" id="credentials" class="form-control" placeholder="Counter Info" value="<?php echo isset($project_data['credentials']) ? $project_data['credentials'] : ''; ?>">
            </div>
        </div>

        <!-- List of Services -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="list_of_services">List of Services</label>
                <input type="text" name="list_of_services" id="list_of_services" class="form-control" placeholder="List of Services" value="<?php echo isset($project_data['list_of_services']) ? $project_data['list_of_services'] : ''; ?>">
            </div>
        </div>

        <!-- Website -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="website">Website</label>
                <input type="text" name="website" id="website" class="form-control" placeholder="Website" value="<?php echo isset($project_data['website']) ? $project_data['website'] : ''; ?>">
            </div>
        </div>
</div>
<div class="row">
        <!-- GMB Accounts Checkbox -->
        <div class="col-md-3">
            <div class="form-group form-check">
                <input type="checkbox" name="gmb_accounts" id="gmb_accounts" class="form-check-input" <?php echo isset($project_data['gmb_accounts']) && $project_data['gmb_accounts'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="gmb_accounts">GMB Accounts</label>
            </div>
        </div>

        <!-- Facebook Checkbox -->
        <div class="col-md-3">
            <div class="form-group form-check">
                <input type="checkbox" name="facebook_yn" id="facebook_yn" class="form-check-input" <?php echo isset($project_data['facebook_yn']) && $project_data['facebook_yn'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="facebook_yn">Facebook</label>
            </div>
        </div>

        <!-- Instagram Checkbox -->
        <div class="col-md-3">
            <div class="form-group form-check">
                <input type="checkbox" name="instagram_yn" id="instagram_yn" class="form-check-input" <?php echo isset($project_data['instagram_yn']) && $project_data['instagram_yn'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="instagram_yn">Instagram</label>
            </div>
        </div>

        <!-- YouTube Checkbox -->
        <div class="col-md-3">
            <div class="form-group form-check">
                <input type="checkbox" name="youtube_yn" id="youtube_yn" class="form-check-input" <?php echo isset($project_data['youtube_yn']) && $project_data['youtube_yn'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="youtube_yn">YouTube</label>
            </div>
        </div>

    

        <!-- Client ID (Hidden) -->
        <div class="col-md-4">
            <input type="hidden" name="client_id" id="client_id" value="<?php echo ($client_id); ?>">
        </div>

        <!-- Submit Button -->
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">SAVE Project Details </button>
        </div>
    </div>
</form>

    <div id="add-project-details-message"></div>

 
<div id="project-details-list"></div>
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
   $("#add-client-form").submit(function(event) {
    event.preventDefault();
    const clientName = $("#clientName").val();
    const clientCreationDate = $("input[name='clientCreationDate']").val(); // Get the client creation date value

    $.ajax({
        type: "POST",
        url: "add_client_action.php",
        data: {
            clientName: clientName,
            clientCreationDate: clientCreationDate // Include clientCreationDate in the data sent
        },
        success: function(response) {
            $("#message").html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
});
</script>
<script>
        $("#add-project-details-form").submit(function(event) {
    event.preventDefault();
    const formData = $(this).serialize(); // Serialize form data

    $.ajax({
        type: "POST",
        url: "add_project_details_action.php", // Your PHP script to handle the form submission
        data: formData,
        success: function(response) {
            $("#add-project-details-message").html(response);
            fetchProjectDetails(); // Refresh the list of project details
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
});

$(document).ready(function() {
    // Example AJAX call (you'll need to adjust this to your actual AJAX implementation)
    $.ajax({
        type: "GET",
        url: "fetch_project_details.php", // Your PHP script to fetch project details
        data: { client_id: $("#client_id").val() },
        success: function(response) {
            // Assuming 'response' is a JSON object containing the project details
         
            $("input[name='project_logo']").val(response.project_logo);
            $("select[name='project_type']").val(response.project_type);
            $("input[name='domain_names']").val(response.domain_names);
            $("input[name='mobile_no']").val(response.mobile_no);
            $("input[name='locations']").val(response.locations);
            $("input[name='whatsapp_no']").val(response.whatsapp_no);
            $("input[name='addresses']").val(response.addresses);
            $("input[name='extinct_photos']").val(response.extinct_photos);
            $("input[name='team_size']").val(response.team_size);
            $("input[name='equip_photos']").val(response.equip_photos);
            $("input[name='credentials']").val(response.credentials);
            $("input[name='list_of_services']").val(response.list_of_services);
            $("input[name='website']").val(response.website);
            $("input[name='gmb_accounts']").prop('checked', response.gmb_accounts === '1');
            $("input[name='facebook_yn']").prop('checked', response.facebook_yn === '1');
            $("input[name='instagram_yn']").prop('checked', response.instagram_yn === '1');
            $("input[name='youtube_yn']").prop('checked', response.youtube_yn === '1');
 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
});


    </script>

 

</html>