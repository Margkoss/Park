//Get all the form elemetns
sub = document.getElementById('email-submit');
fullName = document.getElementById('fullName');
email = document.getElementById('email');
message = document.getElementById('message');


//Event listener for submit button
sub.onclick = (event)=>{
    event.preventDefault();

    //Check for empty field
    if(fullName.value == "" || email.value==""){
        M.toast({html:"Can't send anonymus email",classes:"rounded"});
        return ;
    }
    if(message.value == ""){
        M.toast({html:"Can't send empty email",classes:"rounded"});
        return;
    }

    var xhr = new XMLHttpRequest();
    var formData = new FormData();

    //Append the paramaters to the ajax request
    formData.append("name",fullName.value);
    formData.append("email",email.value);
    formData.append("message",message.value);
    formData.append("submit","true");

    xhr.open("POST","../include_files/send_Email.inc.php",true);
    xhr.send(formData);

    xhr.onload = ()=>{

        if(xhr.status == 200){
            if(xhr.responseText == "FATAL"){
                M.toast({html:"You need to enter information first",classes:"rounded"});
                return ;
            }
            M.toast({html:"Message set! Thanks for the feedback",classes:"rounded"});
            fullName.value = "";
            email.value = "";
            message.value = ""
        }

    }

}