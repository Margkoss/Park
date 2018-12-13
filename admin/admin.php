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
                <a  href="#logout">Logout</a>
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
                    <input class="file-path" type="text">
                </div>
                </div>
                <div class="input-field">
                    <button id="kml_submit" name="kml-submit" type="submit" class="btn yellow darken-1 waves-effect waves-light black-text">Submit</button>
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
</section>


<script>
    //initialize Materialize css tabs

    //KANTO SWIPE EINAI TELEIO
    const tabss = document.querySelector('.tabs');
    M.Tabs.init(tabss,{swipeable:true});
</script>
<script src="../js/ajax_file-upload.js"></script>
</html>