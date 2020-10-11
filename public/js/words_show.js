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

    setTimeout(get_data
    , 5000);
}

$(function() {
    get_data();
});