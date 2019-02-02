//sidenav
const sideNav = document.querySelector('.sidenav');
M.Sidenav.init(sideNav,{});

//Initialize the sidenav with the information
var sideNav2 = document.getElementById('slide-out');
var instance = M.Sidenav.init(sideNav2,{});

//Initializing the FAB
var fab = document.getElementById('fab');
var fabInstance = M.FloatingActionButton.init(fab,{
    direction: 'top',
    hoverEnabled: true
});

//Initializing Parallax
var parallax = document.getElementById('first');
var parallaxinstance = M.Parallax.init(parallax, {} );

//Initialize the modal
var modal = document.getElementById('modal1');
var modalInstance = M.Modal.init(modal,{});

//Initialize the timepicker
var timepicker = document.querySelectorAll('.timepicker');
var timepickerInstance = M.Timepicker.init(timepicker,{container:'#main-body',
                                                       twelveHour: false});