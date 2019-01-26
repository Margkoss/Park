//Helper function for getting elements id
function _(el)
{
    return document.getElementById(el);
}

//Pop the admin instruction toast
M.toast({html: 'Click any polygon to edit its data',classes:'rounded', displayLength:4000});


//Initializing the FAB
var fab = _('fab');
var fabInstance = M.FloatingActionButton.init(fab,{
    direction: 'left',
    hoverEnabled: false
});


//Changing what happens when admin clicks
//by overriding the showData function
function showData(e)
{
    alert(e.latlng);
}