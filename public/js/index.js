$(function() {
  $(".box4").hide();
  // チェックボックスをチェックしたら発動
  $('input[name="check"]').change(function() {
 
    // prop()でチェックの状態を取得
    var prop = $('#prop').prop('checked');

    // もしpropがチェック状態だったら
    if (prop) {
      $(".box4").show();
    } else {
      $(".box4").hide();
    }
    
  });
});

$(function() {
    $('.underplot_show').click(function(){
      $(this).find('.underplot_content').toggle();
    });
});

function get_data() {
    $.ajax({
        url: "result/ajax/",
        dataType: "json",
        success: data => {
            $("#comment-data")
                .find(".comment-visible")
                .remove();
            console.log(data);
            for (var i = 0; i < data.chats.length; i++) {
                var html = `
                            <div class="media comment-visible">
                                <div class="media-body comment-body">
                                    <span class="comment-body-content" id="content">${data.chats[i].content}</span>
                                </div>
                            </div>
                        `;
        
                $("#comment-data").append(html);
            }
        },
        error: () => {
            alert("ajax Error");
        }
    });

    setTimeout(get_data, 5000);
}

$(function() {
    get_data();
});

