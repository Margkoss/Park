<?php

    include_once('dataBaseHandler.inc.php');

    //Check if there is a file being uplaoded to this 
    //script by our ajax form
    if(isset($_FILES['file']['tmp_name']) && $_FILES['file']['error'] == 0){
        
        //Variables for all the $_FILES attributes
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileType = $_FILES['file']['type'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];

        //Checking wether the file has the correct extension
        $fileExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($fileExtension));
        
        //If the file has the correct extension
        //We procced to parsing the csv file
        if(strcmp($fileExtension,"csv") == 0){
            $csv = file($fileTmpName);

            for($i = 0; $i < sizeof($csv); $i++)
            {
                $csv[$i] = explode(";",$csv[$i]);
            }

            $distributions = array();

            for($i = 2; $i < sizeof($csv); $i++)
            {
                $row = array("hour"=>$csv[$i][0],"dist1"=>$csv[$i][1],"dist2"=>$csv[$i][2],"dist3"=>$csv[$i][3]);
                
                $hour = mysqli_real_escape_string($conn,$row['hour']);
                $dist1 = mysqli_real_escape_string($conn,$row['dist1']);
                $dist2 = mysqli_real_escape_string($conn,$row['dist2']);
                $dist3 = mysqli_real_escape_string($conn,$row['dist3']);

                $sql = "INSERT INTO  distributions(hour, dist1, dist2, dist3) 
                        VALUES ('$hour','$dist1','$dist2','$dist3')";
                mysqli_query($conn, $sql);
                
            }
            echo "Done";
        }
        else
        {
            http_response_code(403);
        }
    }
    else
    {
        echo "nofile";
    }