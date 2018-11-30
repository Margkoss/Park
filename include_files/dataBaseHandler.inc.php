<?php

//Information needed to connect to database
//In development using XAMPP with default values
$dbServerName = "localhost";
$dbUserName = "root";
$dbPassowrd = "";
$dbName = "Park";

//Variable that holds connection to database
$conn = mysqli_connect($dbServerName, $dbUserName, $dbPassowrd, $dbName);