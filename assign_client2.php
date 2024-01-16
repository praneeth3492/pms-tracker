<?php
session_start();
if (!isset($_SESSION['manager_id']) || !isset($_SESSION['manager_name'])) {
    header("Location: login.php");
    exit;
}
require_once "config.php";

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/theme.min.css" rel="stylesheet" type="text/css" />
    <style>
    #assign-client-form {
        max-width: 50% ;
        margin: 20px auto;
        background-color: #f8f9fa;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-select {
        border-radius: 0;
        border: 1px solid #ced4da;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <?php include 'sidebar_a.php'; ?>
                </div>
                <!-- Sidebar -->
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
                            <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge badge-danger badge-pill">6</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
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
                                            <img src="assets/images/users/avatar-2.jpg" class="mr-3 rounded-circle avatar-xs" alt="user-pic">
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
                                            <img src="assets/images/users/avatar-3.jpg" class="mr-3 rounded-circle avatar-xs" alt="user-pic">
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
                            <button type="button" class="btn header-item" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                                <span class="d-none d-sm-inline-block ml-1">Henry</span>
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
            <?php
            $sql = "SELECT c.client_name, m.manager_name, cm.tasks_id1, cm.tasks_id2, cm.tasks_id3, cm.tasks_id4, cm.tasks_id5, cm.tasks_id6, cm.tasks_id7, cm.tasks_id8 
        FROM client_manager cm
        JOIN clients c ON cm.client_id = c.client_id
        JOIN managers m ON cm.manager_id = m.manager_id";

$result = $conn->query($sql);

$output = "";
$assignedTasks = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
        for ($i = 1; $i <= 8; $i++) {
            if (!empty($row["tasks_id$i"])) {
                $assignedTasks[] = $row["tasks_id$i"];
            }
            else
            $assignedTasks[] = 'tttt';

        }
        
    }
} else {
     
}
?>

            <div class="page-content">
            <div class="container-fluid">
    <div id="main-content">
        <div class="row">
            <form action="assign_client_action2.php" method="post" id="assign-client-form" class="p-4 border rounded">
                  <div class="form-group mb-3">
                    <label for="client_id" class="form-label">Client:</label>
                    <select class="form-select" id="client_id" name="client_id" required>
                        <?php
                        $sql = "SELECT client_id, client_name FROM clients";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=\"" . $row['client_id'] . "\">" . $row['client_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="manager_id" class="form-label">Manager:</label>
                    <select class="form-select" id="manager_id" name="manager_id" required>
                        <?php
                        $sql = "SELECT manager_id, manager_name FROM managers";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=\"" . $row['manager_id'] . "\">" . $row['manager_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
          <div class="form-group mb-3">
    <label class="form-label">Tasks:</label>
    <div>
        <?php
        $tasks = ['access_optimise', 'content_development', 'drs_details', 'project_details', 'project_insights', 'project_launch', 'quality_check', 'website'];

        foreach ($tasks as $index => $task) {
            echo "<div class='form-check'>";
            // Note the change in the name attribute to an array format and the value to the task name
            if(str_contains($assignedTasks[$index],$tasks[$index]))
            {
            echo "<input class='form-check-input' type='checkbox' name='tasks[]' checked id='task_$task' value='$task'>  ";
            echo "<label class='form-check-label' for='task_$task'>" . ucwords(str_replace('_', ' ', $task)) . "</label>";
            echo "</div>";
            }
            else
            {
                echo "<input class='form-check-input' type='checkbox' name='tasks[]' id='task_$task' value='$task'> ";
            echo "<label class='form-check-label' for='task_$task'>" . ucwords(str_replace('_', ' ', $task)) . "</label>";
            echo "</div>";
            }
        }
        ?>
    </div>
</div>


              
                <button type="submit" class="btn btn-primary">Assign Client</button>
            </form>
        </div>
    </div>
</div>



                <div class="container-fluid">
                    <!-- /# row -->
                    <div id="main-content">
                        
                        <div class="row justify-content-center mt-5">
                            <div class="col-md-6">
                                <div class="order-list-item">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Client</th>
                                                <th scope="col">Manager </th>
                                                <th scope="col">Assigned Tasks </th>
                                            </tr>
                                        </thead>
                                        <tbody id="clientmanager-list">
                                        </tbody>
                                        <tbody id="clientmanager-list">
    <?php include 'fetch_associated_tasks.php'; ?>
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
    $("#add-manager-form").submit(function(event) {
        event.preventDefault();

        const managerName = $("#managerName").val();
        const password = $("#password").val();

        $.ajax({
            type: "POST",
            url: "add_manager_action.php",
            data: {
                managerName: managerName,
                password: password
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
    function fetchManagers() {
        $.ajax({
            type: "GET",
            url: "fetch_managers.php",
            success: function(response) {
                $("#managers-list").html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    $(document).ready(function() {
        fetchManagers();
    });
</script>

<script>
    function fetchclientmanager() {
        $.ajax({
            type: "GET",
            url: "fetch_clients_manager.php",
            success: function(response) {
                $("#clientmanager-list").html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    $(document).ready(function() {
        fetchclientmanager();
    });
</script>



</html>