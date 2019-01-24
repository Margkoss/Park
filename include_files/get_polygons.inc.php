<?php

    include_once ("dataBaseHandler.inc.php");

?>


<?php


    //Database query to get the coordinates column
    $sql = "SELECT coordinates FROM kml_data;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);


    if ($resultCheck > 0) {

        $big_array = array();

        while ($row = mysqli_fetch_assoc($result)) {
            //Seperate the coordinates from each other in an array
            $break = explode(" " ,$row['coordinates']);
            
            //Seperate the array in to x,y coordinates
            //and get them in reverse order
            for ($i=0; $i<sizeof($break); $i++) {
                $stuff = explode("," , $break[$i]);
                $break[$i] = array($stuff[1],$stuff[0]);
            }
            
            array_push($big_array,$break);
        }
        echo json_encode($big_array);
    }
?>