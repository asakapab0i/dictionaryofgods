jQuery.extend({
    /**
     * Returns get parameters.
     *
     * If the desired param does not exist, null will be returned
     *
     * @example value = $.getURLParam("paramName");
     */ 
    getURLParam: function(strParamName){
        var strReturn = "";
        var strHref = window.location.href;
        var bFound=false;
	  
        var cmpstring = strParamName + "=";
        var cmplen = cmpstring.length;

        if ( strHref.indexOf("?") > -1 ){
            var strQueryString = strHref.substr(strHref.indexOf("?")+1);
            var aQueryString = strQueryString.split("&");
            for ( var iParam = 0; iParam < aQueryString.length; iParam++ ){
                if (aQueryString[iParam].substr(0,cmplen)==cmpstring){
                    var aParam = aQueryString[iParam].split("=");
                    strReturn = aParam[1];
                    bFound=true;
                    break;
                }
	      
            }
        }
        if (bFound==false) return null;
        return strReturn;
    }
});


$(function(){
    //Activate the menu
    $('#mainMenu a').addClass('buttonMenu');
    $('#subMenu a').addClass('buttonSmall');
    
    $('#mainMenu a').each(function(){
        $(this).removeClass('active');
    });
    
    $('#pending').addClass('active'); //End of menu activate
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
    //document.location.href=("../employee/product.php?pid="+ x);
    document.location.href=("http://localhost/dict/admin/pending.php?pending="+x);

}

$(function(){
    
    $('#back').click(function(e){
        e.preventDefault();
        window.history.back();
    })
});


$(function(){
    $('#do').click(function(){
        var tempwordid = $.getURLParam("pending");
        alert(tempwordid);
        $.ajax({
            type: 'POST',
            url: 'http://localhost/dict/admin/include/ajax/pendingCRUD.php',
            data: {
                method: 'add word',
                tempwordid: tempwordid
                
            }
        }).done(function(data){
            if(data == 'succesfully added1'){
                $('#stat').remove();
                $('#status').html('<p class="success">Word is successfully Added <br/></p>');
            }else if(data == 'succesfully added2'){
                $('#stat').remove();
                $('#status').html('<p class="success">Word is successfully Added <br/></p>');
            }else if(data == 'Word already added!'){
                $('#stat').remove();
                $('#status').html('<p class="success">Word is already Added.</p>');
            }else{
                //alert(data);
            }
        }).error(function(data){
            alert('An error occured!'+ data);
        });
    })
});