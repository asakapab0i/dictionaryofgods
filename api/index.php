<!DOCTYPE html>

<html lang="en">
    <head>
        <script src="http://localhost/dict/js/jquery.js"></script>
        <script>
            $(function(){
                $.getJSON("http://localhost/dict/api/api.php?method=getRandomWord&callBack=?",
                function(data){
                    
                    var obj = JSON.stringify(data);
                    $('#word').html(obj);
                });
            });
        </script>
    </head>
    <body>
        <div id="word">
            
        </div>
    </body>
</html>