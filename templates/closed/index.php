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
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/horizontal-layout-light/style.css?v=2">
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&display=swap" rel="stylesheet">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
  <div class="container-fluid page-body-wrapper">

    <?php include "include/header.php"; ?>  
    
        
        
      <div class="main-panel">
        <div class="content-wrapper">

          <div class="row">
              
              <style>
                  .card .card-body i{
                        font-size: 61px;
                        position: absolute;
                        right: 0;
                        margin-right: 10px;
                        opacity: 0.1;
                        color: #00ffce;
                  }
                  
                  .tablecard {
                      border-radius: 10px;
                     box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.75);
                    -webkit-box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.75);
                    -moz-box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.75);
                  }
              </style>


           


              <div class="col-md-3 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-user menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Total Users</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">50</h3>

                          </div>
                          <p class="mb-0 mt-2 text-warning"><a href="users.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                      </div>
                  </div>
              </div>
              
                    
              <div class="col-md-3 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Playing Users</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0" >24</h3>
                            

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="get_playing_user.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                       </div>
                  </div>
              </div>
              
                  
              <div class="col-md-3 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Today Bid</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0" >12,000 T</h3>
                            

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="get_bet_history.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                       </div>
                  </div>
              </div>
              
                <div class="col-md-3 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Today Bid Amount</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0" >50,000 T</h3>
                            

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="get_bet_history.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                       </div>
                  </div>
              </div>
              
                <div class="col-md-3 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Today Winning</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">23,000 T</h3>

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="get_winning_report.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                       </div>
                  </div>
              </div>
              
           
              
            <div class="col-md-3 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Today Deposit</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">70,000 T</h3>

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="get_deposit_report.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                       </div>
                  </div>
            </div>
            
              <div class="col-md-3 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Today Withdraw</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">15,000 T</h3>

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="get_withdraw_report.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                       </div>
                  </div>
            </div>
              
               <div class="col-md-3 grid-margin stretch-card" style="display:none;">
              <div class="card">
                  <div class="card-body">
                       <i class="ti-wallet menu-icon"></i>
                      <p class="card-title text-md-center text-xl-left">Total Withdraw</p>
                      <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">5,00,000 L</h3>

                      </div>
                     <p class="mb-0 mt-2 text-warning"><a href="get_withdraw_report.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                   </div>
              </div>
            </div>
   
              <div class="col-md-3 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Total Wallet Balance</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">15,00,000 L</h3>

                          </div>
                       </div>
                  </div>
              </div>
              
              
          
                <div class="col-md-3 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Today Profit/Loss</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">20+15-10</h3>

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="market_hisab.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                       </div>
                  </div>
              </div>
              

              <div class="col-md-3 grid-margin stretch-card" style="display:none;">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-agenda menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Total Transactions</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">5,000 Transactions</h3>

                          </div>
                          <p class="mb-0 mt-2 text-warning"><a href="users.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                      </div>
                  </div>
              </div>


            <div class="col-md-3 grid-margin stretch-card" style="display:none;">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-game menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Total Games Played</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">1200</h3>

                          </div>
                         
                      </div>
                  </div>
              </div>
              
              
     <div class="col-md-3 grid-margin stretch-card" style="display:none;">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-game menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Pending Games</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">700</h3>

                          </div>
                         
                      </div>
                  </div>
              </div>
              
              
              <div class="col-md-3 grid-margin stretch-card" style="display:none;">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Admin Deduct</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">15%</h3>

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="admintrans.php?user=admin&type=deduct"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                      </div>
                  </div>
              </div>
              
               
              <div class="col-md-3 grid-margin stretch-card"  style="display:none;">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Admin Deposit</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">15,000</h3>

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="admintrans.php?user=admin&type=deposit"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                      </div>
                  </div>
              </div>
              
               
               
              <div class="col-md-3 grid-margin stretch-card" style="display:none;">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Total Bet Amount</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">25,000</h3>

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="get_bet_history.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                       </div>
                  </div>
              </div>
              
               
             
               
               
              <div class="col-md-3 grid-margin stretch-card" style="display:none;">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Total Winning</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">50,000</h3>

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="get_winning_report.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                       </div>
                  </div>
              </div>
              
            
              
        
              
                <div class="col-md-3 grid-margin stretch-card" style="display:none;">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Total Withdraw Requests</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0" >20 Req.</h3>
                            

                          </div>
                       </div>
                  </div>
              </div>
              
                <div class="col-md-3 grid-margin stretch-card" style="display:none;">
                  <div class="card">
                      <div class="card-body">
                           <i class="ti-wallet menu-icon"></i>
                          <p class="card-title text-md-center text-xl-left">Pending Withdraw Requests</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0" style="color:red">13 Req.</h3>
                            

                          </div>
                         <p class="mb-0 mt-2 text-warning"><a href="withdraw_pending.php"> <span class="text-black ml-1"><small>View More</small></span></a></p>
                       </div>
                  </div>
              </div>
              
                
              
              <div class="col-sm-12">
              <div class="row">
                   
              <div class="col-md-3 grid-margin stretch-card" >
                  <div class="card ">
                      <div class="card-body">
                          <p class="card-title text-md-center text-xl-left">Razopay</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">

                          </div>
                          
                          
                         <p class="mb-0 text-warning"><a href="index.php?gateway=razorpay&type=deactivate"> <span class="text-black ml-1"><small class="act">Activated</small></span></a></p>
                         
                         
                         
                         <p class="mb-0 text-warning"><a href="index.php?gateway=razorpay&type=activate"> <span class="text-black ml-1"><small class="dis">Deactivated</small></span></a></p>
                         
                         
                      </div>
                  </div>
              </div>
              
               
              <div class="col-md-3 grid-margin stretch-card" >
                  <div class="card">
                      <div class="card-body">
                          <p class="card-title text-md-center text-xl-left">Paytm</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">

                          </div>
                        
                          
                         <p class="mb-0 text-warning"><a href="index.php?gateway=paytm&type=deactivate"> <span class="text-black ml-1"><small class="act">Activated</small></span></a></p>
                         
                         
                         
                         <p class="mb-0 text-warning"><a href="index.php?gateway=paytm&type=activate"> <span class="text-black ml-1"><small class="dis">Deactivated</small></span></a></p>
                         
                        
                      </div>
                  </div>
              </div>
              
                 
              <div class="col-md-3 grid-margin stretch-card" >
                  <div class="card">
                      <div class="card-body">
                          <p class="card-title text-md-center text-xl-left">UPI</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">

                          </div>
                         
                         <p class="mb-0 text-warning"><a href="index.php?gateway=upi&type=deactivate"> <span class="text-black ml-1"><small class="act">Activated</small></span></a></p>
                         
                        
                         
                         <p class="mb-0 text-warning"><a href="index.php?gateway=upi&type=activate"> <span class="text-black ml-1"><small class="dis">Deactivated</small></span></a></p>
                         
                         
                      </div>
                  </div>
              </div>
              
              
                 
              <div class="col-md-3 grid-margin stretch-card" >
                  <div class="card">
                      <div class="card-body">
                          <p class="card-title text-md-center text-xl-left">Bank</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">

                          </div>
                        
                          
                         <p class="mb-0 text-warning"><a href="index.php?gateway=bank&type=deactivate"> <span class="text-black ml-1"><small class="act">Activated</small></span></a></p>
                         
                         
                         <p class="mb-0 text-warning"><a href="index.php?gateway=bank&type=activate"> <span class="text-black ml-1"><small class="dis">Deactivated</small></span></a></p>
                         
                      </div>
                  </div>
              </div>
                  
                  
                       <div class="col-md-3 grid-margin stretch-card" >
                  <div class="card">
                      <div class="card-body">
                          <p class="card-title text-md-center text-xl-left">Auto Result</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">

                          </div>
                         
                          
                         <p class="mb-0 text-warning"><a href="index.php?auto=0"> <span class="text-black ml-1"><small class="act">Activated</small></span></a></p>
                         
                         
                         
                         <p class="mb-0 text-warning"><a href="index.php?auto=1"> <span class="text-black ml-1"><small class="dis">Deactivated</small></span></a></p>
                         
                      </div>
                  </div>
              </div>
                  
            </div>
            </div>

              
              
              
              <div class="col-sm-12">
                  
                <div class="card tablecard">
                    <div class="card-body">
                        <h4 class="card-title">Notifications</h4>
                          <form class="forms-sample" method="get" enctype="multipart/form-data">
                                  
                                    
                                   <div class="row">
                                       <div class="col-sm-8">
                                            <div style="margin-top: 22px;" class="form-group">
                                                <input type="text" class="form-control" name="query" value="Welcome user We Are Developing!" placeholder="Enter Keyword" required>
                                            </div>
                                       </div>
                                       <div class="col-sm-4">
                                           <button type="submit" class="btn btn-primary mr-2 mt-4" style="width: 100%">Search</button>
                                       </div>
                                   </div>
                                    
                                    
                                </form>
                                
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Notification</th>
                                                    <th>time</th>
                                                </tr>
                                            </thead>
                                        <tbody>

                                           
                                            <tr>
                                                <td>1</td>
                                                <td>Hello, User we are here!</td>
                                                <td> 04/17/2024</td>
                                               
                                               
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
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
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2022 <a href="http://www.shreeambikadevelopers.in" target="_blank"Shree_Ambika</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
        
    
      <!-- main-panel ends -->
   
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js?v=2"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/todolist.js"></script>
  
  <!-- End custom js for this page-->
</body>

</html>