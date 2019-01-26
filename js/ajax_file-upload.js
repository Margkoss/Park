//Helper function for getting elements id
function _(el){
    return document.getElementById(el);
}

//setting the element variables
var formKML = _('file-form');
var fileSelectKML = _('file_input');
var submitButtonKML = _('kml_submit');
var sendKML = '../include_files/kmlparser.inc.php';
var filePathKML = _('file-path-text')

var formCSV = _('file-form2');
var fileSelectCSV = _('file_input2');
var submitButtonCSV = _('csv_submit');
var sendCSV = '../include_files/csvparser.inc.php';
var filePathCSV = _('file-path-text2')


//Beggining of ajax upload to server onSubmit event
formKML.onsubmit = (event)=>
{
    handleTheUpload(event,fileSelectKML,submitButtonKML,sendKML,filePathKML);
}

formCSV.onsubmit = (event)=>
{
    handleTheUpload(event,fileSelectCSV,submitButtonCSV,sendCSV,filePathCSV);
}


function handleTheUpload(event,fileSelect,submitButton,sendfile,filepath){
    //Prevent default behaviour of submiting form to php file 
    //so we can handle it asynchronously
    event.preventDefault();

    //visual feedback for user
    submitButton.innerHTML = 'Uploading...';

    //Getting the selected file from the input
    var file = fileSelect.files[0];

    //check if there was a file in the input
    if(file !== undefined){
        //Create formdata obj and add the file to 
        //the http request
        
        var formData = new FormData();
        formData.append('file', file, file.name);

        //setup the request
        var xhr = new XMLHttpRequest();
        xhr.open('POST',sendfile,true);

        //Finally send the request
        xhr.send(formData);


        //Handler for when the request finishes
        xhr.onload = ()=>{
            if(xhr.status == 200){
                console.log(xhr.responseText);
                if(xhr.responseText == "Done"){
                    M.toast({html: 'Success!', classes: 'rounded'})
                    submitButton.innerHTML = "Submit";
                    filepath.value = "";
                }
                
            }
            else{
                M.toast({html:'An error occured :(',classes:'rounded'});
                submitButton.innerHTML = "Submit";
            }
        }
    }
    else
    {
        M.toast({html:'You need to insert a file first!',classes:'rounded'});
        submitButton.innerHTML = "Submit";
    }
}