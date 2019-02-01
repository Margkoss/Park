//Helper function for getting elements id
function _(el)
{
    return document.getElementById(el);
}

//Pop the admin instruction toast
M.toast({html: 'Click any polygon to edit its data',classes:'rounded', displayLength:4000});

//Changing what happens when admin clicks
//by overriding the showData function
// function showData(e)
// {
    
// }

function style(feature)
{
    return {
        fillColor : 'gray',
        stroke : false,
        fillOpacity: 0.5
    };
}