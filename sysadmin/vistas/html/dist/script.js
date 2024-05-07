//Active state
  var active = 2;
//Cicles through every children of the progress-container, and checks if its the i state.
  $( document ).ready(function() {
    var i = 1;
    $("#progress-container > ul > li").each(function () {
      if(i<active){
        $(this).toggleClass("done");
      }else if(i == active){
        $(this).toggleClass("active");
        var texto = $(this).text();
        $(this).children("::after").css("content", i);
        $(this).append(i);
      }else{
        $(this).append(i);
      }
      i++;
    });
 });