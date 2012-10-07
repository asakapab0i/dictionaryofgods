$(function(){
    
    //Activate the menu
    $('#mainMenu a').addClass('buttonMenu');
    $('#subMenu a').addClass('buttonSmall');
    
    $('#mainMenu a').each(function(){
        $(this).removeClass('active');
    });
    
    $('#dictionary').addClass('active'); //End of menu activate
    
    
    var clickShare = function(e){
        e.preventDefault();
        var id = $(this).attr('id');
        //var classname = $(this).attr('class');
        
        
        if ($("#shareword"+id+"").is(":visible") || $("#reportword"+id+"").is(":visible") ){
            $("#shareword"+id+"").css("display","none");
            $("#reportword"+id+"").css("display","none");
        //$(".report-style").removeClass('share-active-button');
            
        }else{
            $("#shareword"+id+"").css("display","block");
        //$(".share-style").removeClass('share-active-button');
        }
    } 
      
    var clickReport = function(e){
        e.preventDefault();
        var id=$(this).attr('id');
        //var classname = $(this).attr('class');
        // alert(classname);
        
        if ($("#reportword"+id+"").is(":visible") || $("#shareword"+id+"").is(":visible") ){
            $("#reportword"+id+"").css("display","none");
            $("#shareword"+id+"").css("display","none");
        //$(".report-style").removeClass('share-active-button');
            
        }else{
            //$(".report-style").addClass('share-active-button');
            $("#reportword"+id+"").css("display","block");
        }
        
    }
    $('.report').click(clickReport);
    $('.share').click(clickShare);
});

//submit the report

$(function(){
    
    $.fn.validateReportForm = function(report_type,report_details,report_email,link){
        if(report_type == ''){
            alert('Please enter the following.');
            $('#reporttype').focus();
            return FALSE;
        }else if(report_details == ''){
            alert('Please enter the following.');
            $('#reportdetails').focus();
            return FALSE;
        }else if(report_email == ''){
            alert('Please enter the following.');
            $('#reportemail').focus();
            return FALSE;
        }else if(link == ''){
            alert('Please enter the following.');
            $('#permalink').focus();
            return FALSE;
        }
    }
    
    $('#sendReport').click(function(){
        var id=$('.report').attr('id');
        var report_type = $('#reporttype').val();
        var report_details = $('#reportdetails').val();
        var report_email = $('#reportemail').val();
        var link = $('#permalink').val();
        var form = 'report';
        
        $(this).validateReportForm(report_type,report_details,report_email);
        $('#dvloader').show();
        $.ajax({
            type:'POST',
            url: 'http://localhost/dict/include/ajax/formProcessing.php',
            data:{
                form:form,
                defid:id,
                type:report_type,
                detail:report_details,
                email:report_email,
                link:link
            }           
        }).success(function(data){
            if(data == 'successfully sent'){
                $(".share-style").removeClass('share-active-button');
                $('#reportform').fadeOut(1600);
                $('.report').unbind("click").click(function(e){
                    e.preventDefault();
                });
                $('#reportform').html('<p class="success">Thank you for submitting the report. We will process this in a few.</p>');
                $('#dvloader').show();
            }
        }).error(function(data){
            alert('Something went wrong!'+ data);
        });
        
    });
    
    
});
