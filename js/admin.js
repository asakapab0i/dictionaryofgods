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
        var wordid = $.getURLParam("wid");
        var id = $(this).attr('id');
        // alert(id);
           
        if(id=='delete'){
            deleteWord(wordid);
        }else if(id == 'edit'){
            editWord(wordid);
        }else if(id=='close'){
            closeReport(reportid);
        }else if(id=='open'){
            openReport(reportid);
        }else if(id == 'onhold'){
            onholdReport(reportid);
        }
        
        
    });

});

function deleteWord(wordid){
    //delete the word ajax calling
   
    alert(wordid);
    this.preventDefault();
}
function editWord(){
    alert('hello world');
}
function closeReport(){
    alert('hello world');
}
function openReport(){
    alert('hello world');
}
function onholdReport(){
    alert('hello world');
}
//$('a[hreflang|="en"]').css('border','3px dotted green');