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
                        <span class="comment-body-content reply_content">
                            ${data.chat.id}
                            ${data.chat.name}
                            ${data.chat.content} 
                        </span>
                    `;
            
            $(".reply"+value).append(html);
        },
        error: () => {
            alert("ajax Error");
        }
    });
}

$(function() {

    $('.show_reply').click(function() {
            get_data(this.id,this.value);
    })

});