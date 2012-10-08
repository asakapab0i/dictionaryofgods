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

function clicked(_rowx){
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

// approve a vote
$(function(){
    $('#do').click(function(){
        if(confirm('Are you sure you want to ADD this word?')){
            $('#dvloader').show(); 
            var tempwordid = $.getURLParam("pending");
            //alert(tempwordid);
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
                    $('#status').html('<p class="success word-style">Word is successfully Added <br/></p>');
                    $('#dvloader').hide(); 
                }else if(data == 'succesfully added2'){
                    $('#stat').remove();
                    $('#status').html('<p class="success word-style">Word is successfully Added <br/></p>');
                    $('#dvloader').hide(); 
                }else if(data == 'Word already added!'){
                    $('#stat').remove();
                    $('#status').html('<p class="error word-style">You can\'t perform this operation because the world is already been approved.</p>');
                    $('#dvloader').hide(); 
                }else{
                //alert(data);
                }
            }).error(function(data){
                alert('An error occured!'+ data);
                $('#dvloader').hide(); 
            });
        }
    });

});
//deny a word
$(function(){
    $('#dont').click(function(){
        if(confirm('Are you sure you want to DENY this word?')){
            $('#dvloader').show(); 
            var tempwordid = $.getURLParam("pending");
            //alert(tempwordid);
            $.ajax({
                type: 'POST',
                url: 'http://localhost/dict/admin/include/ajax/pendingCRUD.php',
                data: {
                    method: 'deny word',
                    tempwordid: tempwordid
                
                }
            }).done(function(data){
                if(data == 'word denied'){
                    $('#stat').remove();
                    $('#status').html('<p class="success word-style">Word has been rejected succesfully! <br/></p>');
                    $('#dvloader').hide(); 
                }else if(data == 'word already added'){
                    $('#stat').remove();
                    $('#status').html('<p class="error word-style">Word cannot be denied! Because it\'s already been approved. <br/></p>');
                    $('#dvloader').hide();
                }else if(data == 'word already denied'){
                    $('#stat').remove();
                    $('#status').html('<p class="error word-style">Word has already been denied!<br/></p>');
                    $('#dvloader').hide();
                }else{
                    $('#stat').remove();
                    $('#status').html('<p class="error word-style">Something went wrong! <br/></p>');
                    $('#dvloader').hide(); 
                }
            }).error(function(data){
                alert('An error occured!'+ data);
                $('#dvloader').hide(); 
            });
        }
    });

});

$(document).ready(function() 
{ 
    $("#myTable").tablesorter(); 
} 
); 
    
