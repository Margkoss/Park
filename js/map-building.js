//define variable that will be the layer that contains the polygons
var geojson;
//Map container initialization
var mymap = L.map('map-container');
mymap.setView([40.639669, 22.934546], 13);


//Tile layer initilization getting tile layers and attribution

L.tileLayer('https://maps.tilehosting.com/styles/streets/{z}/{x}/{y}.png?key=m4urAGMH66BnlUvKGOG9', {
    maxZoom: 20
}).addTo(mymap);

//Remove the default zoom buttons provided from leaflet js
mymap.removeControl(mymap.zoomControl);

//Custom zoom with the floating action button
zoomIn = document.getElementById('zoom-in');
zoomOut = document.getElementById('zoom-out');
zoomIn.onclick = ()=>{
    mymap.setZoom(mymap.getZoom() + 1);
}
zoomOut.onclick = ()=>{
    mymap.setZoom(mymap.getZoom() - 1);
}

//After map is set-up get the polyons from database
getPolygons('../include_files/get_polygons.inc.php');

//Add event listener to change time button
changeTime = document.getElementById('check');
changeTime.onclick = (event)=>{

    event.preventDefault();
    var timeValue = '../include_files/get_polygons.inc.php?time=' + document.getElementById('timepicker').value;
    if(geojson){
       mymap.removeLayer(geojson);
    }
    getPolygons(timeValue);

}

//function for getting the polygons from the database
//and draw them
function getPolygons(timeURL){
    var xhr = new XMLHttpRequest();
    xhr.open('GET',timeURL,true);
    xhr.send();

    xhr.onload = ()=>{
        var polygons = JSON.parse(xhr.responseText);
        geojson = L.geoJSON(polygons,{style: style,onEachFeature: onEachFeature});
        geojson.addTo(mymap);
    }
}


//Function for changing the color according to taken percentage
function getColor(t)
{
    return t <= 0.59 ? '#008000':
           t <= 0.84 ? '#fec832':
                       '#990000';
}

//function for assigning style to each polygon
function style(feature)
{
    return {
        fillColor : getColor(feature.properties.taken),
        stroke : false,
        fillOpacity: 0.5
    };
}

//Function for when the polygons are hovered
function highlightFeature(e)
{
    let layer = e.target;

    layer.setStyle({
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
    var taken = document.getElementById('taken');
    var parkingSpots = document.getElementById('parking-spots')
    gid.innerHTML ='GID: ' + e.target.feature.properties.gid;
    population.innerHTML ='Population: ' + e.target.feature.properties.population;
    var takenPercent = Math.round(e.target.feature.properties.taken*10000)/100;
    taken.innerHTML ='Taken: ' + takenPercent + "%";
    parkingSpots.innerHTML = 'From Total: ' + e.target.feature.properties.parkingSpots;
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
