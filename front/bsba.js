//Slider part
var moveSlider = false;
jQuery(document).ready(function($){
    $(".ba-Slider").each(function(i){
        $(this).children(".slider").mousedown(function(){
             moveSlider = true;
            $(this).parent().children("#before").removeClass("ease");
            $(this).removeClass("ease");
        });
        $(this).children(".slider").mouseup(function(){
            moveSlider = false;
            $(this).parent().children("#before").addClass("ease");
            $(this).addClass("ease");
            var minmax = $(this).parent().width() / 8;
            if($(this).parent().children("#before").width() > $(this).parent().width() - minmax){
                $(this).parent().children("#before").width("100%");
                var sOffset = $(this).parent().width() - 16.5;
                $(this).css("left", sOffset);
            }else if($(this).parent().children("#before").width() < minmax){
                $(this).parent().children("#before").width(0);
                var sOffset = -16.5;
                $(this).css("left", sOffset);
             }
            
        });
        
        $(this).mouseup(function(){
            moveSlider = false;
            $(this).children("#before").addClass("ease");
            $(this).children(".slider").addClass("ease");
            var minmax = $(this).width() / 8;
            if($(this).children("#before").width() > $(this).width() - minmax){
                $(this).children("#before").width("100%");
                var sOffset = $(this).width() - 16.5;
                $(this).children(".slider").css("left", sOffset);
            }else if($(this).children("#before").width() < minmax){
                $(this).children("#before").width(0);
                var sOffset = -16.5;
                $(this).children(".slider").css("left", sOffset);
             }
            
            
        });
        $(this).mousemove(function(e){
            if(moveSlider == true){
                var pOffset = $(this).offset(); 
                var mouseX = e.pageX - pOffset.left;
                $(this).children("#before").width(mouseX - 0.5);
                var sOffset = mouseX - 16.5;
                $(this).children(".slider").css("left", sOffset);
            }
            
        });
    });

    // Edit button takes item ID & send
    // it for save it in php session
    $('').on('click', function() {
        var id = $(this).parent().find(".id_all").val();

        $.ajax({
            method: "POST",
            url: "/wp-content/plugins/BSBA/back/save_id.php",
            data:{
                'id': id,
            },
            success: function(data){
               // console.log(data);
            },
        });
	})

});

