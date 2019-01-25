<?php

    include_once ("dataBaseHandler.inc.php");


    //Database query to get the coordinates column
    $sql = "SELECT * FROM kml_data;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);


    if ($resultCheck > 0) {
        //creating the geoJSON to be sent to javascript
        $geoJSON = array("type"=>"FeatureCollection","features"=>array());

        while ($row = mysqli_fetch_assoc($result)) {
            
            //Retrieve the coordinates in the correct order from DB
            $breakString = explode(" ",$row['coordinates']);
            for($i=0 ; $i<sizeof($breakString) ; $i++)
            {
                $coordinates = explode(",",$breakString[$i]);
                $breakString[$i] = array(floatval($coordinates[0]),floatval($coordinates[1]));
            }

            //Make the array that is pushed in the geoJSON features array
            $arrayToBePushed = array("type"=>"Feature",
                                    "properties"=>array("gid"=>$row['gid'],
                                        "esye"=>$row['esye'],
                                        "centroid"=>$row['centroid'],
                                        "population"=>intval($row['population'])),
                                    "geometry"=>array("type"=>"Polygon","coordinates"=>array($breakString)));

            array_push($geoJSON['features'],$arrayToBePushed);
        }
        echo json_encode($geoJSON);
    }
?>