<?php
    //Beggin an admin session
    session_start();
    //navbar requirements
    require('../main/header.php');

    //Check if the session was set correctly 
    //or maliciously , and if so redirect
    if(isset($_SESSION['a_id'])){
        echo "<h1>Welcome " . $_SESSION['a_first_name'] . "</h1>";
    }else{
        header("Location: ../main/?login=malicious");
        exit();   
 }
?>