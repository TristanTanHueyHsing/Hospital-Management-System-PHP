<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {

    // Get user id from the URL
    $uid = intval($_GET['id']); // Get user ID

    // Handle form submission to update access level
    if (isset($_POST['submit'])) {
        $accessLevel = $_POST['accessLevel'];

        // Update query to change the access level
        $sql = mysqli_query($con, "UPDATE users SET accessLevel='$accessLevel' WHERE id='$uid'");
        if ($sql) {
            $msg = "User Access Level updated successfully.";
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Admin | Edit User Access Level</title>
        <link
            href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic"
            rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
        <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
        <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
        <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
        <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/plugins.css">
        <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
    </head>

    <body>
        <div id="app">
            <?php include('include/sidebar.php'); ?>

            <div class="app-content">
                <?php include('include/header.php'); ?>

                <div class="main-content">
                    <div class="wrap-content container" id="container">
                        <section id="page-title">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h1 class="mainTitle">Admin | Edit User Access Level</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Admin</span></li>
                                    <li class="active"><span>Edit User Access Level</span></li>
                                </ol>
                            </div>
                        </section>

                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 style="color: green; font-size:18px;">
                                        <?php if ($msg) {
                                            echo htmlentities($msg);
                                        } ?>
                                    </h5>
                                    <div class="row margin-top-30">
                                        <div class="col-lg-8 col-md-12">
                                            <div class="panel panel-white">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title">Edit User Access Level</h5>
                                                </div>
                                                <div class="panel-body">
                                                    <?php
                                                    // Fetch user details based on user ID
                                                    $sql = mysqli_query($con, "SELECT * FROM users WHERE id='$uid'");
                                                    while ($data = mysqli_fetch_array($sql)) {
                                                        ?>
                                                        <h4><?php echo htmlentities($data['fullName']); ?>'s Profile</h4>
                                                        <p><b>Account Creation Date:
                                                            </b><?php echo htmlentities($data['regDate']); ?></p>
                                                        <hr />
                                                        <form role="form" name="editUser" method="post">
                                                            <div class="form-group">
                                                                <label for="accessLevel">User Access Level</label>
                                                                <input type="number" name="accessLevel" class="form-control"
                                                                    value="<?php echo htmlentities($data['accessLevel']); ?>"
                                                                    required="required">
                                                            </div>


                                                            <button type="submit" name="submit"
                                                                class="btn btn-o btn-primary">Update</button>
                                                        </form>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('include/footer.php'); ?>
            <?php include('include/setting.php'); ?>
        </div>

        <!-- start: MAIN JAVASCRIPTS -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/modernizr/modernizr.js"></script>
        <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
        <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="vendor/switchery/switchery.min.js"></script>
        <!-- end: MAIN JAVASCRIPTS -->
        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
        <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
        <script src="vendor/autosize/autosize.min.js"></script>
        <script src="vendor/selectFx/classie.js"></script>
        <script src="vendor/selectFx/selectFx.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
        <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <!-- start: CLIP-TWO JAVASCRIPTS -->
        <script src="assets/js/main.js"></script>
        <!-- start: JavaScript Event Handlers for this page -->
        <script src="assets/js/form-elements.js"></script>
        <script>
            jQuery(document).ready(function () {
                Main.init();
                FormElements.init();
            });
        </script>
    </body>

    </html>

<?php } ?>