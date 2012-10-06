<!DOCTYPE html>

<html lang="en">
    <head>
        <script src="http://localhost/dict/js/jquery.js"></script>
        <script>
            $(function(){
                $.getJSON("http://localhost/dict/api/api.php?method=getRandomWord&getEstoryahe=?",
                function(data){
                    
                    for(auser in data){
                        var user = data[auser];
                        var a = console.log(user.defid)
                    }
                     var obj = JSON.stringify(user.word);
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