<?php
    require('../main/header.php')
?>

<link rel="stylesheet" href="../css/admin-login.css">
<body>
    <div class="container">
        <div class="form-container">
            <form action="../include_files/login.inc.php" method="POST">
            <div class="input-field">
                <input id="first_name" name="first_name" type="text" class="validate">
                <label for="first_name">First Name</label>
            </div>
            <div class="input-field">
                <input id="last_name" name="last_name" type="text" class="validate">
                <label for="first_name">Last Name</label>
            </div>
            <div class="input-field">
                <input id="pwd" type="password" name="pwd" class="validate">
                <label for="pwd">Password</label>
            </div class="input-field">
            <br><br>
            <div class="center-align">
                <button class="btn-large waves-effect waves-light yellow darken-1" type="submit" name="submit">Submit</button>
            </div>
            </form>
        </div>
        <br><br>
        <div class="center-align hide-on-med-and-down">
            <a href="#">Forgot Password?</a>
        </div>
    </div>
</body>
</html>