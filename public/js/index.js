$(function() {
    $('.underplot_show').click(function(){
      $(this).find('.underplot_content').toggle();
    });
    $('.show_plus_section').click(function(){
      $('.plus_section').toggle();
    });
});

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


function get_data() {
    $.ajax({
        url: bookid+"/result/ajax",
        dataType: "json",
        success: data => {
            $("#comment-data")
                .find(".comment-visible")
                .remove();
            console.log(data);
            var html_head='<script type="text/javascript" src="/js/chat.js"></script>';
            var html1='';
            var html2='';
            var html='';
            for (var i = 0; i < data.chats.length; i++) {
                html1 = `
                            <div class="media comment-visible">
                                <div class="media-body comment-body chat_child">
                                    <span class="chat_id">${data.chats[i].number}</span>
                                    <span class="chat_user">${data.chats[i].name}</span>
                                    <span class="chat_time">${data.chats[i].created_at}</span>
                                    <br>
                        `;
                if( data.chats[i].reply_number!=null ){
                  html2=
                  `
                  <button class="btn show_reply" value="${data.chats[i].id}" id="${data.chats[i].reply_number}" ><span> >> ${ data.chats[i].reply_number_show } </span> </button><br>
                  <div class="reply${data.chats[i].id}"></div>
                  <span id="content">${ data.chats[i].content }</span>
                  </div>
                  </div>`;                  
                }else{
                  html2=`<span id="content">${ data.chats[i].content }</span>
                                </div>
                          </div>`;
                }
                html=html+html1+html2;
            }
            html=html_head+html;
            $("#comment-data").append(html);
        },
        error: () => {
            alert("ajax Error");
        }
    });

    setTimeout(get_data
    , 10000);
}

$(function() {
    get_data();
});
$(function(){

  $('#count_content').keyup(function(){
    var count = $(this).val().length;
    $('#inputlength').text(count);
  });
  
});
