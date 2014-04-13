$(document).ready(function(){
var count = true;
$("div.like").click(function(){
  var heart = $('<div class="post_animated_heart post_poof"><span class="heart_left"></span><span class="heart_right"></span></div>').toggleClass("unliked", count = !count);
  
  $(this).toggleClass("liked").append(heart);
  
    heart.fadeOut(400, function() {
      heart.remove()
    })
});

$("#switch_registration_form").click(function() {
    $("#login-modal").modal('hide');
    $("#registration-modal").modal('show');
});

$("#switch_login_form").click(function() {
    $("#registration-modal").modal('hide');
    $("#login-modal").modal('show');
});


function preventSelection(element){
  var preventSelection = false;

  function addHandler(element, event, handler){
    if (element.attachEvent) 
      element.attachEvent('on' + event, handler);
    else 
      if (element.addEventListener) 
        element.addEventListener(event, handler, false);
  }
  function removeSelection(){
    if (window.getSelection) { window.getSelection().removeAllRanges(); }
    else if (document.selection && document.selection.clear)
      document.selection.clear();
  }
  function killCtrlA(event){
    var event = event || window.event;
    var sender = event.target || event.srcElement;

    if (sender.tagName.match(/INPUT|TEXTAREA/i))
      return;

    var key = event.keyCode || event.which;
    if (event.ctrlKey && key == 'A'.charCodeAt(0))  // 'A'.charCodeAt(0) можно заменить на 65
    {
      removeSelection();

      if (event.preventDefault) 
        event.preventDefault();
      else
        event.returnValue = false;
    }
  }

  addHandler(element, 'mousemove', function(){
    if(preventSelection)
      removeSelection();
  });
  addHandler(element, 'mousedown', function(event){
    var event = event || window.event;
    var sender = event.target || event.srcElement;
    preventSelection = !sender.tagName.match(/INPUT|TEXTAREA/i);
  });

  addHandler(element, 'mouseup', function(){
    if (preventSelection)
      removeSelection();
    preventSelection = false;
  });

  addHandler(element, 'keydown', killCtrlA);
  addHandler(element, 'keyup', killCtrlA);
};

preventSelection(document);

$('.boxInner .imgWrapper').hover(  
   function(){  
      $(this).find('img').stop().fadeTo('fast', 0.9);  
   },  
   function(){  
      $(this).find('img').stop().fadeTo('fast', 1);  
   }); 
});