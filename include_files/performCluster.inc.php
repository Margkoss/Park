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
                $point_ids[$i] = 'point.'.($i+$idc);
                array_push($allpoints, array('x'=>$randomPoints[$i]['x'],'y'=>$randomPoints[$i]['y'],'id'=>$point_ids[$i]));
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
            unset($randomPoints);
        }
        
        //At this point we have clusters of all the points and we look for the cluster with most points
        $max = 0;
        $maxCluster = array();
        for($i = 0; $i < sizeof($clusterArray); $i++){

            for($j = 0; $j < sizeof($clusterArray[$i]); $j++){

                if(sizeof($clusterArray[$i][$j]) > $max){
                    $max = sizeof($clusterArray[$i][$j]);
                    $maxCluster = $clusterArray[$i][$j];
                }

            }

        }

        //sort the $maxCluster 
        sortPoints($maxCluster);
        
        //Find the ids of maxCluster in allpoints
        $j = 0;
        $clusterCoords = array();
        for($i = 0; $i < sizeof($maxCluster); $i++){

            $found = false;

            while(!$found){

                if($allpoints[$j]['id'] == $maxCluster[$i]){
                    array_push($clusterCoords,array('x'=>$allpoints[$j]['x'], 'y'=>$allpoints[$j]['y']));
                    $found = true;
                }
                $j++;

            }

        }
        // Find the centroid of the cluster
        $whereTo = getClusterCentroid($clusterCoords);
        echo json_encode($whereTo);
        

    }else{

        header("Location: ../main/?login=malicious");
        exit();

    }
