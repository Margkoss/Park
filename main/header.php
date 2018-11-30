<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Park.</title>
    <link rel="shortcut icon" href="../Pictures/trafficIcon.ico">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../css/header.css" rel="stylesheet"></link>
    <div class="navbar-fixed">
        <nav class="yellow darken-1">
            <div class="container">
                <div class="nav-wrapper">
                    <a href="../main" class="brand-logo"><img src="../Pictures/ParkLogo.svg"></a>
                    <a href="#" data-target="mobile-nav" 
                    class="sidenav-trigger">
                        <i class="material-icons">menu</i>
                    </a>
                    <ul class="right hide-on-med-and-down">
                        <li>
                            <a href="#about">About</a>
                        </li>
                        <li>
                            <a href="#report">Report Bugs</a>
                        </li>
                        <li>
                            <a href="../admin/">Admin-Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <ul class="sidenav" id="mobile-nav">
        <li>
            <div class="user-view">
                <div class="background yellow">
                </div>
                <a href="#about"><img src="../Pictures/ParkLogo.svg"></a>
            </div>
        </li>
        <li>
            <a href="#about"><i class="material-icons">library_books</i> About</a>
        </li>
        <li>
            <a href="#report"><i class="material-icons">bug_report</i>Report Bugs</a>
        </li>
        <li>
            <a href="../admin/"><i class="material-icons">person_outline</i> Admin-Login</a>
        </li>
    </ul>



    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- Script for mobile framework initilization -->
    <script src="../js/materialize-init.js"></script>
</head>