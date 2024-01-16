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

        <div class="bg-primary">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center min-vh-100">
                            <div class="w-100 d-block bg-white shadow-lg rounded my-5">
                                <div class="row">
                                    <div class="col-lg-5 d-none d-lg-block bg-login rounded-left"></div>
                                    <div class="col-lg-7">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <a href="index.php" class="d-block mb-5">
                                                    <img src="assets/images/logo-dark.png" alt="app-logo" height="58" />
                                                </a>
                                            </div>
                                            <h1 class="h5 mb-1">Welcome Back!</h1>
                                            <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>
                                            <form action="login.php" method="POST">
                                                <div class="form-group">
                                                    <label>User Type</label>
                                                    <select class="form-control" id="userType" name="userType">
                                                        <option value="admin">Admin</option>
                                                        <option value="manager">Manager</option>
                                                        <option value="client">Client</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>User Name </label>
                                                    <input type="text" class="form-control" id="username" name="username" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                          Password
                                                    </label>
                                                    <input type="password" class="form-control" id="password" name="password" required>
                
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>

                                                
                                                
                                            </form>

                                            <div class="row mt-4">
                                                <div class="col-12 text-center">
                                                    <p class="text-muted mb-2"><a href="auth-recoverpw.html" class="text-muted font-weight-medium ml-1">Forgot your password?</a></p>
                                                 
                                                </div> <!-- end col -->
                                            </div>
                                            <!-- end row -->
                                        </div> <!-- end .padding-5 -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div> <!-- end .w-100 -->
                        </div> <!-- end .d-flex -->
                    </div> <!-- end col-->
                </div> <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/metismenu.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/simplebar.min.js"></script>

        <!-- App js -->
        <script src="assets/js/theme.js"></script>

    </body>

</html>