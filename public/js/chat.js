// function get_data(a,b) {
//     var id = a;
//     var value = b;
//     $.ajax({
//         url: "/chat/reply/"+id,
//         dataType: "json",
        
   

//         success: data => {
//         $('.reply_content').remove();                 
//             console.log(data);
//             var html='';
//             var html1='';
//             var html_head=`<div class="reply_content">`;
//             html = `
//                         <div id="reply_wrapper">
//                             <span class="chat_id">${data.chat.number}</span>
//                             <span class="chat_user">${data.chat.name}</span><span class="chat_time">${data.chat.created_at}</span><br>`;
//             if( data.chat.reply_number!=null ){
//                 html1 = `
//                             <button class="btn show_reply" value="${data.chat.id}" id="${data.chat.reply_number}" ><span> >> ${ data.chat.reply_number_show } </span> </button><br>
//                             <div class="reply${data.chat.id}"></div>                
//                             <span class="content">${data.chat.content}</span>
//                             </div>
//                             </div>`;
//             }else{
//                 html1 = `
//                             <span class="content">${data.chat.content}</span>
//                             </div>
//                             </div>
//                             </section>`;
//             }
//             html=html_head+html+html1;
//             $(".reply"+value).append(html);
//         },
//         error: () => {
//             alert("ajax Error");
//         }
//     });
// }

// $(function() {
//     $('.show_reply').on("click", function(){
//         get_data(this.id,this.value);
//     });
// });

$(function() {

    $('.show_button').on("click", function(){
        //$('.Replies').hide();
        $("."+this.id+"_show").toggle();
    });
});