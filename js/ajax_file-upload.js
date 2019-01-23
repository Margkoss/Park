//Helper function for getting elements id
function _(el){
    return document.getElementById(el);
}

//setting the element variables
var form = _('file-form');
var fileSelect = _('file_input');
var submitButton = _('kml_submit');

//Beggining of ajax upload to server onSubmit event

form.onsubmit = (event)=>{
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
        xhr.open('POST', '../include_files/kmlparser.inc.php',true);

        //Finally send the request
        xhr.send(formData);


        //Handler for when the request finishes
        xhr.onload = ()=>{
            if(xhr.status == 200){
                if(xhr.responseText == "OK"){
                    M.toast({html: 'Success!', classes: 'rounded'})
                    submitButton.innerHTML = "Submit";
                }
                
            }
            else{
                alert("An error occured");
                submitButton.innerHTML = "Submit";
            }
        }
    }else{
        alert("WTF ENTER FILE");
        submitButton.innerHTML = "Submit";
    }
}