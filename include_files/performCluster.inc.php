<?php

    $mitsos = $_POST['includedArray'];

    for($i=0 ; $i<sizeof($mitsos);$i++){
        $mitsos[$i] = explode(",",$mitsos[$i]);
    }
    print_r($mitsos);