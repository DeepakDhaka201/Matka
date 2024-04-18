<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}

if(isset($_REQUEST['complete'])){
    $sn = $_REQUEST['complete'];
    
    query("update withdraw_requests set status='1' where sn='$sn'");
    
    redirect('withdraw.php');
}


if(isset($_REQUEST['cancel'])){
    $sn = $_REQUEST['cancel'];
    
    query("update withdraw_requests set status='2' where sn='$sn'");
    
    redirect('withdraw.php');
}

if(isset($_REQUEST['refund'])){
    $sn = $_REQUEST['refund'];
    
    query("update withdraw_requests set status='2' where sn='$sn'");
    
    $info = fetch(query("select user, amount from withdraw_requests where sn='$sn'"));
    $mobile = $info['user'];
    $amount = $info['amount'];
    
    query("UPDATE users set winning=winning+$amount where mobile='$mobile'");
    
    query("INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `owner`, `created_at`, `game_id`, `batch_id`) VALUES ('$mobile','$amount','1','Withdraw cancelled by our team','user','$stamp','0','0')");
   
    redirect('withdraw.php');
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
    
    <style>
        .ref {
                background: #4caf50;
                padding: 10px;
                color: white;
                font-size: 15px;
                border-radius: 5px;
                margin-top: 20px;
                display:none;
        }
        
         
        .dt-buttons {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        .dt-button {
            background: #fff;
            border: solid #000 1px;
            border-radius: 5px;
            padding: 5px 15px;
        }
    </style>
</head>


<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
  <div class="container-fluid page-body-wrapper">

    <?php include "include/header.php"; ?>

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Withdraw Completed</h4>
                       
                        <div class="row">
                            
                            
                            
                                       <form method="post"  autocomplete="off">
                                        
                                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
                                        
                                        <div class="form-group" style="    margin-bottom: 10px !important; margin-right:20px;">
                                            <label for="exampleInputName1">From Date</label>
                                            <input type="datepicker" id="datepicker" class="form-control" name="from" required>
                                        </div>
                                        
                                           
                                        <div class="form-group" style="    margin-bottom: 10px !important; margin-right:20px;">
                                            <label for="exampleInputName1">To Date</label>
                                            <input type="datepicker" id="datepicker2" class="form-control" name="to" required>
                                        </div>
                                         
                                        <button style="margin-top: 32px;" class="btn btn-primary">Filter</button>
                                   </form>
                            
                            <div class="col-12">
                                
                                
                                <?php if(isset($_SESSION['msg'])){?> 
                                <div class="alert alert-info" role="alert"> 
                                      <?php echo $_SESSION['msg'] ; ?></div>
                                <?php unset($_SESSION['msg']);}?> 
                                    
                               
                                
                                <div class="table-responsive">
                                    <table id="example" class="table">
                                            <thead>
                                                <tr>
                                                     <th>Sn</th>
                                                    <th>Mobile</th>
                                                    <th>Name</th>
                                                    <th>Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Payment Info</th>
                                                    <th>Status</th>
                                                    <th>Created at</th>
                                                    <th>Completed at</th>

                                                </tr>
                                            </thead>
                                        <tbody>
   
                                            <?php
                                            
                                            
                                                                                        
                                            if(isset($_REQUEST['from'])){
                                                $fromDate = $_REQUEST['from'];
                                                $toDate = $_REQUEST['to'];
                                                
                                                $From_explode = explode('/',$fromDate);
                                                $to_explode = explode('/',$toDate);
                                                
                                                $start_time = mktime(0, 0, 0, $From_explode[1], $From_explode[0], $From_explode[2]);
                                                $end_time = mktime(23, 59, 59, $to_explode[1], $to_explode[0], $to_explode[2]);
                                                
                                            } else {
                                                
                                                $start_time = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                                                $end_time = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
                                            }


                                            
                                            
                                            $i = 1;
                                            $get = query("select * from withdraw_requests where status='1' AND created_at > $start_time AND created_at < $end_time");
                                            while($xc = fetch($get))
                                            { 
                                            
                                            $mobile = $xc['user'];
                                            $uinfo = fetch(query("select name from users where mobile='$mobile'"));
                                            
                                            ?>
                                            
                                            
                                            
                                            <tr>
                                                <td><?php echo $i; $i++; ?></td>
                                                <td><?php echo $mobile; ?></td>
                                                <td><?php echo $uinfo['name']; ?></td>
                                                <td><?php echo $xc['amount']; ?></td>
                                                <td><?php echo $xc['mode']; ?></td>
                                                <td><?php echo $xc['info']; ?></td>
                                                <td><?php if($xc['status'] == '0'){ echo 'Pending'; } else if($xc['status'] == '1'){ echo 'Completed'; } else if($xc['status'] == '2'){ echo 'Cancelled'; }; ?></td>
                                                
                                                <td><?php echo date('d/m/Y h:i A',$xc['created_at']); ?></td>
                                                <td><?php echo date('d/m/Y h:i A',$xc['action_time']); ?></td>
                                               
                                            </tr>
                                            
                                            
                                            
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
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
        <!-- main-panel ends -->
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
<!-- endinject -->
<!-- Custom js for this page-->
<script src="js/data-table.js"></script>
    
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.print.js"></script>
<!-- End custom js for this page--><script>
    $(document).ready(function() {
    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    datas = data.split('>');
                    if(datas.length > 1){
                        data2 = datas[1].replace("</a", "");
                        return data2;
                    } else {
                        return data;
                    }
                }
            }
        }
    };
 
    $('#example').DataTable( {
        dom: 'lBfrtip',
        
        buttons: [
            $.extend( true, {}, buttonCommon, {
                extend: 'copyHtml5',
                columns: ':visible',
                exportOptions: {
                        columns: "thead th:not(.mrl-title)"
                }
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5',
                columns: ':visible',
                exportOptions: {
                        columns: "thead th:not(.mrl-title)"
                }
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5',
                columns: ':visible',
                exportOptions: {
                        columns: "thead th:not(.mrl-title)"
                }
            } ),
             $.extend( true, {}, buttonCommon, {
                extend: 'print',
                exportOptions: {
                        columns: "thead th:not(.mrl-title)"
                }
            } )
        ]
    } );
} );
</script>

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



</body>

</html>
