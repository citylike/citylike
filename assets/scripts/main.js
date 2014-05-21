$(document).ready(function(){
var count = true;
$("div.like").click(function(){
  var heart = $('<div class="post_animated_heart post_poof"><span class="heart_left"></span><span class="heart_right"></span></div>').toggleClass("unliked", count = !count);
  
  $(this).toggleClass("liked").append(heart);
  
    heart.fadeOut(400, function() {
      heart.remove()
    })
});

$('.boxInner .imgWrapper').hover(  
   function(){  
      $(this).find('img').stop().fadeTo('fast', 0.9);  
   },  
   function(){  
      $(this).find('img').stop().fadeTo('fast', 1);  
   }); 
});