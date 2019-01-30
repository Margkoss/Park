<?php

//Check for if the script was called by the submit button
//on the admin edit navbar
if (isset($_POST['submit'])){

    //Connect to the database
    include_once 'databaseHandler.inc.php';

    //Get the population and distribution curve assigned to 
    //the city block
    $gid = mysqli_real_escape_string($conn, $_POST['gid']);
    $population = mysqli_real_escape_string($conn, $_POST['population']);
    $distributionCurve = mysqli_real_escape_string($conn, $_POST['distribution_curve']);

    //Error handlers
    //Check if both of the inputs are empty
    if (empty('$population') && empty('$distributionCurve')){

        //No need to update the database
        echo "Nothing to be changed";
        exit();

    } elseif (empty('$population')) {
        
        //Change the distribution curve assigned provided that it's of value
        //1, 2 or 3
        if ($distributionCurve==1 || $distributionCurve==2 || $distributionCurve==3){
            $sql = "UPDATE kml_data SET distributionCurveNo=$distributionCurve WHERE gid=$gid";

            //Check if table was updated successfully and respond accordingly
            if (mysqli_query($conn, $sql)){
                echo "Database updated successfully";
            }else{
                echo "Error updating database";
            }
            exit();
        }else{
            echo "Invalid values";
        }

    } elseif (empty('$distributionCurve')) {

        //Update the population of the block
        $sql = "UPDATE kml_data SET population=$population WHERE gid=$gid";

        //Check for successfull update
        if (mysqli_query($conn, $sql)){
            echo "Database updated successfully";
        }else{
            echo "Error updating Database";
        }
        exit();
    } else {
        //Update both values in the database
        if ($distributionCurve==1 || $distributionCurve==2 || $distributionCurve==3){
            $sql = "UPDATE kml_data SET population=$population, distributionCurveNo=$distributionCurve WHERE gid=$gid"

            if (mysqli_query($conn, $sql)){
                echo "Database updated successfully";
            }else{
                echo "Error updating Database";
            }
            exit();
        }else{
            echo "Invalid values"
            exit();
        }
    }
} else {
    exit();
}
