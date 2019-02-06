//Pop the admin instruction toast
M.toast({html: 'Click any polygon to edit its data',classes:'rounded', displayLength:4000});


/*********************************************************************************************/


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
getPolygons('../include_files/get_polygons.inc.php',false);

//Add event listener to change time button
changeTime = document.getElementById('check');
changeTime.onclick = (event)=>{

    event.preventDefault();
    var timeValue = '../include_files/get_polygons.inc.php?time=' + document.getElementById('timepicker').value;
    if(geojson){
       mymap.removeLayer(geojson);
    }
    getPolygons(timeValue,true);
    modalInstance.close();
}

//function for getting the polygons from the database
//and draw them
function getPolygons(timeURL,runningSim){
    var xhr = new XMLHttpRequest();
    xhr.open('GET',timeURL,true);
    xhr.send();

    xhr.onload = ()=>{
        var polygons = JSON.parse(xhr.responseText);
        if(runningSim){
            geojson = L.geoJSON(polygons,{style: style,onEachFeature: onEachFeature});
        }else{
            geojson = L.geoJSON(polygons,{style: {
                fillColor : 'grey',
                stroke : false,
                fillOpacity: 0.5
            },onEachFeature: onEachFeature});
        }
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

function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: showData
    });
}


function showData(e){
    //zoom in to the requested block
    mymap.fitBounds(e.target.getBounds());
    //Set all of the information in the sideNav
    var time = document.getElementById('time');
    var gid = document.getElementById('gid');
    var population = document.getElementById('population');
    var taken = document.getElementById('taken');
    var available = document.getElementById('available');
    var parkingSpots = document.getElementById('parking-spots')
    var takenPercent = Math.round(e.target.feature.properties.taken*10000)/100;
    available.innerHTML = 'Available: '+e.target.feature.properties.availableSpots;
    time.innerHTML = 'Hour: '+e.target.feature.properties.time;
    gid.innerHTML ='GID: ' + e.target.feature.properties.gid;
    population.innerHTML ='Population: ' + e.target.feature.properties.population;
    taken.innerHTML ='Taken: ' + takenPercent + "%";
    parkingSpots.innerHTML = 'From Total: ' + e.target.feature.properties.parkingSpots;

    difference = document.getElementById('difference');
    difference.innerHTML = 
    `
    <form action="../include_files/admin_edit.inc.php" method="post">
        
    </form>
    `;
    instance.open();
}