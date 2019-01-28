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
    <div class="background yellow darken-1">
  </div>
  <a href="#user"><img class="responsive-img" src="../Pictures/ParkLogo.svg"></a>
  </div>
    <li><a class="subheader">Info-Preview</a></li>
    <li><a id="esye" href="#"></a></li>  
    <li><a id="gid" href="#"></a></li>
    <li><a id="population" href="#"></a></li>
    <li><a class="subheader" id="subheader">Simulation</a></li>
    <div id="difference"></div>
</ul>
<div class="fixed-action-btn" id="fab">
  <a class="btn-floating btn-large yellow darken-1">
    <i class="large material-icons">pageview</i>
  </a>
  <ul>
    <li><a id="zoom-out" class="btn-floating yellow darken-1"><i class="material-icons">zoom_out</i></a></li>
    <li><a id="zoom-in"class="btn-floating yellow darken-1"><i class="material-icons">zoom_in</i></a></li>
  </ul>
</div>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin="" ></script>
<script src="../js/map-building.js" ></script>


<?php
  session_start();

  if(isset($_SESSION['a_id']) && $_GET['login'] == 'true'){
    echo "<script src='../js/admin-map.js'></script>";
  }
  else if(!isset($_SESSION['a_id']) && $_GET['login'] == 'malicious')
  {
    echo "<script>M.toast({html:'I know what you did',classes:'rounded'});</script>";
  }
?>
</body>
</html>