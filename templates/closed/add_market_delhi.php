<?php
include "connection/config.php";

if (!checks("admin"))
{
    redirect("login.php");
}

    $week[] = "SUNDAY";
    $week[] = "MONDAY";
    $week[] = "TUESDAY";
    $week[] = "WEDNESDAY";
    $week[] = "THURSDAY";
    $week[] = "FRIDAY";
    $week[] = "SATURDAY";




if (isset($_REQUEST['submit']))
{
    extract($_REQUEST);
    
    $market = filter_var($market, FILTER_SANITIZE_STRING);
    
    $open = $close;
    
    
    if(rows(query("select sn from gametime_manual where market='$market'")) == 0){
        
        if($type == "Yes"){
            for($i = 0; $i < count($week);$i++){
                if($_REQUEST[$week[$i].'timetype'] == "close"){
                    $data[] = $week[$i]."(CLOSED)";
                } else if($_REQUEST[$week[$i].'open'] != $open || $_REQUEST[$week[$i].'close'] != $close){
                    
                        if($_REQUEST[$week[$i].'open'] != "" && $_REQUEST[$week[$i].'close'] != ""){
                        $data[] = $week[$i]."(".$_REQUEST[$week[$i].'open']."-".$_REQUEST[$week[$i].'close'].")";
                    }
                    
                }
            }
        }
        
        $dd = implode(",",array($data));
        
        query("INSERT INTO `gametime_delhi`(`market`, `open`, `close`, `days`,`sort_no`) VALUES ('$market','$open','$close','$dd','$sort_no')");
        
        redirect("market_list_delhi.php");
        
    } else {
        $error = "Market Already Exists";
    }
    
    


}

$sc = query("select * from rate where sn='1'");
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
                                <h4 class="card-title">Add new Market</h4>
                                
                                <?php if(isset($error)) { ?>
                                
                                    <div class="alert alert-danger" role="alert">
                                      <?php echo $error; ?>
                                    </div>
                                
                                <?php } ?>

                                <form class="forms-sample" method="post" enctype="multipart/form-data">
                                     
                                    <div class="form-group">
                                        <label for="exampleInputName1">Market</label>
                                        <input type="text" class="form-control" name="market" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputName1">Sort No.</label>
                                        <input type="text" class="form-control" name="sort_no" required>
                                    </div>
                                    
                                
                                    <div class="form-group">
                                        <label for="exampleInputName1">Close Time (Enter time in 24H format, ex. 17:20 or 19:20)</label>
                                        <input type="text" class="form-control" id="close" name="close" required>
                                    </div>
                                    
                                     <div class="form-group" style="    margin-bottom: 10px !important">
                                        <label for="exampleFormControlSelect1">Does Market have sepcial timings</label>
                                        <select class="form-control form-control-lg" name="type" id="exampleFormControlSelect1" onchange="time_check(this.value)">
                                            
                                            <option value='No'>No</option>
                                            <option value='Yes'>Yes</option>
                                        </select>
                                    </div>
                                    
                                    <script>
                                        function time_check(value){
                                            if(value == "Yes"){
                                                $("#timings").show();
                                               
                                                var open = $('#open').val();
                                                var close = $('#close').val();
                                                <?php for($i = 0;$i < count($week); $i++){ ?>
                                                $("#<?php echo $week[$i]; ?>open").val(open);
                                                $("#<?php echo $week[$i]; ?>close").val(close);
                                                <?php } ?>
                                                
                                            } else {
                                                $("#timings").hide();
                                            }
                                        }
                                    </script>
                                    
                                    <style>
                                        .timings {
                                            border: 1px #00000030 solid;
                                            border-radius: 5px;
                                        }
                                        
                                        .timings h4 {
                                            margin: 20px;
                                        }
                                        
                                        .timings .row {
                                            align-items: center;
                                            border-bottom: solid 1px #00000038;
                                            margin-bottom: 20px;
                                        }
                                        
                                        .timings .form-input {
                                                margin-top: 12px;
                                        }
                                        
                                    </style>
                                    
                                    <div id="timings" class="timings" style="display:none;">
                                        <h4>Timings</h4>
                                        <div class="col-sm-12">
                                            
                                            <?php
                                            
                                       
                                        
                                        for($i = 0;$i < count($week); $i++){
                                        
                                        
                                        ?>
                                            
                                            <div class="row" style="align-items: center;">
                                                    <div class="col-sm-2">
                                                    <h5><?php echo $week[$i]; ?></h4>
                                                </div>
                                                <div class="col-sm-2">
                                                     <div class="form-group" style="    margin-bottom: 10px !important">
                                                        <select class="form-control form-control-lg" name="<?php echo $week[$i]; ?>timetype" id="exampleFormControlSelect1" onchange="open_change(this.value,"<?php echo $week[$i]; ?>")">
                                                            
                                                            <option value='open'>Open</option>
                                                            <option value='close'>Close</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-input">
                                                        <input type="text" class="form-control"  placeholder="Open Time (24h format)" id="<?php echo $week[$i]; ?>open" name="<?php echo $week[$i]; ?>open">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-input">
                                                        <input type="text" class="form-control"  placeholder="Close Time  (24h format)"  id="<?php echo $week[$i]; ?>close" name="<?php echo $week[$i]; ?>close">
                                                    </div>
                                                </div>
                                            </div>
                                           
                                           <?php }?>
                                           
                                           
                                        </div>
                                        
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
