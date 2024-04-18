




<style>
    .stretch-card > .card {
        width: 100%;
        min-width: 100%;
        background-color: #282f3a;
        color: white;
        border-radius: 12px;
        box-shadow: 0px 0px 12px 0px rgb(0 0 0 / 75%);
        -webkit-box-shadow: 0px 0px 12px 0px rgb(0 0 0 / 75%);
        -moz-box-shadow: 0px 0px 12px 0px rgba(0,0,0,0.75);
    }
    
    .stretch-card > .card a {
        color: white;
    }

    .stretch-card > .card .card-title {
        color: white;
    }
    .stretch-card > .card span {
        color: white;
    }
    
    
    .nav-link .login-email {
        margin-right: 0.5rem;
        color: #282f3a;
    }
    
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        bottom:0;
        right:0;
        width: 100%;
        height: 100%;
        z-index: 99999999;
        background-repeat: no-repeat;
        background-color: #FFF;
        background-position: center;
        display: flex;
        align-content: center;
        flex-direction: column;
        justify-content: center;
    }
    
    select {
            color:#dee3e0 ;
    }
    
    body {
        height: 100% !important;
        overflow: hidden !important;
    }
    
    .material-dropdown {
        margin: 10px;
        border-radius: 10px;
        box-shadow: rgb(0 0 0 / 75%) 0px 0px 14px 2px;
        --darkreader-inline-boxshadow: rgba(24, 26, 27, 0.75) 0px 0px 14px 2px;
    }
    
    .shimmer {
		font-weight: 300;
		font-size: 3em;
		margin: 0 auto;
		display: inline;
		margin-bottom: 0;
		line-height: 70px;
    }
    
    .nav-ite i{
        margin-right:13px;
    }
    
    .nav-ite:hover{
        
        border-radius:8px;
        background-color:#dee3e0;
    }


.shimmer {
		text-align: center;
		color: rgba(255, 255, 255, 0.1);
		background: -webkit-gradient(linear, left top, right top, from(#222), to(#222), color-stop(0.5, #fff));
		background: -moz-gradient(linear, left top, right top, from(#222), to(#222), color-stop(0.5, #fff));
		background: gradient(linear, left top, right top, from(#222), to(#222), color-stop(0.5, #fff));
		-webkit-background-size: 125px 100%;
		-moz-background-size: 125px 100%;
		background-size: 125px 100%;
		-webkit-background-clip: text;
		-moz-background-clip: text;
		background-clip: text;
		-webkit-animation-name: shimmer;
		-moz-animation-name: shimmer;
		animation-name: shimmer;
		-webkit-animation-duration: 2s;
		-moz-animation-duration: 2s;
		animation-duration: 2s;
		-webkit-animation-iteration-count: infinite;
		-moz-animation-iteration-count: infinite;
		animation-iteration-count: infinite;
		background-repeat: no-repeat;
		background-position: 0 0;
		background-color: #222;
}

@-moz-keyframes shimmer {
		0% {
				background-position: top left;
		}
		100% {
				background-position: top right;
		}
}

@-webkit-keyframes shimmer {
		0% {
				background-position: top left;
		}
		100% {
				background-position: top right;
		}
}

@-o-keyframes shimmer {
		0% {
				background-position: top left;
		}
		100% {
				background-position: top right;
		}
}

@keyframes shimmer {
		0% {
				background-position: top left;
		}
		100% {
				background-position: top right;
		}
}

select {
    outline: none !important;
}

.dropdown-menu-right {
    margin: 10px !important;
    border-radius: 10px !important;
    box-shadow: 0px 0px 42px 10px rgb(0 0 0 / 75%) !important;
    -webkit-box-shadow: 0px 0px 42px 10px rgb(0 0 0 / 75%) !important;
    -moz-box-shadow: 0px 0px 42px 10px rgba(0,0,0,0.75) !important;
}

</style>




<div onload="upi();" class="preloader" id="preloader">
    <h1 class="shimmer">Loading...</h1>
</div>
    
    <nav onload="withdraw();" class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div  class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo me-5" href="index.php" style="color:white">SAMRAT SATTA</a>
        <a class="navbar-brand brand-logo-mini" href="index.php" style="color: white;font-weight: 600;">SAMRAT</a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="ti-layout-grid2"></span>
        </button>
        
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
                        <a class="nav-link" href="#" data-bs-toggle="dropdown" id="profileDropdown"> <span class="login-email">SAMRAT SATTA</span>
                            <img src="images/faces/user.png" alt="profile"/>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown material-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="changepass.php">
                                <i class="ti-settings text-primary"></i>
                                Change password
                            </a>
                            <a class="dropdown-item" href="logout.php">
                                <i class="ti-power-off text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
          
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="ti-layout-grid2"></span>
        </button>
      </div>
    </nav>
    
      
<script>
window.onload = function(e) {
    var preloader = document.getElementById('preloader');
    var opacity = 1;

    // Function to fade out the preloader element
    function fadeOut() {
        opacity -= 0.1;
        preloader.style.opacity = opacity;

        if (opacity <= 0) {
            preloader.style.display = "none";
        } else {
            setTimeout(fadeOut, 40);
        }
    }

    fadeOut(); // Start the fading animation

    // Function to remove an element by its ID
    function removeElement(id) {
        var elem = document.getElementById(id);
        if (elem && elem.parentNode) {
            elem.parentNode.removeChild(elem);
        }
    }
};
</script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i  class="ti-home menu-icon"></i>
              <span  class="menu-title">Dashboard</span>
            </a>
          </li>
          
         <!-- <?php //if(isset($_SESSION['permission']) && $_SESSION['permission'] == 'all'){ ?> -->

         
         <!--<li class="nav-item">-->
         <!--            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basssic" aria-expanded="false" aria-controls="ui-basssic" >-->
         <!--               <i  class="ti-game menu-icon"></i>-->
         <!--               <span  class="menu-title">Games</span>-->
         <!--               <i class="menu-arrow"></i></a>-->
         <!--           <div  class="collapse" id="ui-basssic">-->
         <!--             <ul  class="nav flex-column sub-menu">-->
         <!--                   <li  class="nav-item"><a class="nav-link" href="markets.php?game=single">Single Open Close</a></li>-->
         <!--                   <li  class="nav-item"><a  class="nav-link" href="markets.php?game=jodi">Jodi</a></li>-->
         <!--                   <li  class="nav-item"><a  class="nav-link" href="markets.php?game=singlepatti">Single Patti</a></li>-->
         <!--                   <li  class="nav-item"><a  class="nav-link" href="markets.php?game=doublepatti">Double Patti</a></li>-->
         <!--                   <li  class="nav-item"><a  class="nav-link" href="markets.php?game=triplepatti">Triple Patti</a></li>-->
         <!--                   <li  class="nav-item"><a class="nav-link" href="markets.php?game=halfsangam">Half Sangam</a></li>-->
         <!--                   <li  class="nav-item"><a class="nav-link" href="markets.php?game=fullsangam">Full Sangam</a></li>-->
         <!--               </ul>-->
         <!--           </div>-->
         <!--       </li>-->
                
                
                
                <!--<li class="nav-item">-->
                <!--    <a class="nav-link" href="publish_result.php">-->
                <!--        <i  class="ti-crown menu-icon"></i>-->
                <!--        <span  class="menu-title">Publish Result</span>-->
                <!--    </a>-->
                <!--</li>-->
                
                    
                
                <!--<li class="nav-item">-->
                <!--    <a class="nav-link" href="delhi_result_update.php">-->
                <!--        <i class="ti-crown menu-icon"></i>-->
                <!--        <span class="menu-title">Delhi Publish Result</span>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a class="nav-link" href="starline_result_update.php">-->
                <!--        <i class="ti-crown menu-icon"></i>-->
                <!--        <span  class="menu-title">Starline Publish Result</span>-->
                <!--    </a>-->
                <!--</li>-->
                
                <li class="nav-item">
                     <a class="nav-link" data-bs-toggle="collapse" href="#xui-basicccc" aria-expanded="false" aria-controls="ui-basic">
                        <i  class="ti-game menu-icon"></i>
                        <span class="menu-title">Result Management</span>
                        <i class="menu-arrow"></i></a>
                    <div class="collapse" id="xui-basicccc">
                      <ul class="nav flex-column sub-menu">
                            <!--<li class="nav-item"><a class="nav-link" href="publish_result.php">Main Publish Result</a></li>-->
                            <!--<li class="nav-item"><a class="nav-link" href="batch_history_list.php">Main Publish History</a></li>-->
                            <!--<li class="nav-item"><a class="nav-link" href="starline_result_update.php">Starline Publish Result</a></li>-->
                            <!--<li class="nav-item"><a class="nav-link" href="starline_history.php">Starline Publish History</a></li>-->
                            <li class="nav-item"><a class="nav-link" href="delhi_result_update.php">Delhi Publish Result</a></li>
                                                        <li class="nav-item"><a class="nav-link" href="delhi_batch_history.php">Delhi Publish History</a></li>
                                                        <li class="nav-item"><a class="nav-link" href="card_result_update.php">Card Publish Result</a></li>
                                                         <!--<li class="nav-item"><a class="nav-link" href="jackpot_result_update.php">Jackpot Publish Result</a></li>-->
                        </ul>
                    </div>
                </li>
                
                                <li class="nav-item">
                     <a class="nav-link" data-bs-toggle="collapse" href="#xui-basiccccc" aria-expanded="false" aria-controls="ui-basic">
                        <i  class="ti-game menu-icon"></i>
                        <span class="menu-title">Market Management</span>
                        <i class="menu-arrow"></i></a>
                    <div class="collapse" id="xui-basiccccc">
                      <ul class="nav flex-column sub-menu">
                            <!--<li class="nav-item"><a class="nav-link" href="market_list.php">Market</a></li>-->
                            <!--<li class="nav-item"><a class="nav-link" href="market_list_manual.php">Market Manual</a></li>-->
                            <!--<li class="nav-item"><a class="nav-link" href="starline_markets.php">Starline Market</a></li>-->
                            <li class="nav-item"><a class="nav-link" href="market_list_delhi.php">Delhi Market</a></li>
                            <li class="nav-item"><a class="nav-link" href="card_timings.php">Card Market</a></li>
                            <!--<li class="nav-item"><a class="nav-link" href="jackpot_markets.php">Jackpot Market</a></li>-->
                            
                        </ul>
                    </div>
                </li>
                
                 <li class="nav-item">
                    <a class="nav-link" href="withdraw_pending.php">
                        <i class="ti-user menu-icon"></i>
                        <span class="menu-title">Withdraw Pending</span>
                        <span id="withdraw" style="margin-left:3px;font-size:15px; color:red;font-weight:900; padding:1px 8px; border-radius:100%;"></span>
                        
                    </a>
                </li>
                
                <li  class="nav-item">
                    <a class="nav-link" href="upi_verification.php">
                        <i class="ti-money menu-icon"></i>
                        <span class="menu-title">UPI Verification</span>
                        
                        <span id="upi_verify" style="margin-left:3px;font-size:15px; color:red;font-weight:900; padding:1px 8px; border-radius:100%;"></span>
                    </a>
                </li>
                
                
                <!--<li class="nav-item">-->
                <!--    <a class="nav-link" href="batch_history_list.php">-->
                <!--        <i class="ti-write menu-icon"></i>-->
                <!--        <span class="menu-title">Publish History</span>-->
                <!--    </a>-->
                <!--</li>-->
                
                <li class="nav-item">
                    <a class="nav-link" href="card_report.php">
                        <i class="ti-write menu-icon"></i>
                        <span class="menu-title">Card Report</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="get_bet_history.php">
                        <i class="ti-write menu-icon"></i>
                        <span class="menu-title">Bet History</span>
                    </a>
                </li>
                
                
                <li class="nav-item">
                    <a class="nav-link" href="get_winning_report.php">
                        <i class="ti-write menu-icon"></i>
                        <span class="menu-title">Winning History</span>
                    </a>
                </li>
                
                
                
                <li class="nav-item">
                    <a class="nav-link" href="depo_and_with_report.php">
                        <i  class="ti-write menu-icon"></i>
                        <span  class="menu-title">Account</span>
                    </a>
                </li>
                 
                <!--<li class="nav-item">-->
                <!--    <a class="nav-link" href="get_razorpay_deposit_report.php">-->
                <!--        <i class="ti-crown menu-icon"></i>-->
                <!--        <span  class="menu-title">Razorpay Deposit</span>-->
                <!--    </a>-->
                <!--</li>-->
                
                 <li class="nav-item">
                     <a class="nav-link" data-bs-toggle="collapse" href="#xui-basiccc" aria-expanded="false" aria-controls="ui-basic">
                        <i  class="ti-game menu-icon"></i>
                        <span class="menu-title">User Management</span>
                        <i class="menu-arrow"></i></a>
                    <div class="collapse" id="xui-basiccc">
                      <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="users.php">Total Registered Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="tusers.php">Today Registered Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="get_playing_user.php">Total Playing Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="get_tplaying_user.php">Today Playing Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="buser.php">Blocked Users</a></li>
                        </ul>
                    </div>
                </li>
                
                
                
                <li class="nav-item">
                    <a class="nav-link" href="image_slider.php">
                        <i class="ti-crown menu-icon"></i>
                        <span class="menu-title">Image Slider</span>
                    </a>
                </li>
                
                
                    <li class="nav-item">
                    <a class="nav-link" href="profit_loss.php">
                        <i class="ti-home menu-icon"></i>
                        <span class="menu-title">Profit Loss</span>
                    </a>
                </li>
                   
                   
                <li class="nav-item">
                    <a class="nav-link" href="market_hisab_range.php">
                        <i class="ti-home menu-icon"></i>
                        <span class="menu-title">Market Report</span>
                    </a>
                </li>
                  
                 
                <li class="nav-item">
                    <a class="nav-link" href="wallet_report.php">
                        <i  class="ti-home menu-icon"></i>
                        <span class="menu-title">Wallet Report</span>
                    </a>
                </li>
                   
                  
                <li class="nav-item">
                     <a class="nav-link" data-bs-toggle="collapse" href="#xui-basic" aria-expanded="false" aria-controls="ui-basicc">
                        <i class="ti-game menu-icon"></i>
                        <span  class="menu-title">Transaction Report</span>
                        <i class="menu-arrow"></i></a>
                    <div class="collapse" id="xui-basic">
                      <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="get_deposit_report.php">Deposit</a></li>
                            <li class="nav-item"><a class="nav-link" href="get_withdraw_report.php">Withdraw</a></li>
                        </ul>
                    </div>
                </li>
                
                 
                    <li class="nav-item">
                    <a class="nav-link" href="market_hisab.php">
                        <i class="ti-home menu-icon"></i>
                        <span class="menu-title">My Hisab</span>
                    </a>
                </li>
                 
                 
                <li class="nav-item">
                    <a class="nav-link" href="deposit_requests.php">
                        <i class="ti-home menu-icon"></i>
                        <span class="menu-title">Pending Deposits</span>
                    </a>
                </li>
                    
                
                 
                <li class="nav-item">
                    <a class="nav-link" href="deposit_completed.php">
                        <i class="ti-home menu-icon"></i>
                        <span class="menu-title">Completed Deposits</span>
                    </a>
                </li>
                    
                
                   
               
                
                   
                <li class="nav-item">
                    <a class="nav-link" href="withdraw_cancel.php">
                        <i  class="ti-user menu-icon"></i>
                        <span class="menu-title">Withdraw Cancel</span>
                    </a>
                </li>
                
                   
                <li class="nav-item">
                    <a class="nav-link" href="withdraw_requests.php">
                        <i  class="ti-user menu-icon"></i>
                        <span  class="menu-title">Withdraw Completed</span>
                    </a>
                </li>
                
                    
                <li class="nav-item">
                    <a class="nav-link" href="withdraw_modes.php">
                        <i  class="ti-user menu-icon"></i>
                        <span  class="menu-title">Withdraw Methods</span>
                    </a>
                </li>
                  
                
                
                
                 
                
                <!--<li class="nav-item">-->
                <!--    <a class="nav-link" href="market_list_auto.php">-->
                <!--        <i class="ti-crown menu-icon"></i>-->
                <!--        <span class="menu-title">Auto Markets</span>-->
                <!--    </a>-->
                <!--</li>-->
                
                
                <!--<li class="nav-item">-->
                <!--   <a class="nav-link" href="market_list_manual_auto.php">-->
                <!--        <i class="ti-crown menu-icon"></i>-->
                <!--      <span class="menu-title">Markets Manual Auto</span>-->
                <!--  </a>-->
                <!--</li>-->
                
               
                
                
                 <li class="nav-item">
                    <a class="nav-link" href="transactions.php">
                        <i  class="ti-crown menu-icon"></i>
                        <span class="menu-title">All Transactions</span>
                    </a>
                </li>
                
                
                  
               
                <li class="nav-item">
                     <a class="nav-link" data-bs-toggle="collapse" href="#anal" aria-expanded="false" aria-controls="ui-basic">
                        <i class="ti-game menu-icon"></i>
                        <span class="menu-title">Market Analysis</span>
                        <i class="menu-arrow"></i></a>
                    <div class="collapse" id="anal">
                      <ul class="nav flex-column sub-menu">
                            <!--<li class="nav-item"><a class="nav-link" href="analysis_markets.php?game=single">Single</a></li>-->
                            <!--<li class="nav-item"><a class="nav-link" href="analysis_markets.php?game=jodi">Jodi</a></li>-->
                            <!--<li class="nav-item"><a class="nav-link" href="analysis_markets.php?game=panna">Panna</a></li>-->
                            <!--<li class="nav-item"><a class="nav-link" href="analysis_markets.php?game=halfsangam">Half Sangam</a></li>-->
                            <!--<li class="nav-item"><a class="nav-link" href="analysis_markets.php?game=fullsangam">Full Sangam</a></li>-->
                            <!--<li class="nav-item"><a class="nav-link" href="starline_markets_anal.php">Starline</a></li>-->
                            <li class="nav-item"><a class="nav-link" href="delhi_markets_anal.php?game=single">Delhi Single</a></li>
                            <li class="nav-item"><a class="nav-link" href="delhi_markets_anal.php?game=jodi">Delhi Jodi</a></li>
                        </ul>
                    </div>
                </li>
                
               
                             
                 
                
                
               <li class="nav-item">
                    <a class="nav-link" href="notification.php">
                        <i  class="ti-alert menu-icon"></i>
                        <span  class="menu-title">Send Notification</span>
                    </a>
                </li>
                

                             
                 <li class="nav-item">
                    <a class="nav-link" href="rate.php">
                        <i class="ti-money menu-icon"></i>
                        <span  class="menu-title">Rates</span>
                    </a>
                </li>
                
                
                
                 <li class="nav-item">
                    <a class="nav-link" href="rates.php">
                        <i  class="ti-info-alt menu-icon"></i>
                        <span class="menu-title">App Rates Text</span>
                    </a>
                </li>
                
                
            

     
                <li class="nav-item">
                    <a class="nav-link" href="refers.php">
                        <i  class="ti-link menu-icon"></i>
                        <span class="menu-title">Refers</span>
                    </a>
                </li>
                
                 <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                        <i class="ti-files menu-icon"></i>
                        <span class="menu-title">Content</span>
                        <i class="menu-arrow"></i></a>
                   <div class="collapse" id="ui-basic">
                      <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="addnotice.php">Notice</a></li>
                            <li class="nav-item"><a class="nav-link" href="homeline.php">Homescreen text</a></li>
                            <li class="nav-item"><a class="nav-link" href="howtoplay.php">How to play</a></li>
                        </ul>
                    </div>
                </li>
                
                  <li class="nav-item">
                    <a class="nav-link" href="settings.php">
                        <i class="ti-settings menu-icon"></i>
                        <span class="menu-title">Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="app_updates.php">
                        <i class="ti-write menu-icon"></i>
                        <span class="menu-title">App updates</span>
                    </a>
                </li>
          
          
          
          
        </ul>
      </nav>
      
      
      <script type="text/javascript">
      
    //   function upi(){
    //       const xhttp = new XMLHttpRequest();
    //       xhttp.onload = function(){
    //           document.getElementById("upi_verify").innerHTML = this.responseText;
    //           document.getElementById("upi_verify_1").innerHTML = this.responseText;
    //       }
          
    //       xhttp.open("GET","upi_get.php");
    //       xhttp.send();
    //   }
      
    //   setInterval(function(){
    //       upi();
    //   }, 1)
      
      
      
    //   function withdraw(){
    //       const xhttp = new XMLHttpRequest();
    //       xhttp.onload = function(){
    //           document.getElementById("withdraw").innerHTML = this.responseText;
    //           document.getElementById("withdraw_1").innerHTML =this.responseText;
    //       }
          
    //       xhttp.open("GET","withdraw_get.php");
    //       xhttp.send();
    //   }
      
    //   setInterval(function(){
    //       withdraw();
    //   }, 1)
          
      </script>