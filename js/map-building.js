//Map container initialization
//Randomly allocate Longtitude and Latitude over 
//Plateia Georgiou Patras

var mymap = L.map('map-container');
mymap.setView([38.2458205, 21.7351358], 16);

//Tile layer initilization getting tile layers and attribution
//With darker tiles if the time is over 9
var d = new Date();
var time = d.getHours();
if(time >= 6 && time <= 21){
    L.tileLayer('https://maps.tilehosting.com/styles/streets/{z}/{x}/{y}.png?key=m4urAGMH66BnlUvKGOG9', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="openmaps.com">OpenMaps</a>',
        maxZoom: 20
    }).addTo(mymap);
}else{
    L.tileLayer('https://maps.tilehosting.com/styles/darkmatter/{z}/{x}/{y}.png?key=m4urAGMH66BnlUvKGOG9', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="openmaps.com">OpenMaps</a>',
        maxZoom: 20
    }).addTo(mymap);
}
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


//Creating the custom Park Logo marker

var parkIcon = L.icon({
    iconUrl: '../Pictures/Park-Marker.svg',
    iconSize:     [34,66], // size of the icon
    iconAnchor:   [16, 66], // point of the icon which will correspond to marker's location
    popupAnchor:  [-3, -66] // point from which the popup should open relative to the iconAnchor
});

//Marker Layer
var marker;

//Adding the marker with the onclick event
//callback function
mymap.on("click", function(e){
    if(marker){
        mymap.removeLayer(marker);
    }
    marker = new L.marker(e.latlng, {icon: parkIcon}).bindPopup("Your coordinates are:"+e.latlng).addTo(mymap);
});
