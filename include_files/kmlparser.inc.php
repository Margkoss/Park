<?php
    

    //Check if there is a file being uplaoded to this 
    //script by our ajax form
    if(isset($_FILES['file']['tmp_name']) && $_FILES['file']['error'] == 0){
        
        //Variables for all the $_FILES attributes
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileType = $_FILES['file']['type'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];

        
    }
    else{
        //error message
        echo"nofile";
    }