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
$(function() {
    $('.show_plus_section').click(function(){
      $('.setting-form').toggle();
    });
});
$(function() {
  
    $('.show_button').on("click", function(){
        $('.Replies').hide();
        $("."+this.id+"_show").toggle();
    });
});