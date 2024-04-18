<?php
include "connection/config.php";

if (!checks("admin"))
{
    redirect("login.php");
}

if (isset($_REQUEST['submit']))
{
    extract($_REQUEST);

query("UPDATE `gametime` SET `kalyanopen`='$kalopen',`kalyanclose`='$kalclose',`milanopen`='$milanopen',`milanclose`='$milanclose',`ratanopen`='$ratanopen',`ratanclose`='$ratanclose',`desaweropen`='$disaweropen', `desawerclose`='$disawerclose', `mainopen`='$mainopen', `mainclose`='$mainclose' WHERE sn='1'");
}

$sc = query("select * from gametime where sn='1'");
$s = fetch($sc);


?>

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


<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
  <div class="container-fluid page-body-wrapper">

    <?php include "include/header.php"; ?>

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">

                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Manage Game Timing</h4>

                                <form class="forms-sample" method="post" enctype="multipart/form-data">
                                     
                                    <div class="form-group">
                                        <label for="exampleInputName1">Time Bazar  Open</label>
                                        <input type="time" class="form-control" value="<?php echo $s['kalyanopen']; ?>" id="exampleInputName1" name="kalopen">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputName1">Time Bazar  Close</label>
                                        <input type="time" class="form-control" value="<?php echo $s['kalyanclose']; ?>"  id="exampleInputName1" name="kalclose">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputName1">Milan Day open</label>
                                        <input type="time" class="form-control"  value="<?php echo $s['milanopen']; ?>" id="exampleInputName1" name="milanopen">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputName1">Milan Day close</label>
                                        <input type="time" class="form-control"  value="<?php echo $s['milanclose']; ?>" id="exampleInputName1" name="milanclose">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputName1">Milan Night open</label>
                                        <input type="time" class="form-control" value="<?php echo $s['ratanopen']; ?>"  id="exampleInputName1" name="ratanopen">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputName1">Milan Night close</label>
                                        <input type="time" class="form-control" value="<?php echo $s['ratanclose']; ?>"  id="exampleInputName1" name="ratanclose">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputName1">Kalyan open</label>
                                        <input type="time" class="form-control" value="<?php echo $s['desaweropen']; ?>"  id="exampleInputName1" name="disaweropen">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputName1">Kalyan close</label>
                                        <input type="time" class="form-control" value="<?php echo $s['desawerclose']; ?>"  id="exampleInputName1" name="disawerclose">
                                    </div>
                                          
                                    <div class="form-group">
                                        <label for="exampleInputName1">Main Bazar open</label>
                                        <input type="time" class="form-control" value="<?php echo $s['mainopen']; ?>"  id="exampleInputName1" name="mainopen">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputName1">Main Bazar close</label>
                                        <input type="time" class="form-control" value="<?php echo $s['mainclose']; ?>"  id="exampleInputName1" name="mainclose">
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

<script src="https://cdn.tiny.cloud/1/6n9e3b6bbutqzcha0os8jsggfbmiqxiy166ekcaclp6aw530/tinymce/5/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea',  // change this value according to your HTML
        auto_focus: 'element1'
    });
</script>

</body>

</html>
