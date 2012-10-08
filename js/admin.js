$(function(){
    
    //start get param
    /* Copyright (c) 2006 Mathias Bank (http://www.mathias-bank.de)
     * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) 
     * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
     * 
     * Thanks to Hinnerk Ruemenapf - http://hinnerk.ruemenapf.de/ for bug reporting and fixing.
     */
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
    //end get param
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

//Admin Actions
$(function(){
 
    $('.buttonAction').click(function(){
        
        var reportid = $.getURLParam("rid");
        var wordmapid = $.getURLParam("wid");
        var id = $(this).attr('id');
        // alert(id);
           
        if(id=='delete'){
            deleteWord(wordmapid, reportid);
        }else if(id == 'edit'){
            editWord(wordmapid);
        }else if(id=='close'){
            closeReport(wordmapid, reportid);
        }else if(id=='open'){
            openReport(wordmapid, reportid);
        }else if(id == 'onhold'){
            onholdReport(reportid);
        }
        
        
    });

});

function deleteWord(wordmapid, reportid){
    //delete the word ajax calling
    if(confirm('Are you sure you want to delete this word?')){
        //this.preventDefault();
        //alert(wordmapid);
        //alert(reportid);
        $('#dvloader').show(); 
        var method = 'delete';
        $.ajax({
            type : 'POST',
            url : 'http://localhost/dict/admin/include/ajax/reportCRUD.php',
            data : {
                wordmapid:wordmapid,
                method: method,
                reportid:reportid
            }
        }).done(function(data){
            // alert(data);
            if(data == 'successfully deleted'){
                //alert(data);
                $('#status').remove();
                $('#statbox').html('<p class="success word-style">Word has been deleted!</p>');
                $('#dvloader').hide(); 
            }else if(data == 'ticket closed'){
                // alert(data);
                $('#status').remove();
                $('#statbox').html('<p class="error word-style">You cannot perform this operation because the ticket is closed.</p>');
                $('#dvloader').hide();
            }else if(data == 'error'){
                alert('Blank word_status in database!');   
            }else if (data == 'alreade deleted'){
                $('#status').remove();
                $('#statbox').html('<p class="error word-style">Word has already been deleted!</p>');
                $('#dvloader').hide(); 
            }
    
        }).error(function(){
            $('#status').remove();
            $('#statbox').html('<p class="error word-style">An error occured!</p>');
            $('#dvloader').hide();
        });
    }    
    
   
}
function editWord(){
    alert('hello world');
}
function closeReport(wordmapid,reportid){
    $('#dvloader').show(); 
    var method = 'close'
    
    $.ajax({
        type: 'POST',
        url: 'http://localhost/dict/admin/include/ajax/reportCRUD.php',
        data: {
            method:method,
            reportid:reportid,
            wordmapid:wordmapid
        }
    }).done(function(data){
        if(data == 'report closed'){
            $('#status').remove();
            $('#statbox').html('<p class="success word-style">This ticket is now closed.</p>');
            $('#dvloader').hide(); 
        }else if (data == 'already closed'){
            $('#status').remove();
            $('#statbox').html('<p class="error word-style">This ticket is already closed.</p>');
            $('#dvloader').hide();  
        }else{
        // alert(data);
        }
    }).error(function(){
        $('#status').remove();
        $('#statbox').html('<p class="error word-style">An error occured!</p>');
        $('#dvloader').hide();
    });
}
function openReport(wordmapid, reportid){
    $('#open').click(function(){
        $('#dvloader').show(); 
        var method = 'open';
        
        $.ajax({
            type: 'POST',
            url: 'http://localhost/dict/admin/include/ajax/reportCRUD.php',
            data :{
                method:method,
                wordmapid:wordmapid,
                reportid:reportid
            }
        }).done(function(data){
            if(data == 'already open'){
                $('#status').remove();
                $('#statbox').html('<p class="error word-style">This ticket is already open.</p>');
                $('#dvloader').hide();        
            }else if(data == 'report open'){
                $('#status').remove();
                $('#statbox').html('<p class="success word-style">This ticket is successfully opened.</p>');
                $('#dvloader').hide();   
            }
        }).error(function(){
            $('#status').remove();
            $('#statbox').html('<p class="error word-style">Something went wrong!</p>');
            $('#dvloader').hide();   
        });
        
    });
}
function onholdReport(){
    alert('hello world');
}
//$('a[hreflang|="en"]').css('border','3px dotted green');


//BACK HISTORY

$(function(){
    
    $('#back').click(function(e){
        e.preventDefault();
        window.history.back();
    })
});
$(document).ready(function() 
{ 
    $("#myTable").tablesorter(); 
} 
); 
    
