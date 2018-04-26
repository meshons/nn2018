var scrollerl = 0;
var scrollerr = 0;

function lefter() {
    $("#left").animate({
      scrollTop: scrollerl
    }, 1000,"linear", function() {
      if(parseInt($("#left").children().first().outerHeight(),10)+10<=(scrollerl)){
        scrollerl -= parseInt($("#left").children().first().outerHeight(),10) +10;
        $("#left").children().first().detach().appendTo($("#left"));
      }
      scrollerl+=50;
      // Animation complete.
      lefter();
    })
  }
  
  function righter() {
    //console.log("R");
    $("#right").animate({
      scrollTop: scrollerr
    }, 1000,"linear", function() {
      if(parseInt($("#right").children().first().outerHeight(),10)+15<=(scrollerr)){
        scrollerr -= parseInt($("#right").children().first().outerHeight(),10) +15;
        $("#right").children().first().detach().appendTo($("#right"));
      }
      scrollerr+=50;
      // Animation complete.
      righter();
    })
  }

$(document).ready(function () {  
    setTimeout(lefter, 2000);
    setTimeout(righter, 2000);
});