$(function(){

   
    $("input").focus(function(){
        $(this).attr("date-place",$(this).attr("placeholder"));
        $(this).attr("placeholder","");
    });
    $("input").blur(function(){

        $(this).attr("placeholder",$(this).attr("date-place"));

    });

    let placetext = $("textarea").attr("placeholder");
    $("textarea").focus(function(){

        $(this).attr("placeholder","");
    });
    $("textarea").blur(function(){

        $(this).attr("placeholder",placetext)

    });


    $("ul li").on("click",function(){

       var scroll =  $(this).attr("date-scroll");
       $("html , body").animate({

        scrollTop : $(scroll).offset().top
       },1000);
    });

    $("body").niceScroll({
      
        cursorcolor:'var(--main-color)',
        cursorwidth:"10px"
    
       });

        $(".trangile i").click(function(){
                $(".menu-bar").show();
        });
        
        $(".cross").click(function(){

            $(".menu-bar").hide();
          
        });     


        $(".err").fadeOut(10000);


});