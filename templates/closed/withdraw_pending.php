<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
include "connection/config.php";


if (!checks("admin"))
{
    redirect("login.php");
}

if(isset($_REQUEST['complete'])){
    $sn = $_REQUEST['complete'];
    
    query("update withdraw_requests set status='1',action_time='$stamp' where sn='$sn'");
    
    
    $sad="sucess";
    // redirect('withdraw_pending.php');

}


if(isset($_REQUEST['cancel'])){
    $sn = $_REQUEST['cancel'];
    $reason = $_REQUEST['reason'];
    
    
    query("update withdraw_requests set status='2',action_time='$stamp', action_reason='$reason' where sn='$sn'");
    
    redirect('index.php');
}

if(isset($_REQUEST['refund'])){
    $sn = $_REQUEST['refund'];
    $reason = $_REQUEST['reason'];
    
    query("update withdraw_requests set status='2',action_time='$stamp', action_reason='$reason'  where sn='$sn'");
    
    $info = fetch(query("select user, amount from withdraw_requests where sn='$sn'"));
    $mobile = $info['user'];
    $amount = $info['amount'];
    
    query("UPDATE users set winning=winning+$amount where mobile='$mobile'");
    
    query("INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `owner`, `created_at`, `game_id`, `batch_id`) VALUES ('$mobile','$amount','1','Withdraw cancelled by our team','user','$stamp','0','0')");
   
    redirect('index.php');
}

?>


<!DOCTYPE html>
<html lang="en">


<head>
    
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
    html{
        height:200%;
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
        .ref {
                background: #4caf50;
                padding: 10px;
                color: white;
                font-size: 15px;
                border-radius: 5px;
                margin-top: 20px;
                display:none;
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
                        <h4 class="card-title">Withdraw requests</h4>
                        
                        <?php if(isset($sad)) { ?>
                                
                                    
                                      <script>swal("Good job!", "Withdraw Completed Successfully", "success");</script>
                                   
                                
                                <?php } ?>
                       
                        <div class="row">
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
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                        <tbody>
   
                                            <?php
                                            $i = 1;
                                            $get = query("select * from withdraw_requests where status='0'");
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
                                                <td><?php if($xc['status'] != '0'){ echo 'No Action Available'; } else { ?>
                                                    <a href="withdraw_pending.php?complete=<?php echo $xc['sn']; ?>"> <button class="btn btn-outline-info" onclick="return confirm('Are you sure you want to proceed')">Completed</button> </a>
                                                   <!-- <a href="withdraw.php?cancel=<?php //echo $xc['sn']; ?>"> <button class="btn btn-outline-info" onclick="return confirm('Are you sure you want to proceed')">Cancel</button> </a>
                                                    <a href="withdraw.php?refund// echo $xc['sn']; ?>"> <button class="btn btn-outline-info" onclick="return confirm('Are you sure you want to proceed')">Cancel and Refund</button> </a>-->
                                                   <button class="btn btn-outline-info" onclick="cancel('<?php echo $xc['sn']; ?>','cancel')">Cancel</button>
                                                     <button class="btn btn-outline-info" onclick="cancel('<?php echo $xc['sn']; ?>','refund')">Cancel and Refund</button> 
                                                     
                                                     <a href="all_bets.php?mobile=<?php echo $mobile; ?>"> <button class="btn btn-outline-info">View bets</button> </a>
                                                     
                                                     <a href="transactions.php?mobile=<?php echo $mobile; ?>"> <button class="btn btn-outline-info">Transactions</button> </a>
                                                    
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            
                                            
                                            
                                            <?php } ?>
                                            
                                            <script>
                                                function cancel(sn,type){
                                                    swal("Enter reason:", {
                                                      content: "input",
                                                    })
                                                    .then((value) => {
                                                      window.location.href = "withdraw_pending.php?"+type+"="+sn+"&reason="+value;
                                                    });
                                                }
                                            </script>

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
<!-- End custom js for this page-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.print.js"></script>
<script>
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
        columnDefs: [ { orderable: false, targets: [2,-2] }],
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
</body>

</html>
