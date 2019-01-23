//Helper function for getting elements id
function _(el){
    return document.getElementById(el);
}

var deleteForm = _('delete-form');
var deleteButton = _('delete');

deleteForm.onsubmit = (event)=>
{
    //prevent default submit
    event.preventDefault();
    var params = "delete=";

    //close the warning modal
    var modal = M.Modal.getInstance(_('warn'));
    modal.close();

    //sending request to delete.inc.php

    //creating ajax object
    xhr = new XMLHttpRequest();
    xhr.open('POST','../include_files/delete.inc.php', true);

    //set request header
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

    //send
    xhr.send(params);

    //if all goes well func
    xhr.onload = ()=>
    {
        if(xhr.status == 200)
        {
            if(xhr.responseText == "DONE")
            {
                M.toast({html: 'Deleted!', classes: 'rounded'})
                submitButton.innerHTML = "Submit";
            }
        }
    }
}