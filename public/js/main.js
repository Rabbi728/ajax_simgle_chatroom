$(document).ready(function () {

    setInterval(function () {
        update_last_activity();
        fetch_user();
        update_chat_history_data();
    }, 3000);

    function fetch_user() {
        $.ajax({
            url: 'userlist.php',
            type: 'POST',
            success: function (data) {
                $('#userlist').html(data);
            }
        });
    }

    function update_last_activity() {
        $.ajax({
            url: 'control/update_last_activity.php',
            success:function () {
            }
        })
    }

    function create_chat_dialog_box(to_user_id, to_user_name){
        var modal_content = '<div id="user_dialog_'+to_user_id+'" class = "user_dialog" title = "You Will Chat With '+to_user_name+'">';
        modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y:scroll;margin-bottom:24px;padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
        modal_content += fetch_user_chat_history(to_user_id);
        modal_content += remove_unseen_message(to_user_id);
        modal_content += '</div>';
        modal_content += '<div class="form-group">';
        modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
        modal_content += '</div><div class="form-group" align="right">';
        modal_content += '<button type="button" name="sent_chat" id="'+to_user_id+'" class="btn btn-info sent_chat">sent</button></div></div>';
        $('#user_modal_details').html(modal_content);
    }

    $(document).on('click','.start_chat',function(){
        var to_user_id = $(this).data('touserid');
        var to_user_name = $(this).data('tousername');
        create_chat_dialog_box(to_user_id,to_user_name);
        $("#user_dialog_"+to_user_id).dialog({
            autoOpen:false,
            width:400
        });
        $('#user_dialog_'+to_user_id).dialog('open');
    });

    $(document).on('click','.sent_chat',function(){
        var to_user_id = $(this).attr('id');
        var chat_message = $('#chat_message_'+to_user_id).val();
        $.ajax({
            url:'insert_chat.php',
            method:'POST',
            data:{to_user_id:to_user_id,chat_message:chat_message},
            success:function(data){
                $('#chat_message_'+to_user_id).val('');
                $('#chat_history_'+to_user_id).html(data);
            }
        })
    });

    function fetch_user_chat_history(to_user_id){
        $.ajax({
            url: 'control/fetch_user_chat_history.php',
            method: 'POST',
            data:{to_user_id: to_user_id},
            success: function(data){
                $('#chat_history_'+to_user_id).html(data);
            }
        });
    }

    function update_chat_history_data(){
        $('.chat_history').each(function(){
            var to_user_id = $(this).data('touserid');
            fetch_user_chat_history(to_user_id);
        });
    }

    function remove_unseen_message(to_user_id){
        $.ajax({
           url:'control/remove_unseen_message.php',
            method:'POST',
            data:{to_user_id:to_user_id},
            success:function(data){

            }

        });
    }

});