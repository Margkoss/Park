//sidenav
const sideNav = document.querySelector('.sidenav');
M.Sidenav.init(sideNav,{});

//Initialize the sidenav with the information
var sideNav2 = document.getElementById('slide-out');
var instance = M.Sidenav.init(sideNav2,{});

//Initializing the FAB
var fab = document.getElementById('fab');
var fabInstance = M.FloatingActionButton.init(fab,{
    direction: 'left',
    hoverEnabled: true
});
