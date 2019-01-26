<?php
    //Beggin an admin session
    session_start();
    //navbar requirements
    require('../main/header.php');

    //Check if the session was set correctly 
    //or maliciously , and if so redirect
    if(isset($_SESSION['a_id'])){
        echo "<h3>Welcome " . $_SESSION['a_first_name'] . "</h3>";
    } else{
        header("Location: ../main/?login=malicious");
        exit();   
    }
?>

<link rel="stylesheet" href="../css/admin-page.css">


<section class="container section" id="tabss">
    <div>
        <ul class="tabs">
            <li class="tab">
                <a href="#upload">Upload KML</a>
            </li>
            <li class="tab">
                <a href="#csv">Upload CSV</a>
            </li>
            <li class="tab">
                <a  href="#logout">Logout</a>
            </li>
            <li class="tab">
                <a href="#database">Database</a>
            </li>
            <li class="tab">
                <a href="#map">Map</a>
            </li>
        </ul>
    </div>
    <br><br><br>
    <div id="upload">
        <h2 class="yellow-text text-darken-1">Upload KML</h2>
        <p>Upload the KML file with the proper population data</p>
        <br><br>
        <div class="center">
            <form id="file-form" action="../include_files/kmlparser.inc.php" method="post">
                <div class="file-field">
                <div class="btn yellow darken-1 black-text">
                    <span>KML File</span>
                    <input id="file_input" type="file" name="file">
                </div>
                <div class="file-path-wrapper">
                    <input id="file-path-text" class="file-path" type="text">
                </div>
                </div>
                <div class="input-field">
                    <button id="kml_submit" name="kml-submit" type="submit" class="btn yellow darken-1 waves-effect waves-light black-text">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div id="csv">
        <h2 class="yellow-text text-darken-1">Upload CSV</h2>
        <p>Upload the CSV file with the distribution curve data</p>
        <br><br>
        <div class="center">
            <form id="file-form2" action="../include_files/csvparser.inc.php" method="post">
                <div class="file-field">
                <div class="btn yellow darken-1 black-text">
                    <span>CSV File</span>
                    <input id="file_input2" type="file" name="file2">
                </div>
                <div class="file-path-wrapper">
                    <input id="file-path-text2" class="file-path" type="text">
                </div>
                </div>
                <div class="input-field">
                    <button id="csv_submit" name="csv-submit" type="submit" class="btn yellow darken-1 waves-effect waves-light black-text">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div id="logout">
        <h2 class="yellow-text text-darken-1">Logout</h2>
        <p>Admin! Always logout for Park's security</p>
        <br><br>
        <form action="../include_files/logout.inc.php" method="post">
            <div class="input-field center">
                <button method="post" class="btn yellow darken-1 waves-effect waves-light black-text" 
                type="submit" name="logout">Logout</button>
            </div>
        </form>
    </div>
    <div id="database">
        <h2 class="yellow-text text-darken-1">Database</h2>
        <p>Admin press button only if you know what you are doing!</p>
        <br>
        <div class="red lighten-3 data_drop">
            <h2 class="red-text text-darken-4 center">DELETE DATABASE DATA</h2>
            <div class="input-field center">
                <a href="#warn"class="btn red darken-1 waves-effect waves-light black-text modal-trigger">delete</a>
            </div>
        </div>
    </div>
    <div id="map">
        <h2 class="yellow-text text-darken-1">Change Map Values</h2>
        <p>
            Press the button to go to a version of the map where you
            can edit individual polygon information.
        </p>
        <br><br>
        <div class="input-field center">
            <a href="../main/?login=true"class="btn yellow darken-1 waves-effect waves-light black-text">Change Map</a>
        </div>
    </div>
</section>
<div class="modal" id="warn">
    <div class="modal-content center">
        <h4 class="red-text text-darken-4">Warning</h4>
        <p class="left-align">
            By pressing delete, you will remove all of the available population
            data. Are you sure you want to do this?
        </p>
        <a href="#" class="modal-close btn yellow darken-1">Close</a>
        <form action="../include_files/delete.inc.php" method="post" id="delete-form">
            <div class="input-field">
                <button id="delete" method="post" class="btn red darken-1 waves-effect waves-light" 
                type="submit" name="delete">Delete</button>
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin="" ></script>
<script>
    //initialize Materialize css tabs
    //KANTO SWIPE EINAI TELEIO
    const tabss = document.querySelector('.tabs');
    M.Tabs.init(tabss,{swipeable:true});

    //Initialize Materialize css Modal for delete
    const warnModal = document.getElementById("warn");
    M.Modal.init(warnModal,{});
</script>
<script src="../js/ajax_file-upload.js"></script>
<script src="../js/ajax_delete.js"></script>
</html>