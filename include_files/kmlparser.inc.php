<?php
    include('functions.inc.php');
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
        //We procced to parsing the kml file
        if(strcmp($fileExtension,"kml") == 0){
            
            //Treat kml as any other xml
            $kml = simplexml_load_file($fileTmpName);

            
            foreach($kml->Document->Folder->Placemark as $pm){
            
                //looking for description and 
                //gather all values from it
                if(isset($pm->description)){

                    $desc = $pm->description;
                    $values = findValues($desc);

                }


                //looking for Polygon data 
                //gathering coordinates and centroids
                if(isset($pm->MultiGeometry->Polygon)){
                    
                    $coordinates = $pm->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates;
                    $centroidCoords = locateCentroid($coordinates);

                }

                //At this point coordinates in $coordinates,
                //gid,esye and population in $values and
                //polygon centroids in $centroidCoords, so we 
                //are ready to parse everything to the DB


                //prevent admin mistake by escaping the kml variables
                $gid = mysqli_real_escape_string($conn, $values['gid']);
                $esye = mysqli_real_escape_string($conn,$values['esye']);
                $population = mysqli_real_escape_string($conn,$values['population']);
                $coordinates = mysqli_real_escape_string($conn,$coordinates);
                $centroidCoords = mysqli_real_escape_string($conn,$centroidCoords);

                $sql = "INSERT INTO kml_data (gid, esye, population, coordinates, centroid) 
                        VALUES ('$gid', '$esye', '$population', '$coordinates', '$centroidCoords')";
                mysqli_query($conn, $sql);
                
            }
            echo "OK";
        }
        else{
            http_response_code(403);
        }
        
    }
    else{
        //error message
        echo"nofile";
    }