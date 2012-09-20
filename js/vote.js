$(function(){
    $('.imageup').click(function(){
        var defid = this.id;
       
       
        $.ajax({
            url: "http://localhost/dict/include/ajax/vote.php",
            type: "GET",
            data: {
                method:"UP",
                defid:defid
            }
        }).success(function(data){
            $("#upNum"+defid+"").empty();
            $("#upNum"+defid+"").html(data);
        });
 
    });
    $('.imagedown').click(function(){
        var defid = this.id;
       
       
        $.ajax({
            url: "http://localhost/dict/include/ajax/vote.php",
            type: "GET",
            data: {
                method:"DOWN",
                defid:defid
            }
        }).success(function(data){
            $("#downNum"+defid+"").empty();
            $("#downNum"+defid+"").html(data);
        });
 
    });
});
