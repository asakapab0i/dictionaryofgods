$(function(){
    
    //Activate the menu
    $('#mainMenu a').addClass('buttonMenu');
    $('#subMenu a').addClass('buttonSmall');
    
    $('#mainMenu a').each(function(){
        $(this).removeClass('active');
    });
    
    $('#report').addClass('active'); //End of menu activate
    
    
    
    
    
});


function over(_row){
    document.getElementById("row"+_row).style.backgroundColor="#ACF";
}

//hover out color
function out(_row){
    document.getElementById("row"+_row).style.backgroundColor="white";
//for product redirection
}
function clicked(_rowx,_rowy){
    var x = _rowx;
    var y = _rowy;
    //document.location.href=("../employee/product.php?pid="+ x);
    document.location.href=("http://localhost/dict/admin/reports.php?wid="+ x+"&rid="+y);

}

//$('a[hreflang|="en"]').css('border','3px dotted green');