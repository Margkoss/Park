<?php

    include_once ("dataBaseHandler.inc.php");

?>

<pre>

<?php


    //Database query to get the coordinates column
    $sql = "SELECT coordinates FROM kml_data;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);


    if ($resultCheck > 0) {

        
        while ($row = mysqli_fetch_assoc($result)) {
            //Seperate the coordinates from each other in an array
            $break = explode(" " ,$row['coordinates']);
            
            //Seperate the array in to x,y coordinates
            for ($i=0; $i<sizeof($break); $i++) {
                $break[$i] = explode("," , $break[$i]);
            }
            //debug
            print_r($break);
        }

    }
?>