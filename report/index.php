<?php

    require('../main/header.php');

?>
<link rel="stylesheet" href="../css/report.css">
<body>
    <div class="center">
        <h3 class="yellow-text" >Problem with Park?</h3>
        <h6>Tell us!</h6>
    </div>
    <br><br>
    <div class="row">
        <div class="container">
            <div class="form-container">
                <form action="../include_files/send_Email.inc.php">
                    <div class="input-field col s10 offset-s1">
                        <input id="fullName" name="fullName" type="text">
                        <label for="fullName">Name</label>
                    </div>
                    <div class="input-field col s10 offset-s1">
                        <input id="email" name="email" type="email">
                        <label for="email">Email</label>
                    </div>
                    <div class="input-field col s10 offset-s1">
                        <textarea id="message" class="materialize-textarea"></textarea>
                        <label for="message">Your message</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="input-field center-align">
        <button id="email-submit" class="btn waves-effect waves-light yellow darken-1" type="submit" name="action">
        Send<i class="material-icons right">send</i>
        </button>
    </div>
    <script src="../js/ajax-email.js"></script>
</body>