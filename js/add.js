$(function(){
    //Completed
    
    //Plugins
    $.fn.validateForm = function(word,definition,example,tags,name,email){
        if(word == ''){
            alert('Please enter the following.');
            $('#word').focus();
            return FALSE;
        }else if(definition == ''){
            alert('Please enter the following.');
            $('#definition').focus();
            return FALSE;
        }else if(example == ''){
            alert('Please enter the following.');
            $('#example').focus();
            return FALSE;
        }else if(tags == ''){
            alert('Please enter the following.');
            $('#tags').focus();
            return FALSE
        }else if(name == ''){
            alert('Please enter the following.');
            $('#name').focus();
            return FALSE;
        }
        else if(email == ''){
            alert('Please enter the following.');
            $('#email').focus();
            return FALSE;
        }
    }//End of plugins
    
    //Activate the menu
    $('#mainMenu a').addClass('buttonMenu');
    $('#subMenu a').addClass('buttonSmall');
    
    $('#mainMenu a').each(function(){
        $(this).removeClass('active');
    });
    $('#add').addClass('active'); //End of menu activate
    
    //onclick event
    $('#submit').click(function(){
        
        var word1 = $('#word').val();
        var definition1 = $('#wmd-output').val();
        var example1 = $('#example').val();
        var tag1 = $('#tag').val();
        var name1 = $('#name').val();
        var email1 = $('#email').val();
        var captcha1 = $('#captcha').val();
        
        var word = $.trim(word1);
        var definition = $.trim(definition1);
        var example = $.trim(example1);
        var tag = $.trim(tag1);
        var name = $.trim(name1);
        var email = $.trim(email1);
        var captcha = $.trim(captcha1);
        
     
        $(this).validateForm(word,definition,example,tag,name,email);
        $('#dvloader').show();   
        $.ajax({
            type:'POST',
            url:'http://localhost/dict/include/ajax/add.php',
            data:{
                captcha:captcha,
                word:word,
                definition:definition,
                example:example,
                tag:tag,
                name:name,
                email:email
                
            }

        }).success(function(data){
           // alert(data);
            if(data == '<p class=\'error\'>Your psuedoname is already exist. Please choose another name.</p>'){
                $('#dvloader').hide();
                $('.error').remove();
                $('#nest').prepend(data);
            }else if(data == '<p class=\'error\'>Your email is already exist. Please choose another email. </p>'){
                $('#dvloader').hide();
                $('.error').remove();
                $('#nest').prepend(data);
            }else if(data == '<p class="success">Congratulations your word has been defined. <br/> Please wait for a few hours while moderators check your word. Thanks!</p>'){
                $('#dvloader').hide();
                $('#nest').html(data);
            }else if(data == '<p class="error">Error captcha input.</p>'){
                $('#dvloader').hide();
                //alert(captcha);
                $('.error').remove();
                $('#nest').prepend(data);
            }else if(data == '<p class="error">Your email is incorrect. Please try again.</p>'){
                $('#dvloader').hide();
                $('.error').remove();
                $('#nest').prepend(data);
            }else if(data == '<p class="success">Congratulations your word has been defined. <br/> Please wait for a few hours while moderators check your word.<br/>We are also in the process of verifying your new psuedoname. Thanks!</p>'){
                $('#dvloader').hide();
                $('#nest').html(data);
            }
        });

       
    }); //end of onclick event
    
   
    
    
});