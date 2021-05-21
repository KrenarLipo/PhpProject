<?php
   session_start();
   session_destroy(); //per te shkateruar gjthe sesionet aktive
//    if(isset($_SESSION["username"])){
//        unset($_SESSION["username"]);
//        header("location: login.php");
//    }
 header("location: login.php");
?>