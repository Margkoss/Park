<?php
/******************CLUSTER FUNCTIONS****************** */

//Helper function for getting the distance between two points 
function getDistanceFromPoint($x1,$y1,$x2,$y2){
    return sqrt(pow($x2-$x1,2) + pow($y2-$y1,2));
}

//Helper function that returns a random float
function getRandomFloat(){
    return mt_rand() / mt_getrandmax();
}

//Function that generates $times random points, within $radius meters of $center
function getRandomPoints($times,$radius,$center){
    $x = $center[0];
    $y = $center[1];

    $radius = $radius;

    $points = array();
    
    for($i = 0; $i < $times; $i++){
        $a = 2*M_PI*getRandomFloat();
        $r = sqrt(getRandomFloat());

        $miniClusters['x'] = ($radius*$r)*cos($a)+$x;
        $miniClusters['y'] = ($radius*$r)*sin($a)+$y;

        array_push($points,$miniClusters);
    }
    return $points;
}


/******************KML FUNCTIONS********************* */
//function for mapping the a value between 20-120
function mapValue($area)
{
    switch(true)
    {
        case ($area >= 0 && $area < 3):
            return rand(20,40);
        break;
        case ($area >=3 && $area < 6):
            return rand(40,60);
        break;
        case ($area >=6 && $area <= 9):
            return rand(60,80);
        break;
        default:
            return rand(80,120);
        break;
    }
}


//function for getting gid from description
function getGid($descString){

    $descString = strip_tags($descString);
    preg_match("/gid: [0-9]{1,6}/",$descString,$gidNameValue);
    $gid = explode(": ",$gidNameValue[0]);
    $gid = end($gid);
    return (int)$gid;

}

//function for getting ESYE_CODE from description
function getEsyeCode($descString){

    $descString = strip_tags($descString);
    preg_match("/ESYE_CODE: [0-9]{1,6}/",$descString,$esyeNameValue);
    $esye = explode(": ",$esyeNameValue[0]);
    $esye = end($esye);
    return (int)$esye;

}

//function for getting population from description
function getPopulation($descString){

    $descString = strip_tags($descString);
    preg_match("/Population: [0-9]{1,10}/",$descString,$populationNameValue);
    $population = explode(": ",$populationNameValue[0]);
    $population = end($population);
    return (int)$population;

}


//Function for finding the values of the KML description
function findValues($descriptionString){

    $gid = getGid($descriptionString);
    $esye_code = getEsyeCode($descriptionString);

    if(preg_match("/Population/",$descriptionString))
    {
        $population = getPopulation($descriptionString);
    }
    else
    {
        $population = 0;
    }

    $value['gid'] = $gid;
    $value['esye'] = $esye_code;
    $value['population'] = $population;

    return $value;
}


//Function for calculating the area of a polygon
function getAreaOfPolygon($polyCoordsArray)
{
    //NO IDEA
    $area = 0;

    for ($vi=0, $vl=sizeof($polyCoordsArray); $vi<$vl; $vi++) {
        $thisx = $polyCoordsArray[ $vi ][0];
        $thisy = $polyCoordsArray[ $vi ][1];
        $nextx = $polyCoordsArray[ ($vi+1) % $vl ][0];
        $nexty = $polyCoordsArray[ ($vi+1) % $vl ][1];
        $area += ($thisx * $nexty) - ($thisy * $nextx);
    }


    // done with the rings: "sign" the area and return it
    $area = abs(($area / 2));
    return $area;

}




//Function for locating the centroid of
//every block
function LocateCentroid($polyCoords)
{
    
    //Turning the long string of coordinates into an array of x,y pairs
    $polyCoordsArray = explode(" ", $polyCoords);

    //Turning the array into an array of 2-element lists of coordinates
    //and turning them into numeric values
    for($i=0 ; $i < sizeof($polyCoordsArray) ; $i++)
    {
        $polyCoordsArray[$i] = explode(",",$polyCoordsArray[$i]);
        foreach($polyCoordsArray[$i] as $ypocoord)
        {
            $ypocoord = doubleval($ypocoord);
        }
    }
    

    //After insuring that we have an array with the points of the 
    //perimeter of the polygon we proceed with the calculation of the 
    //centroid


    //Centroid coordinates
    $cx = 0;
    $cy = 0;

    //NO IDEA
    for ($vi=0, $vl=sizeof($polyCoordsArray); $vi<$vl; $vi++) 
    {
        $thisx = $polyCoordsArray[ $vi ][0];
        $thisy = $polyCoordsArray[ $vi ][1];
        $nextx = $polyCoordsArray[ ($vi+1) % $vl ][0];
        $nexty = $polyCoordsArray[ ($vi+1) % $vl ][1];

        $p = ($thisx * $nexty) - ($thisy * $nextx);
        $cx += ($thisx + $nextx) * $p;
        $cy += ($thisy + $nexty) * $p;
    }


    // last step of centroid: divide by 6*A
    $area = getAreaOfPolygon($polyCoordsArray);
    $cx = -$cx / ( 6 * $area);
    $cy = -$cy / ( 6 * $area);

    //Returning the centroid coordinates as a string
    $centroidCoordinates = (string)$cx." ".(string)$cy;
    return $centroidCoordinates;
}

//Function to calculate parking spots for each block
function calculateParkingSpots($polycoords)
{
    $polyCoordsArray = explode(" ", $polycoords);

    for($i=0 ; $i < sizeof($polyCoordsArray) ; $i++)
    {
        $polyCoordsArray[$i] = explode(",",$polyCoordsArray[$i]);
        foreach($polyCoordsArray[$i] as $ypocoord)
        {
            $ypocoord = doubleval($ypocoord);
        }
    }
    $area = getAreaOfPolygon($polyCoordsArray);
    $area = explode('.',strval($area));
    $area = intval($area[0]);

    $parkingSpots = mapValue($area);
    return $parkingSpots;
}