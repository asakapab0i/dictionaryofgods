$(function(){
    
    //Activate the menu
    $('#mainMenu a').addClass('buttonMenu');
    $('#subMenu a').addClass('buttonSmall');
    
    $('#mainMenu a').each(function(){
        $(this).removeClass('active');
    });
    
    $('#dictionary').addClass('active'); //End of menu activate
    
    
    
});

//$('a[hreflang|="en"]').css('border','3px dotted green');