<?php 
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}


if (isset($_GET['term'])) {
     
   $query = "SELECT * FROM users WHERE mobile LIKE '{$_GET['term']}%' OR name LIKE '{$_GET['term']}%' LIMIT 25";
    $result = query($query);
 
    if (rows($result) > 0) {
     while ($user = fetch($result)) {
      $res[] = $user['mobile'];
     }
    } else {
      $res = array();
    }
    //return json res
    echo json_encode($res);
}
?>