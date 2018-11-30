<?php 


session_start();



// Check for if the script was called by the submit button
// on the admin login page
if(isset($_POST['submit'])){

    //Connect to the database
    include 'dataBaseHandler.inc.php';

    //Get the firstname,lastname and password from
    //the Post method 
    $first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn,$_POST['last_name']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);


    //Error handlers
    //Check if inputs are empty that means they only pressed
    //the submit button

    if(empty('$first_name')||empty('$last_name')||empty('$pwd')){
        //Reroute to admin-login
        header("Location: ../admin/?login=empty");
        exit();
    }
    else{
        //Check if this person exists in database

        $sql = "SELECT * FROM admin WHERE admin_first='$first_name' AND admin_last='$last_name'";
        $result = mysqli_query($conn, $sql);

        //After the query is run in the database
        //get the number of affected rows
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck < 1){
            //Reroute to admin Login
            header("Location: ../admin/?login=numlt1");
            exit();
        }else{
            //if person exists get the row that matches
            //in $row array

            if($row = mysqli_fetch_assoc($result)){

                //check if passwords match up
                $password_check = ($pwd == $row['admin_pwd']);
                if($password_check == false){
                    //rerout to login
                    header("Location: ../admin/?login=wrpwd");
                    exit();
                            //---*IMPORTANT*---//
                //else if instead of else statement, fail-safe option just in case 
                //something happens and $password_check ends up 
                //as something else rather than true or false
                }else if($password_check == true){
                    //LOGIN-creating session
                    $_SESSION['a_id'] = $row['admin_id'];
                    $_SESSION['a_first_name'] = $row['admin_first'];
                    $_SESSION['a_last_name'] = $row['admin_last'];
                    header("Location: ../admin/admin.php?signin=success");
                    exit();
                }
            }
        }
    }
}
//Send them back to /main/ if they tried to access
//without having clicked the submit
else{
    header("Location: ../main/?login=malicious");
    exit();
}