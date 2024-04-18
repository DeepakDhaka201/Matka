<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/horizontal-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>

<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
  <div class="container-fluid page-body-wrapper">

    <?php include "include/header.php"; ?>

        <div class="main-panel">
            <div class="content-wrapper">

                <?php if (isset($suc)) { ?>

                    <div class="alert alert-success" role="alert">
                        Password updated successfully
                    </div>

                <?php } ?>


                <?php if (isset($err)) { ?>

                    <div class="alert alert-danger" role="alert">
                        Old password does not match
                    </div>

                <?php } ?>

                <div class="row">

                    <div class="col-12 grid-margin stretch-card">




                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Change Password</h4>

                                <form class="forms-sample" method="post">


                                    <div class="form-group">
                                        <label for="exampleInputName1">Old password</label>
                                        <input type="password" class="form-control" id="exampleInputName1" name="opass" placeholder="Enter your old password">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">New password</label>
                                        <input type="password" class="form-control" id="exampleInputName1" name="npass" placeholder="Enter new password">
                                    </div>



                                    <button type="submit" class="btn btn-primary mr-2 mt-4" name="submit" style="width: 100%">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
            <footer class="footer">
                <div class="w-100 clearfix">
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
<script src="vendors/select2/select2.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/template.js"></script>
<script src="js/settings.js"></script>
<script src="js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="js/file-upload.js"></script>
<script src="js/typeahead.js"></script>
<script src="js/select2.js"></script>
<!-- End custom js for this page-->

<script>
    CKEDITOR.replace(  document.querySelector( '#editor' ));
</script>

</body>

</html>
