<?php

session_start();
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
    <div class="divider"></div>
    <li><a href="#" id="time"></a></li>
    <li><a id="gid" href="#"></a></li>
    <li><a id="population" href="#"></a></li>
    <li><a id="taken" href="#"></a></li>
    <li><a id="available" href="#"></a></li>
    <li><a id="parking-spots" href="#"></a></li>
    <div class="divider"></div>
    <li><a class="subheader" id="subheader">Tweak the parameters</a></li>
    <div class="divider"></div>
    <div id="difference">
    <div class="row">
      <div class="col s8 offset-s1">
        <form action="../include_files/performCluster.inc.php" method="post">
          <small>Choose Time</small>
          <input type="text" class="timepicker" id="simTime" placeholder="Time">
          <br>
          <small>Choose walk distance</small>
          <br><br>
          <div id="test-slider"></div>
          <br>
          <button id="park" class="yellow darken-1 btn waves-effect waves-light" type="submit" name="park">Park around here</button>
        </form>
      </div>
    </div>
    </div>
</ul>
<div class="fixed-action-btn" id="fab">
  <a class="btn-floating btn-large yellow darken-1">
    <i class="large material-icons">settings</i>
  </a>
  <ul>
    <li><a id="change-time" data-target="modal1" class="modal-trigger btn-floating yellow darken-1"><i class="material-icons">timer</i></a></li>
    <li><a id="zoom-out" class="btn-floating yellow darken-1"><i class="material-icons">zoom_out</i></a></li>
    <li><a id="zoom-in"class="btn-floating yellow darken-1"><i class="material-icons">zoom_in</i></a></li>
  </ul>
</div>
<div id="modal1" class="grey lighten-3 modal bottom-sheet">
  <div class="modal-content">
    <div class="title">
      <h4 class="yellow-text text-darken-1">Choose time to view parking space availability</h4>
      <form action="get_polygons.inc.php" method="GET">
        <input type="text" id='timepicker' class="timepicker" placeholder="Time">
        <br>
        <button id="check" class="yellow darken-1 btn waves-effect waves-light" type="submit" name="checkTime">Check Then
          <i class="material-icons right">timer</i>
        </button>
      </form>
    </div>
  </div>
</div>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin="" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/12.1.0/nouislider.js"></script>

<?php
  if(isset($_SESSION['a_id']) && isset($_GET['login'])){
    echo "<script src='../js/admin-map.js'></script>";
  }
  else if(!isset($_SESSION['a_id']) && isset($_GET['login']))
  {
    echo '<script src="../js/map-building.js" ></script>';
    echo "<script>M.toast({html:'I know what you did',classes:'rounded'});</script>";
  }else{
    echo '<script src="../js/map-building.js" ></script>';
  }
?>
</body>
</html>