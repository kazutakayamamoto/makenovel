function get_data(a,b) {
    var id = a;
    var value = b;
    $.ajax({
        url: "/chat/reply/"+id,
        dataType: "json",
        
        
        
        success: data => {
            $('.reply_content').remove();
            console.log(data);

            var html = `
                        <div id="reply_wrapper">
                        <div class="reply_content">
                            <span class="chat_id">${data.chat.id}</span>
                            <span class="chat_user">${data.chat.name}</span><span class="chat_user">${data.chat.created_at}</span><br>
                            <span class="content">${data.chat.content}</span>
                        </div>
                        </div>
                    `;
            
            $(".reply"+value).append(html);
        },
        error: () => {
            alert("ajax Error");
        }
    });
}

$(function() {
    $('.show_reply').on("click", function(){
        get_data(this.id,this.value);
    });
    // $('.show_reply').click(function() {
    // })

});