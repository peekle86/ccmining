<div class="fixed bottom-10 right-10 space-y-3 flex-col flex z-10">
    <a href="#" onclick="startChat();return false;" class="hover:opacity-90"><img width="40px" height="40px" src="{{ asset('img/msg.svg') }}" alt=""></a>
    <a href="#" class="hover:opacity-90"><img width="40px" height="40px" src="{{ asset('img/tg.svg') }}" alt=""></a>
  </div>

  <style>
    .messages {
        display: flex;
        flex-direction: column-reverse
    }
    .message {
        display: flex;
    }
    .message > div {
        padding: 10px 15px;
        border-radius: 5px;
        background: #F3F8FF;
        max-width: 80%;
        word-wrap: anywhere;
    }
    .message + .message {
        margin-bottom: 10px;
    }
    .mess-in {
        justify-content: flex-end;
    }
    .mess-in > div {
        background: #027CEF;
        color: #fff;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function startChat() {
        $('#live_chat').removeClass('hidden');

        let mess = $('#message').val();
        let email = $('#email').val();

        initChat(mess, email);
    }

    function initChat(mess, email) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });

        $.ajax({
            type: 'POST',
            url: '/chat-init',
            data: { mess, email },
            dataType: 'json',
            success: function(data) {
                if( !data ) {
                    $('#chat_email').removeClass('hidden');
                } else {
                    let messages = ''
                    jQuery('.messages').html('');
                    console.log(data);
                    for( mess in data ) {
                        let className = data[mess].from_id ? 'mess-in ' : 'mess-out ';
                        messages += '<div class="' + className + 'message">\
                                <div>' + data[mess].message + '</div>\
                            </div>';
                    }
                    jQuery('.messages').append(messages);
                }

            }
        })

        return false;
    }

    function sendMess() {
        let message = $('#message').val();
        let email = $('#email').val();
        let name = $('#name').val();
        let error_email = $('#error_email');
        error_email.text('');
        let error_mess = $('#error_mess');
        error_mess.text('');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });

        $.ajax({
            type: 'POST',
            url: '/chat',
            data: { message, email, name },
            dataType: 'json',
            success: function(data) {
                $('#chat_email').addClass('hidden');
                let messages = ''

                let className = data.from_id ? 'mess-in ' : 'mess-out ';
                messages += '<div class="' + className + 'message">\
                        <div>' + data.message + '</div>\
                    </div>';

                $('.messages').prepend(messages);
                $('#message').val('');
                $('#success_resp').removeClass('hidden');
            },
            error: function(data) {
                if( data.responseJSON.errors.email && data.responseJSON.errors.email[0] ) {
                    error_email.text( data.responseJSON.errors.email[0] )
                }
                if( data.responseJSON.errors.message && data.responseJSON.errors.message[0] ) {
                    error_mess.text( data.responseJSON.errors.message[0] )
                }
            }
        });
    }

    setInterval(() => {
        initChat();
    }, 3000);


</script>

<div id="live_chat" class="hidden z-50 fixed bottom-3 right-6 w-96 shadow-2xl rounded overflow-hidden">
    <div class="bg-blue-900 text-white flex">
        <div class="flex-grow py-3 px-5">{{ __('welcome.w_a_m') }}</div>
        <a href="#" class="py-3 px-5" onclick="this.closest('#live_chat').classList.add('hidden');return false">
            <img src="/img/chat_close.svg" alt="">
        </a>
    </div>

    <div class="h-80 bg-white p-4 overflow-y-auto messages break-words">
    </div>

    <div class="hidden bg-white p-4 text-sm" id="success_resp">{{ __('welcome.success_resp') }}</div>

    <div id="chat_email" class="bg-white p-4 space-y-2 hidden absolute top-20">
        <div>
            <label for="name">{{ __('welcome.full_name') }}</label>
            <input class="border w-full p-2 rounded" placeholder="{{ __('welcome.full_name') }}" type="text" name="name" id="name">
        </div>

        <div>
            <label for="name">{{ __('welcome.email') }}</label>
            <input class="border w-full p-2 rounded" placeholder="{{ __('welcome.email') }} *" type="email" name="email" id="email">
        </div>

        <div id="error_email" class="text-red-600"></div>
    </div>

    <div id="error_mess" class="text-red-600 bg-white py-2 px-4"></div>

    <div class="border-t-2 p-4 bg-white h-20 flex">
        <input type="text" name="message" id="message" class="h-full w-full outline-none" placeholder="{{ __('welcome.e_y_m') }}" />
        <button onclick="sendMess()" id="sent_btn" class="p-2 -mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
              </svg>
        </button>
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
    </div>
</div>

<script>
    var input = document.getElementById("message");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("sent_btn").click();
        }
    });
</script>
