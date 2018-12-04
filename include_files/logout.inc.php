<?php
    //Logout admin code and destroy the session 
    //Reroute to main

    session_start();
    session_unset();
    session_destroy();
    header("Location: ../main/");