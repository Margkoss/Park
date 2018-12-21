<?php

    if(isset($_POST['delete']))
    {
        require_once('dataBaseHandler.inc.php');
        $sql = "TRUNCATE TABLE kml_data;";
        mysqli_query($conn, $sql);
        echo "DONE"; 
    }
    else
    {
        header("Location: ../main/?login=malicious");
    }