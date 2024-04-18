<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}

if(isset($_REQUEST['delete'])){
    $sn = $_REQUEST['delete'];
    
    query("delete from gametime_new where sn='$sn'");
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
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
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
                
             
             <div class="card">
                 <div class="card-body">
                      <div class="row">
                        
                          <div class="form-group" style="   margin-left: 10px; margin-bottom: 10px !important; margin-right:20px;">
                                        <label for="type">Market Type</label>
                                        <select class="form-control form-control-lg" onchange="getMarkets(this.value)" name="market" id="type">
                                          <option value="">Select Market</option>
                                          
                                          <option value="delhi">Delhi Markets</option>
                                        </select>
                                    </div>
                                    
                                      <script>
                                            
                                            function getMarkets(type)
                                            {
                                                $.LoadingOverlay("show");
                                                
                                                $.ajax({
                                                  url: "ajax/get_markets.php?type="+type,
                                                  cache: false,
                                                  success: function(html){
                                                    $('#markets').html(html);
                                                     $.LoadingOverlay("hide");
                                                  },
   						                          	 error: function(xhr, status, error) {
    							                    
    							                       alert('Error - Server Error Please Refresh the page');
    							                       $.LoadingOverlay("hide");
   							                             }
                                                });
                                            }
                                            
                                            function getHisab()
                                            {
                                                
                                                $.LoadingOverlay("show");
                                                
                                                var date2 = $("#datepicker2").val();
                                                var date = $("#datepicker").val();
                                                var market = $("#markets").val();
                                                var type = $("#type").val();
                                                
                                                if(type==="starline"){
                                                    var c_url = "getHisabRangeStarline";
                                                } else if(type=="delhi"){
                                                    var c_url = "getHisabDelhiRange";
                                                }
                                                else {
                                                    var c_url = "getHisabRange";
                                                }
                                                
                                                $.ajax({
                                                  url: c_url+".php?date="+date+"&market="+market+"&type="+type+"&date2="+date2,
                                                  cache: false,
                                                  success: function(html){
                                                    $('#hisab').html(html);
                                                     $.LoadingOverlay("hide");
                                                  },
   						                          	 error: function(xhr, status, error) {
    							                     
    							                       alert('Error - Server Error Please Refresh the page');
    							                       $.LoadingOverlay("hide");
   							                             }
                                                });
                                            }
                                            
                                        </script>
                                    
                                    <div class="form-group" style="    margin-bottom: 10px !important; margin-right:20px;">
                                        <label for="markets">Select Market</label>
                                        <select class="form-control form-control-lg" name="market" id="markets">
                                          <option value="all">Select type first</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group" style="    margin-bottom: 10px !important; margin-right:20px;">
                                        <label for="exampleInputName1">From Date</label>
                                        <input type="datepicker" id="datepicker" class="form-control" name="sort_no" required>
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group" style="    margin-bottom: 10px !important; margin-right:20px;">
                                        <label for="exampleInputName1">To Date</label>
                                        <input type="datepicker" id="datepicker2" class="form-control" name="sort_no" required>
                                    </div>
                                    
                        <button style="margin-top: 32px;" onclick="getHisab()" class="btn btn-primary">Get Hisab</button>
                       
                        
                    </div>
                 </div>
             </div>
                
                <div class="card">
                    
                   
                    
                       
                    <div class="card-body" style="margin-top: 25px;">
                        <h4 class="card-title">Market Report</h4>
                        <div class="row">
                            <div class="col-12" id="hisab">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="w-100 clearfix">
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
                </div>
            </footer>
            <!-- partial -->
        </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="vendors/datatables.net/jquery.dataTables.js"></script>
<script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/template.js"></script>
<script src="js/settings.js"></script>
<script src="js/todolist.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .datepicker {
            z-index: 99999 !important;
    }
</style>
<script>
$('#datepicker').datepicker({
    format: 'dd/mm/yyyy',
    endDate: '0d'
});
$('#datepicker2').datepicker({
    format: 'dd/mm/yyyy',
    endDate: '0d'
});
</script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="js/data-table.js"></script>



<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>

<!-- End custom js for this page-->
</body>

</html>
