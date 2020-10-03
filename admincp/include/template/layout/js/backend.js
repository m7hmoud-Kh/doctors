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

     $(".warn").fadeOut(8000);

     $(".menuadmin").click(function(){

        $(".baradmin").show(800);
         $(".hide").css({
             display:"inline-block",
         });
        $(".show").css({
            display:'none',
        });
       });

       $(".hide").click(function(){

        $(".baradmin").hide(800);
         $(".hide").css({
             display:"none",
         });
        $(".show").css({
            display:'inline-block',
        });
         
       });


       $(".err").fadeOut(10000);

       $(".showadmin").click(function(){
                 
          $(".dashbordmenu").show(1000);
          $(this).css({
              display:'none'
          });
          $(".hideadmin").css({
               display: 'block'
          });
       });

       $(".hideadmin").click(function(){

        $(".dashbordmenu").hide(800);
        $(this).css({
            display:'none'
        });
        $(".showadmin").css({
             display: 'block'
        });

       });


       $(".con").confirm({
        text: "Are you sure to delete this doctor?",
        confirmButton: "Yes I am",
        cancelButton: "Cancel",
        post: false,
        confirmButtonClass: "btn-danger",
        cancelButtonClass: "btn-info",
        dialogClass: "modal-dialog modal-lg" // Bootst
       });
 
       $(".sick").confirm({
        text: "Are you sure to delete sick people?",
        confirmButton: "Yes I am",
        cancelButton: "Cancel",
        post: false,
        confirmButtonClass: "btn-danger",
        cancelButtonClass: "btn-info",
        dialogClass: "modal-dialog modal-lg" // Bootst
       });

        $(".showcat").click(function(){
        
            $(".categorsick").show(400);
            $(".showcat").css({
                display:"none"
            });
            $(".hidecat").css({

                display:"inline-block"
            });
        
        }); 
        
        $(".hidecat").click(function(){
        
            $(".categorsick").hide(400);
            $(".showcat").css({
                display:"inline-block"
            });
            $(".hidecat").css({

                display:"none"
            });
        
        }); 


        $(".deleadmin").confirm({
            text: "Are you sure to delete this Admin?",
            confirmButton: "Yes I am",
            cancelButton: "Cancel",
            post: false,
            confirmButtonClass: "btn-danger",
            cancelButtonClass: "btn-info",
            dialogClass: "modal-dialog modal-lg" // Bootst
           });

});