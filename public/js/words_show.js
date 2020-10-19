function get_data() {
    var id = $('div.item').data('id');
    $.ajax({
        url: "/words/result/ajax/word/chat/"+id,
        dataType: "json",
        success: data => {
            $("#comment-data")
                .find(".comment-visible")
                .remove();
            console.log(data);
            for (var i = 0; i < data.chats.length; i++) {
                var html = `
                            <div class="media comment-visible">
                                <div class="media-body comment-body chat_child">
                                    <span class="chat_id">${data.chats[i].id}</span>
                                    <span class="chat_user">${data.chats[i].name}</span>
                                    <br>
                                    <span id="content">${ data.chats[i].content }</span>
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

    setTimeout(get_data
    , 5000);
}

$(function() {
    get_data();
});
$(function() {
    $('.show_plus_section').click(function(){
      $('.setting-form').toggle();
    });
});