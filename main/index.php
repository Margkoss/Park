<?php
//required files for navigation bar and 
//styling
require('header.php');
require('main-links.html');

?>


    

<body id="main-body">
    <div id="map-container"></div>

    <ul id="slide-out" class="sidenav">
    <li>
    <div class="user-view">
      <div class="background yellow">
      </div>
      <a href="#user"><img class="responsive-img" src="../Pictures/ParkLogo.svg"></a>
    </div>
    <li><a class="subheader">Info-Preview</a></li>
    <li><a id="esye" href="#">Esye</a></li>
    <li><a id="gid" href="#">Gid</a></li>
    <li><a id="population" href="#">Population</a></li>
  </ul>


    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin="" ></script>
    <script src="../js/map-building.js" ></script>
</body>
</html>