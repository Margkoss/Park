//Map container initialization
//Randomly allocate Longtitude and Latitude over 
//Plateia Georgiou Patras
var sideNav2 = document.getElementById('slide-out');
var instance = M.Sidenav.init(sideNav2,{})


var mymap = L.map('map-container');
mymap.setView([40.639669, 22.934546], 13);

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
    let navbar = document.getElementById('navbar');
    navbar.className = "grey";
}


//Getting the polygons from the database
//and draw them
var xhr = new XMLHttpRequest();
xhr.open('GET','../include_files/get_polygons.inc.php',true);
xhr.send();

xhr.onload = ()=>{
    var polygons = JSON.parse(xhr.responseText);
    geojson = L.geoJSON(polygons,{style: style,onEachFeature: onEachFeature}).addTo(mymap);
    // console.log(polygons);
}



//Function for changing the color according to population
function getColor(p)
{
    return p > 100 ? '#ff0000':
           p > 50 ? '#ffb400':
           p > 30 ? '#ffce00':
                    '#00ff04'
}

//function for assigning style to each polygon
function style(feature)
{
    return {
        fillColor : 'gray',
        stroke : false,
        fillOpacity: 0.5
    };
}

//Function for when the polygons are hovered
function highlightFeature(e)
{
    var layer = e.target;

    layer.setStyle({
        fillColor:getColor(layer.feature.properties.population),
        stroke:true,
        color: 'gray',
        fillOpacity: 0.9
    });

    if(!L.Browser.ie && !L.Browser.opera && !L.Browser.edge)
    {
        layer.bringToFront();
    }
}

//Function for reseting style to each feature
function resetHighlight(e) {
    geojson.resetStyle(e.target);
}

//Function for showing data on map
function showData(e){
    var gid = document.getElementById('gid');
    var population = document.getElementById('population');
    var esye = document.getElementById('esye');
    gid.innerHTML ='GID: ' + e.target.feature.properties.gid;
    population.innerHTML ='Population: ' + e.target.feature.properties.population;
    esye.innerHTML ='Esye: ' + e.target.feature.properties.esye;
    instance.open();
}


//Function for adding listeners to layer
function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: showData
    });
}


//Removing the zoom buttons provided by leaflet.js
mymap.removeControl(mymap.zoomControl);

//Creating the custom Park Logo marker

var parkIcon = L.icon({
    iconUrl: '../Pictures/Park-Marker.svg',
    iconSize:     [34,66], // size of the icon
    iconAnchor:   [16, 66], // point of the icon which will correspond to marker's location
    popupAnchor:  [-3, -66] // point from which the popup should open relative to the iconAnchor
});

// Marker Layer
// var marker;

// // Adding the marker with the onclick event
// // callback function
// mymap.on("click", function(e){
//     if(marker){
//         mymap.removeLayer(marker);
//     }
//     marker = new L.marker(e.latlng, {icon: parkIcon}).bindPopup("Your coordinates are:"+e.latlng).addTo(mymap);
// });
