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
    <div class="container">
        <div class="form-container">
            <form action="../include_files/sendEmail.inc.php"></form>
            <div class="input-field">
                <input id="name" name="name" type="text">
                <label for="name">Name</label>
            </div>
            <div class="input-field">
                <input id="email" name="email" type="email">
                <label for="email">Email</label>
            </div>
            <div class="input-field">
                <textarea id="message" class="materialize-textarea"></textarea>
                <label for="message">Your message</label>
            </div>
        </div>
    </div>
</body>