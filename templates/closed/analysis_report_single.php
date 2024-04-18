<?php
include "connection/config.php";


if (!checks("admin"))
{
    redirect("login.php");
}

$game = $_REQUEST['game'];
$market = $_REQUEST['market'];

if(isset($_REQUEST['timing'])){
    $timing = $_REQUEST['timing'];
}
if(isset($_REQUEST['time'])){
    $time = $_REQUEST['time'];
}

if(isset($_REQUEST['jantri'])){
    $jantri = $_REQUEST['jantri'];
}

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
    
    <style>
        input {
            padding: 0.875rem 0.5rem !important;
            text-align: center;
        }
        
        .card-title {
            text-align:center;
        }
        
        .card-title {
            font-size: 22px !important;
        }
        
        .number {
            font-weight: bold !important;
            font-size: 30px !important;
        }
        
        h4 {
            margin-bottom:20px;
        }
        
        .card {
            border: 2px solid #e3e3e3;
        }
        
        .loss {
            border: 2px solid #ff0000;
        }
        
        .report .loading_view .loading_svg {
            height: 100px;
        }
        
        .loading_view p {
            text-align: center;
        }
        
        .report .loading_view {
            display: flex;
            flex-direction: column;
            background: #fff;
            padding: 15px;
            border-radius: 10px;
        }
    </style>
</head>

<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
  <div class="container-fluid page-body-wrapper">
    <?php include "include/header.php"; ?>

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    
                    <div class="col-sm-12">
                        <h4>Market Anaysis</h4>
                    </div>
                    
                    <div class="report" id="report">
                        
                        <div class="loading_view">
                            <p>Generating Reports</p>
                            <img class="loading_svg" src="images/Infinity-2.3s-200px.svg" />
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
<script>



    <?php if(!isset($_REQUEST['timing'])){ ?>

   <?php if($game =='halfsangam') { $urrl = "half_sangam";   } 
   else if($game == 'fullsangam') { $urrl = "half_sangam";  } else {  $urrl = "getReport"; } ?>


   $.ajax('<?php echo $urrl; ?>.php?game=<?php echo $game; ?>&market=<?php echo $market; ?>',   // request url
    {
        success: function (data, status, xhr) {// success callback function
            $('#report').html(data);
    }
    });
    <?php }
   else if(isset($_REQUEST['time'])){?>

   <?php if($game =='single') { $urrl = "single";   } 
   else if($game == 'jodi') { $urrl = "jodi";  } else {  $urrl = "getReport2"; } ?>


    $.ajax('<?php echo $urrl; ?>.php?game=<?php echo $game; ?>&market=<?php echo $market; ?>',   // request url
    {
        success: function (data, status, xhr) {// success callback function
            $('#report').html(data);
    }
   });
   <?php }
   else if(isset($_REQUEST['jantri'])){?>

   <?php if($game =='single') { $urrl = "single";   } 
   else if($game == 'jodi') { $urrl = "jodi";  } else {  $urrl = "getReport3"; } ?>


    $.ajax('<?php echo $urrl; ?>.php?game=<?php echo $game; ?>&market=<?php echo $market; ?>',   // request url
    {
        success: function (data, status, xhr) {// success callback function
            $('#report').html(data);
    }
   });
   <?php }
   
   else { ?>

  
  
  <?php } ?>


</script>

</body>

</html>
