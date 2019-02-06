<?php

    include_once ("dataBaseHandler.inc.php");


    //Get athens time zone
    date_default_timezone_set('Europe/Athens');
    if(isset($_GET['time'])){
        $time = explode(":",$_GET['time']);
        $time = intval($time[0]);
    }else{
        $time = intval(date("H"));
    }
    
    

    //Database query to get the coordinates column
    $sqlKML = "SELECT * FROM kml_data;";
    $result = mysqli_query($conn, $sqlKML);
    $resultCheck = mysqli_num_rows($result);


    if ($resultCheck > 0) {
        //creating the geoJSON to be sent to javascript
        $geoJSON = array("type"=>"FeatureCollection","features"=>array());

        while ($row = mysqli_fetch_assoc($result)) {
            //Retrive the centroid coordinates
            $centroidCoords = explode(" ",$row['centroid']);
            $centroidCoords = array(floatval($centroidCoords[1]),floatval($centroidCoords[0]));

            //Retrieve the coordinates in the correct order from DB
            $breakString = explode(" ",$row['coordinates']);
            for($i=0 ; $i<sizeof($breakString) ; $i++)
            {
                $coordinates = explode(",",$breakString[$i]);
                $breakString[$i] = array(floatval($coordinates[0]),floatval($coordinates[1]));
            }

            //Find out the how many of the spaces are wanted
            $column = "dist".$row['distributionCurveNo'];
            $sqlDistrib = "SELECT $column FROM distributions
                           WHERE hour=$time ;";
            $demandPercent = mysqli_fetch_array(mysqli_query($conn, $sqlDistrib));

            //calculate taken positions percentage
            $constantDemand = intval($row['population']*0.20);
            $demandAtThisTime = $constantDemand + intval(intval($row['parkingSpots'])*floatval($demandPercent[0]));
            $takenPer = $demandAtThisTime/intval($row['parkingSpots']);
            
            //calculate available positions
            if($demandAtThisTime >= intval($row['parkingSpots'])){
                $available = 0;
            }else{
                $available = intval($row['parkingSpots']) - $demandAtThisTime;
            }

            if($takenPer > 1)
            {
                $takenPer = 1;
            }
            //Make the array that is pushed in the geoJSON features array
            $arrayToBePushed = array("type"=>"Feature",
                                    "properties"=>array("gid"=>$row['gid'],
                                        "time"=>$time,
                                        "esye"=>$row['esye'],
                                        "availableSpots"=>$available,
                                        "centroid"=>$centroidCoords,
                                        "population"=>intval($row['population']),
                                        "parkingSpots"=>intval($row['parkingSpots']),
                                        "taken"=>floatval($takenPer)),
                                    "geometry"=>array("type"=>"Polygon","coordinates"=>array($breakString)));

            array_push($geoJSON['features'],$arrayToBePushed);
        }
        echo json_encode($geoJSON);
    }
?>