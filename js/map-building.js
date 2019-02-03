//define variable that will be the layer that contains the polygons
var geojson;
//define variable that is a layer that contains the circle for witch
//the user is willing to walk
var walkRadCircle;

//Add a function to the Circle class for checking if a point is contained in the
//circle
L.Circle.include({
    contains: function (coords) {
        return this.getLatLng().distanceTo(coords) <= this.getRadius();
    }
});

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
    modalInstance.close();
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

//Initialize the slider for the input
var stepSlider = document.getElementById('test-slider');
noUiSlider.create(stepSlider, {
    start: [0],
    range: {
        'min': [0],
        'max': [1500]
    },
    connect:[true,false],
    step:100,
    tooltips:[true]
});



//Function for showing data on map
function showData(e){
    //Set the feature 
    var featureProperties = e.target.feature.properties;

    //Set all of the information in the sideNav
    var time = document.getElementById('time');
    var gid = document.getElementById('gid');
    var population = document.getElementById('population');
    var taken = document.getElementById('taken');
    var parkingSpots = document.getElementById('parking-spots')
    var takenPercent = Math.round(e.target.feature.properties.taken*10000)/100;
    time.innerHTML = 'Hour: '+e.target.feature.properties.time;
    gid.innerHTML ='GID: ' + e.target.feature.properties.gid;
    population.innerHTML ='Population: ' + e.target.feature.properties.population;
    taken.innerHTML ='Taken: ' + takenPercent + "%";
    parkingSpots.innerHTML = 'From Total: ' + e.target.feature.properties.parkingSpots;

    //event listener for the park button
    var parkButton = document.getElementById('park');
    parkButton.onclick = (event)=>{
        event.preventDefault();
        
        var simTime = document.getElementById('simTime').value;
        var walkDist = stepSlider.noUiSlider.get();
        var featureCentroid = featureProperties.centroid;

        //Draw polygons at the sim time
        if(simTime != ""){
            let simTimeValue = '../include_files/get_polygons.inc.php?time='+simTime;
            if(geojson){
                mymap.removeLayer(geojson);
            }
            getPolygons(simTimeValue);
        }

        //Create a circle around the centroid of the polygon that was clicked
        if(walkRadCircle){
            mymap.removeLayer(walkRadCircle);
        }
        walkRadCircle = L.circle(featureCentroid,{
            fillColor:'blue',
            stroke:false,
            radius:walkDist
        }).addTo(mymap);

        //Loop through all the polygons to find the centroids in the walking distance
        //and put them in an array off coordinates
        var includedArray = [];
        for(x in geojson._layers){
            if(walkRadCircle.contains(geojson._layers[x].feature.properties.centroid)){
                includedArray.push(geojson._layers[x].feature.properties.centroid);
            }
        }
        includedArray = JSON.stringify(includedArray);
        
        var formdata = new FormData();
        formdata.append('includedArray',includedArray);

        var xhr = new XMLHttpRequest();
        xhr.open('POST','../include_files/performCluster.inc.php',true)

        xhr.send(formdata);

        xhr.onload = ()=>{
            if(xhr.status == 200){
                console.log(xhr.responseText);
            }
        }
        instance.close();
    }
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

//Marker Layer
var marker;

// Adding the marker with the onclick event
// callback function
function addAMarker(coords){
    marker = new L.marker(coords, {icon: parkIcon}).bindPopup('included').addTo(mymap);
}
