<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["manager_id"])) {
    header("Location: login.php");
    exit;
}

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
// $conn->close();
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
                            <h2 class="header-title">Client Lists</h2>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">                        
                          
                        <div class="dropdown d-inline-block ml-2">
                            <button type="button" class="btn header-item" id="page-header-user-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php 
    $image_path = 'uploads/sample.png'; // Default image path
    if (isset($manager_data['image_path']) && !empty($manager_data['image_path'])) {
        $image_path = $manager_data['image_path'];
    }
?>
<img class="rounded-circle header-profile-user" src="<?php echo $image_path; ?>" alt="Header Avatar">
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
                    <div class="table-responsive">
                                        <table class="table table-centered table-striped table-nowrap">
                            <tr>
                                <th>Client ID</th>
                                <th>Client Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                       
                        <tbody id="managers-list">
                            <?php
            $manager_id = $_SESSION['manager_id'];
            $sql = "SELECT clients.client_id, clients.client_name FROM clients
                    JOIN client_manager ON clients.client_id = client_manager.client_id
                    WHERE client_manager.manager_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $manager_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["client_id"] . "</td>";
                    echo "<td>" . $row["client_name"] . "</td>";
                    echo '<td><a href="add_fields2.php?client_id=' . $row['client_id'] . '" class="btn  btn-primary btn-rounded">Edit </a>
                    <a href="reports.php?client_id=' . $row['client_id'] . '" class="btn btn-primary btn-rounded">View </a>
                    
                    <a href="view_project.php?client_id=' . $row['client_id'] . '" class="btn btn-primary btn-rounded">PMS </a>
                    
                    </td>';                     
                    echo "</tr>";
                }
            } else {
                echo '<div class="row mt-2"><div class="col-md-12">No clients assigned.</div></div>';
            }
            $stmt->close();
            ?>

                        </tbody>
                    </table> <!-- end col-->
                    </div></div> 
                        
                   

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
                                Made with Love : Praneeth
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
  function openWhatsApp() {
    var phoneNumber = "919502099553"; // Replace with your phone number
    var message = "Hello!"; // Replace with your default message
    window.location.href = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
  }
</script>

</html>