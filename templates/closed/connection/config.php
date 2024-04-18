<?php
ob_start();
session_start();

define("zone",  'Asia/Kolkata');    /** FIND YOUR TIMEZONE - https://www.php.net/manual/en/timezones.php */

define("SALT","Z~Zhy}~FVaJmY:oGmjQ8a/AEe7&F3|pco(vdHnM%9d`]50(Og^hUyoZ:$?maZ^m");    /** 504 bit SALT TO SECURE PASSWORD */

$stamp = time();

$firebase_key = "AAAArx_Y120:APA91bHUd0hYmLoyf_98eq_so2N06os-RIvPVL89d0QUMoLZehJDHnTwDgIh6FALmeDLJJvYER6Ne0vJV_5d9huvgWKG_-Q6W7MX4EytvfUqVINXYA1sprCfWxyM6fiGGWWLU2RIhfxb";

define("firebase_key","$firebase_key");               /** ENTER DATABASE USER PASSWORD */

include "lib/lib.php";


if(isset($_SESSION['verified']) && isset($_SESSION['request_params'])){
        
        $_REQUEST = $_SESSION['request_params'];
        
       // print_r($_REQUEST);
        
}

function verification(){
    
    if(isset($_SESSION['verified'])){
        
        $_REQUEST = $_SESSION['request_params'];
        
        unset($_SESSION['verified']);
        unset($_SESSION['request_params']);
        unset($_SESSION['request_url']);
        
        
    } else {
        
        $_SESSION['request_params'] = $_REQUEST;
        $_SESSION['request_url'] = basename($_SERVER['REQUEST_URI']);
        unset($_REQUEST);
        
        redirect('password_verification.php');
        exit;
        
    }
    
    
    
}


include "/home2/srkgac2u/public_html/functions.php";

function sendNotiicaton($body,$title, $topic = "all"){
    
     $msg = array
    (
        'body'  => $body,
        'title'     => $title,
        'vibrate'   => 1,
        'sound'     => 1,
    );
    
    $fields = array
    (
        'to'  => '/topics/'.$topic,
        'notification'          => $msg
    );
    
      
    $headers = array
    (
        'Authorization: key='.constant('firebase_key'),
        'Content-Type: application/json'
    );
    
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );
    
}
