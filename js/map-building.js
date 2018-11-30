//Map container initialization
//Randomly allocate Longtitude and Latitude over 
//Plateia Georgiou Patras 
var mymap = L.map('map-container');
mymap.setView([38.2458205, 21.7351358], 16);

//Tile layer initilization getting tile layers and attribution
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="openmaps.com">OpenMaps</a>',
    maxZoom: 18
}).addTo(mymap);

//Removing the zoom buttons provided by leaflet.js
// when the screen size is small because it intefeers
//with the sidenav of materialize css
var body = document.getElementById("main-body");
body.onresize = function() {
    var w = window.outerWidth;
    if(w <= 1080){
        mymap.removeControl(mymap.zoomControl);
    }else{
        mymap.addControl(mymap.zoomControl);
    }
};