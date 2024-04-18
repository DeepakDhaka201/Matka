<?php
include "connection/config.php";

if (!checks("admin"))
{
    redirect("login.php");
}


if (isset($_REQUEST['submit']))
{
    extract($_REQUEST);
    
    $email = $_SESSION['email'];

    $pass = pass($pass);

    $xc = query("select sn from admin where email='$email' AND password='$pass'");

    if (rows($xc) > 0)
    {
        $_REQUEST = $_SESSION['request_params'];
        $url = $_SESSION['request_url'];
        $_SESSION['verified'] = "true";
        
        redirect($url);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Partner Panel</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/horizontal-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  
  <style>
      .main-panel {
            width: 100%;
            height: 100vh;
      }
      
      .content-wrapper {
          background:#696969;
      }
      
      .auth-form-light {
          border-radius:10px;
      }
  </style>
</head>

<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
   <div class="main-panel">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                  <div class="brand-logo">
                    <a style="color: black;font-weight: 600;font-size: 35px;">Verification</a>
                </div>
                <h4>Enter your password to continue</h4>
                <h6 class="font-weight-light">This action required password verification for security reasons</h6>
                <form class="pt-3" method="post">
                 
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="pass" placeholder="Password">
                  </div>
                  <div class="mt-3">
                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="submit" type="submit">VERIFY</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
</body>


</html>
