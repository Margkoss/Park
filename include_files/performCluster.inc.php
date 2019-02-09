<?php

    include_once('functions.inc.php');
    require_once('DBSCANclass.inc.php');

    if(isset($_POST['includedArray'])){
        $blocks = json_decode($_POST['includedArray'],true);
        $clusterArray = array();
        $allpoints = array();

        $idc = 0;
        foreach($blocks as $b){
            $point_ids = array();
            $distanceMatrix = array();


            $randomPoints = getRandomPoints($b['parkingSpots'],50,$b['centroid']);
            

            //Generate point ids
            for($i=0;$i<sizeof($randomPoints);$i++){
                $point_ids[$i] = 'point'.($i+$idc);
                array_push($allpoints,$randomPoints[$i]);
                $allpoints[$i]['id']=$point_ids[$i];
            }
            $idc += sizeof($randomPoints);

            //Generate distance matrix
            for($i=0;$i<sizeof($point_ids);$i++){

                for($j=$i+1;$j<sizeof($point_ids);$j++){
                    $distanceMatrix[$point_ids[$i]][$point_ids[$j]] =
                        getDistanceFromPoint($randomPoints[$i]['x'],$randomPoints[$i]['x'],$randomPoints[$j]['x'],$randomPoints[$j]['x']);
                }
                
            }
            $distanceMatrix[end($point_ids)] = array();
           
            //DBSCAN object
            $DBSCAN = new DBSCAN($distanceMatrix,$point_ids);

            $clusters = $DBSCAN->dbscan(30,3);
            array_push($clusterArray,$clusters);
            unset($point_ids);
            unset($distanceMatrix);
        }
        print_r($allpoints);
    }
