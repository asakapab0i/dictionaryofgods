$(function(){
    
    $('#mainMenu a').addClass('buttonMenu');
    $('#subMenu a').addClass('buttonSmall');
    
    $('#mainMenu a').each(function(){
        $(this).removeClass('active');
    });
    
// $('#report').addClass('active'); //End of menu activate
    
});



$(function(){
    $.fn.validateForm = function(user,pass,code){
        if(user == ''){
            alert('Please enter the following.');
            $('#user').focus();
            return FALSE;
        }else if(pass == ''){
            alert('Please enter the following.');
            $('#pass').focus();
            return FALSE;
        }else if(code == ''){
            alert('Please enter the following.');
            $('#code').focus();
            return FALSE;
        }   
    }
    
    $('#login').click(function(){
        var user = $('#user').val();
        var pass = $('#pass').val();
        var code = $('#code').val();

        $(this).validateForm(user,pass,code);
        $('#dvloader').show(); 
        $.ajax({
            type: 'POST',
            url: 'http://localhost/dict/admin/include/ajax/login.php',
            data: {
                username:user,
                password:pass,
                access_token:code
            }
        }).done(function(data){
            //alert(data);
            if(data == 'Incorrect credentials please try again'){
                $('#notif').html('<p class="error word-style">Incorrect credentials please try again</p>');
                $('#dvloader').hide(); 
            }else if(data = 'login success'){
                //alert(data);
                window.location = "http://localhost/dict/admin/reports.php";
            }else{
               // alert(data);
            }
        })
    });
});