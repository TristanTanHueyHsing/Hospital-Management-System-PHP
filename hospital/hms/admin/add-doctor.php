<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $docspecialization = $_POST['Doctorspecialization'];
        $docname = $_POST['docname'];
        $docaddress = $_POST['clinicaddress'];
        $docfees = $_POST['docfees'];
        $doccontactno = $_POST['doccontact'];
        $docemail = $_POST['docemail'];
        $password = password_hash($_POST['npass'], PASSWORD_DEFAULT); // Secure hashing
        $sql = mysqli_query($con, "INSERT INTO doctors(specilization,doctorName,address,docFees,contactno,docEmail,password) 
            VALUES('$docspecialization','$docname','$docaddress','$docfees','$doccontactno','$docemail','$password')");
        if ($sql) {
            echo "<script>alert('Doctor info added Successfully');</script>";
            echo "<script>window.location.href ='manage-doctors.php'</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | Add Doctor</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
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
                                <h1 class="mainTitle">Admin | Add Doctor</h1>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">Add Doctor</h5>
                                            </div>
                                            <div class="panel-body">
                                                <form role="form" name="adddoc" method="post">
                                                    <div class="form-group">
                                                        <label for="DoctorSpecialization">Doctor Specialization</label>
                                                        <select name="Doctorspecialization" class="form-control" required>
                                                            <option value="">Select Specialization</option>
                                                            <?php 
                                                            $ret = mysqli_query($con, "select * from doctorspecilization");
                                                            while ($row = mysqli_fetch_array($ret)) { ?>
                                                                <option value="<?php echo htmlentities($row['specilization']); ?>">
                                                                    <?php echo htmlentities($row['specilization']); ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="doctorname">Doctor Name</label>
                                                        <input type="text" name="docname" class="form-control" placeholder="Enter Doctor Name" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="address">Doctor Clinic Address</label>
                                                        <textarea name="clinicaddress" class="form-control" placeholder="Enter Doctor Clinic Address" required></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="fees">Doctor Consultancy Fees</label>
                                                        <input type="text" name="docfees" class="form-control" placeholder="Enter Doctor Consultancy Fees" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="contact">Doctor Contact no</label>
                                                        <input type="text" name="doccontact" class="form-control" placeholder="Enter Doctor Contact no" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="email">Doctor Email</label>
                                                        <input type="email" id="docemail" name="docemail" class="form-control" placeholder="Enter Doctor Email" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <input type="password" name="npass" class="form-control" placeholder="New Password" required 
                                                            pattern="^(?=.*\d).{8,}$" 
                                                            title="Password must be at least 8 characters long and include at least one number.">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="confirm_password">Confirm Password</label>
                                                        <input type="password" name="cfpass" class="form-control" placeholder="Confirm Password" required 
                                                            pattern="^(?=.*\d).{8,}$" 
                                                            title="Password must be at least 8 characters long and include at least one number."
                                                            oninput="this.setCustomValidity(this.value !== document.adddoc.npass.value ? 'Passwords do not match.' : '')">
                                                    </div>

                                                    <button type="submit" name="submit" class="btn btn-o btn-primary">Submit</button>
                                                </form>
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
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
<?php } ?>
