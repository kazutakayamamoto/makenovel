$(function() {
    $('.underplot_show').click(function(){
      $(this).find('.underplot_content').toggle();
    });
    $('.show_plus_section').click(function(){
      $('.plus_section').toggle();
    });
});

$(function(){

  $('#count_content').keyup(function(){
    var count = $(this).val().length;
    $('#inputlength').text(count);
  });
  
});
