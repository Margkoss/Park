<?php
    include('functions.inc.php');

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
        //We procced to parsing the kml file
        if(strcmp($fileExtension,"kml") == 0){
            
            $kml = simplexml_load_file($fileTmpName);

            echo "<pre>";

            foreach($kml->Document->Folder->Placemark as $pm){

                if(isset($pm->MultiGeometry->Polygon)){

                    $coordinates = $pm->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates;

                    $centroidCoords = locateCentroid($coordinates);

                    
                    print_r($centroidCoords);
                    echo "<br><br>";
                }
            }
        }
        else{
            http_response_code(403);
        }
        
    }
    else{
        //error message
        echo"nofile";
    }