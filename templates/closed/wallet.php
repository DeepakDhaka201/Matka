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
    </style>
</head>


<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
  <div class="container-fluid page-body-wrapper">

    <?php include "include/header.php"; ?>

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Wallet ( Wallet Balance -  50,00,000 cr)</h4>
                         <form class="forms-sample" method="post" enctype="multipart/form-data">
                                    
                                    
                                     
                                    <div class="form-group" style="    margin-bottom: 10px !important">
                                        <label for="exampleInputName1">Amount</label>
                                        <input type="text" class="form-control" id="exampleInputName1" name="amount" placeholder="Enter amount">
                                    </div>
                                    
                                     <div class="form-group" style="    margin-bottom: 10px !important;display:none;">
                                        <label for="exampleInputName1">Remark</label>
                                        <input type="text" class="form-control" id="exampleInputName1" name="remark" placeholder="Enter Remark">
                                    </div>
                                    
                                    
                                    <div class="form-group" style="    margin-bottom: 10px !important">
                                        <label for="exampleFormControlSelect1">Select wallet type</label>
                                        <select class="form-control form-control-lg" name="wallet" id="exampleFormControlSelect1" onchange="ref_check(this.value)">
                                            
                                            <option value='wallet'>Deposit</option>
                                            <option value='winning'>Winning</option>
                                            <option value='bonus'>Bonus</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group" style="    margin-bottom: 10px !important">
                                        <label for="exampleFormControlSelect1">Select transaction type</label>
                                        <select class="form-control form-control-lg" name="type" id="exampleFormControlSelect1" onchange="ref_check(this.value)">
                                            
                                            <option value='0'>Deduct</option>
                                            <option value='1'>Add</option>
                                        </select>
                                    </div>
                                    <div class="ref" id="ref_id">
    <p>Rahul Sharma ( 9876543210 ) will get 10% amount for this transaction</p>
    <span><input type="checkbox" name="give_ref" checked> क्या आप इस उपयोगकर्ता को रेफरल बोनस जमा करना चाहते हैं?</span>
    <input type="hidden" value="9876543210" name="ref_mobile">
</div>

                                    <br>
                                    
                                    <button style="    margin-top: 0 !important" type="submit" class="btn btn-primary mr-2 mt-4" name="submit" style="width: 100%">Submit</button>
                                </form>
                                
                                <script>
                                    function ref_check(value){
                                        console.log("check")
                                        if($("#ref_id").length > 0) {;
                                            if(value === "1"){
                                               $("#ref_id").show();
                                            } else {
                                                $("#ref_id").hide();
                                            }
                                        }
                                        
                                    }
                                </script>
                                
                                 <h4 class="card-title" style="margin-top:20px;">Transaction history</h4>
                                 
                        <div class="row">
                            <div class="col-12">
                                
                                  
                                    
                               
                                
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Amount</th>
                                                    <th>Type</th>
                                                    <th>Remark</th>
                                                    <th>Created by</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                        <tbody id="table-body">

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
            <style>
                            .rangeela {
                                    background: #ffe8a4;
                            }
                        </style>
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
<script>
    // Dummy data array
    var dummyData = [
        {'sn': 1, 'amount': 500, 'type': 'Deduct', 'remark': 'Payment for service', 'owner': 'User', 'created_at': '2024-04-17 12:00:00'},
        {'sn': 2, 'amount': 1000, 'type': 'Added', 'remark': 'Referral bonus', 'owner': 'Admin', 'created_at': '2024-04-16 10:30:00'},
        {'sn': 3, 'amount': 200, 'type': 'Added', 'remark': 'Deposit', 'owner': 'Admin', 'created_at': '2024-04-15 09:45:00'}
        // Add more dummy data as needed
    ];

    // Function to generate table rows
    function generateTableRows(data) {
        var tableBody = document.getElementById('table-body');
        var html = '';
        var i = 1;
        data.forEach(function(row) {
            var owner = (row.owner === '') ? 'User' : 'Admin';
            var type = (row.type === 'Deduct') ? 'Deduct' : 'Added';
            var className = (row.type === '3') ? 'class="rangeela"' : '';
            html += '<tr ' + className + '>';
            html += '<td>' + i + '</td>';
            html += '<td>' + row.amount + '</td>';
            html += '<td>' + type + '</td>';
            html += '<td>' + row.remark + '</td>';
            html += '<td>' + owner + '</td>';
            html += '<td>' + row.created_at + '</td>';
            html += '</tr>';
            i++;
        });
        tableBody.innerHTML = html;
    }

    // Call the function to generate table rows with dummy data
    generateTableRows(dummyData);
</script>
</body>

</html>
