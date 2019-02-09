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
    mymap.flyToBounds(e.target.getBounds());
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
    subheader = document.getElementById('subheader');
    subheader.innerHTML = 'Change Population/Distribution';
    difference.innerHTML = 
    `
    <form action="../include_files/admin_edit.inc.php" method="POST">
        <div class="row">
            <div class="input-field col s8 offset-s1">
                <input id="ch_pop" type="text">
                <label for="ch_pop">Population</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s8 offset-s1">
                <select id="mySelector">
                    <option value="" disabled selected>Choose your option</option>
                    <option value="1">Distribution 1</option>
                    <option value="2">Distribution 2</option>
                    <option value="3">Distribution 3</option>
                </select>
                <label>Distribution Select</label>
                <button id="submit" class="btn yellow darken-1 waves-effect waves-light" type="submit" name="submit">Submit
                    <i class="material-icons right">send</i>
                </button> 
            </div>   
        </div>
    </form>
    `;

    //Initialize the select 
    var select = document.querySelectorAll('select');
    var selectorInstances = M.FormSelect.init(select,{});

    //Event listener for the submit button
    var submit = document.getElementById('submit');
    submit.onclick = (event)=>{
        event.preventDefault();

        var selectorValue = document.getElementById('mySelector').value;
        var inputValue = document.getElementById('ch_pop').value;

        
        //Check if both inputs are empty
        if(selectorValue == "" && inputValue == ""){
            M.toast({html:'Nothing to change',classes:'rounded', displayLength:4000});
            return;
        }

        //Turn values to numbers
        if(selectorValue != ""){
            selectorValue = Number(selectorValue);
        }
        if(inputValue != ""){
            inputValue = Number(inputValue);

            //If the input is not empty, but the value is not a non-negative integer return
            if(isNaN(inputValue) || !Number.isInteger(inputValue) || inputValue < 0){
                document.getElementById('ch_pop').value = ""
                M.toast({html:'Population needs to be a non-negative integer',classes:'rounded', displayLength:4000});
                return;
            }
        }

        //We reach this point if everything is ok with the inputs
        var xhr = new XMLHttpRequest();
        var params = 'submit=submit'+'&population='+inputValue+'&distribution_curve='+selectorValue+'&gid='+e.target.feature.properties.gid;

        xhr.open('POST','../include_files/admin_edit.inc.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        xhr.send(params)

        xhr.onload = ()=>{
            console.log(xhr.responseText);
            if(xhr.responseText == "Database updated successfully"){
                instance.close();
                mymap.flyTo(e.target.feature.properties.centroid,14);
                if(geojson){
                    mymap.removeLayer(geojson);
                }
                getPolygons('../include_files/get_polygons.inc.php',false);
                M.toast({html:'Databse updated succesfully',classes:'rounded', displayLength:4000});
            }
        }

    }
    instance.open();
}