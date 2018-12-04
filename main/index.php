<?php
//required files for navigation bar and 
//styling
require('header.php');
require('main-links.html');

//Display an alert if a user tried to acess
//a forbidden file
if($_GET['login'] == "malicious"){
    echo '<script type="text/javascript">',
     'alert("i know what you did");',
     '</script>'
;
}
?>


    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin="" defer></script>
    <script src="../js/map-building.js" defer></script>
<body id="main-body">
    <div id="map-container"></div>
</body>
</html>