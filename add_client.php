<?php
session_start();
if (!isset($_SESSION['manager_id']) || !isset($_SESSION['manager_name'])) {
    header("Location: login.php");
    exit;
}
require_once "config.php";
$sql = "SELECT * FROM months";
$result = $conn->query($sql);
if (!$result) {
    die("Error fetching months: " . $conn->error);
}
$months = [];
while ($row = $result->fetch_assoc()) {
        $months[] = $row;
}

$conn->close();
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
                    <?php include 'sidebar_a.php'; ?>
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
                        
   
                        <div class="dropdown d-inline-block ml-2"></div>
                        </div>
                        <div class="dropdown d-inline-block ml-2">
                            <button type="button" class="btn header-item" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                                <span class="d-none d-sm-inline-block ml-1">Henry</span>
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
                <!-- /# row -->
                <div id="main-content">
                <h1 class="text-center mt-5">Add Client</h1>
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6">
                    <form id="add-client-form">
    <div class="form-group mb-3">
        <label for="clientName">Client Name</label>
        <input type="text" class="form-control" id="clientName" name="clientName" required>
    </div>
    

    <div class="form-group mb-3">
        <label for="clientCreationDate">Client Creation Date</label>
        <input type="date" name="clientCreationDate" required>
    </div>

    <button type="submit" class="btn btn-primary">Add Client</button>
</form>
<div id="message" class="mt-3"></div>
                    </div>
                </div>                    
                </div>
                        </div>
            <div class="container-fluid">
                <!-- /# row -->
                <div id="main-content">
                <h1 class="text-center mt-5">View Client</h1>
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6">
                    <div class="order-list-item">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Client ID</th>
                                    <th scope="col">Client Name</th>
                                </tr>
                            </thead>
                            <tbody id="clients-list">
                            </tbody>
                        </table>
                    </div>
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
        function fetchclients() {
            $.ajax({
                type: "GET",
                url: "fetch_clients.php",
                success: function(response) {
                    $("#clients-list").html(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
        $(document).ready(function() {
            fetchclients();
        });
    </script>
</html>