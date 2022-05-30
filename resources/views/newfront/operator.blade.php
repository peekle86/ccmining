@extends('layouts.newfront')

@section('content')

    <div class="flex justify-between">
        <h1 class="text-2xl font-bold">Operator</h1>
    </div>

    <div class="flex flex-col md:flex-row md:space-x-10 space-x-0 md:space-y-0 space-y-10">

        <div class="flex-1">
            <div class="bg-white overflow-y-auto rounded-lg border p-4 shadow space-y-1" style="height: 693px">
                @forelse ($chats as $chat)
                    @php
                        $avatar = '';
                        if( !$chat->user ) {
                            $avatar = substr($chat->name, 0, 1);
                        } else {
                            $avatar = optional($chat->user->avatar)->thumbnail;
                            if( !$avatar ) {
                                $avatar = substr($chat->user->name, 0, 1);
                            } else {
                                $avatar = '<img src="'. $avatar .'">';                            }
                        }
                        // $avatar = optional($chat->user->avatar)->thumbnail;
                        //if( !$avatar )
                        //$avatar = asset('storage/icons/no-image.png');
                    @endphp
                    <div onclick="getChat({{ $chat->id }})" id="dd_user_{{ $chat->id }}" class="flex space-x-2 text-sm cursor-pointer hover:bg-gray-100 p-2" >
                        <div class="w-12 h-12 border-2 overflow-hidden rounded-full text-center leading-10 pt-0.5">
                            {!! $avatar !!}
                        </div>

                        <div class="py-3">
                            <div>{{ $chat->user->name ?? $chat->name }}</div>
                            {{-- <div class="opacity-80">
                                <a href="mailto:{{ $chat->user->email  ?? $chat->email }}">{{ $chat->user->email  ?? $chat->email }}</a>
                            </div> --}}
                        </div>

                        <div>
                        @if ($chat->chatMessages()->whereRead(null)->count())
                            <span class="relative inline-block -mb-2 badge">
                                <svg class="w-6 h-6 text-gray-700 fill-current" viewBox="0 0 20 20"><path d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $chat->chatMessages()->whereRead(null)->count() }}</span>
                            </span>
                        @endif
                        </div>
                    </div>
                @empty

                @endforelse
            </div>
        </div>

        <div class="flex-auto">
            <div class="bg-white rounded-lg border p-6 shadow">
                <div style="overscroll-behavior: none;">

                    <!-- HEADING -->
                    <div class="w-full bg-blue-400 h-16 pt-2 text-white flex justify-center shadow-md"
                        style="top:0px; overscroll-behavior: none;">
                        <div class="my-3 text-blue-100 font-bold text-lg tracking-wide">Support Chat</div>
                    </div>

                    <!-- MESSAGES -->
                    <div class="pt-2 mb-2">
                        <div id="messages" class="overflow-auto break-all" style="height: 500px" style="overflow-wrap: anywhere;"></div>
                    </div>
                </div>

                <!-- MESSAGE INPUT AREA -->
                <form action="" id="chat_form" method="post">
                    <div class="w-full flex justify-between bg-blue-50">
                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                        <input type="text" name="message" id="message"
                            class="flex-grow m-2 py-2 px-4 mr-1 rounded-full border border-gray-100 bg-gray-50 resize-none"
                            rows="1" placeholder="Message..." style="outline: none;">
                        <button class="m-2" id="btn-save" style="outline: none;">
                            <svg class="svg-inline--fa text-blue-400 fa-paper-plane fa-w-16 w-12 h-12 py-2 mr-2"
                                aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paper-plane" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z" />
                            </svg>
                        </button>
                        <input type="hidden" name="chat_id" id="chat_id">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        let lastChatdata;
        let userId = {{ auth()->user()->id }}
        //let userName = '{{ auth()->user()->name }}'

        setInterval(() => {
            getLastData();
        }, 5000);

        function getLastData()
        {
            if( lastChatdata ) {
                getChat(lastChatdata[0][0]['chat_id']);
            }
        }

        function getChat(id) {

            $.ajax({
                type: 'GET',
                url: '/chatoperator',
                dataType: 'json',
                data: { id },
                success: function(data) {
                    if(lastChatdata != data) {
                        lastChatdata = data
                        let messages = '';
                        for( mess in data[0] ) {
                            let className = (userId === data[0][mess].from_id) ? 'bg-blue-100 ' : 'bg-gray-100 order-2 ';
                            let className2 = (userId === data[0][mess].from_id) ? '' : 'justify-end ';
                            let from = '';
                            let avatar = data[0][mess].avatar ? '<img src="' + data[0][mess].avatar + '"/>' : data[1].name ? data[1].name[0] : data[1].user.name[0];

                            //console.log(avatar);

                            if( !data[0][mess].from_id ) {

                                from = '<div class="text-sm pb-2">' + data[1].name + ' ' + '<a href="mailto:' + data[1].email + '">' + data[1].email + '</a></div>';
                            }
                            messages += '<div class="clear-both flex">\
                                <div class="' + className + 'mx-2 my-2 p-2 rounded-lg clear-both" style="width: calc(100% - 50px)">'
                                    + from +
                                    '<div>' + data[0][mess].message + '</div>\
                                    <div class="text-sm text-right text-gray-400">' + data[0][mess].created_at + '</div>\
                                </div>\
                                <div class="'+ className2 +'py-2 mt-1 flex" style="width: 50px"><div class="w-12 h-12 border-2 overflow-hidden rounded-full text-center leading-10 pt-0.5">' + avatar + '</div></div></div>';
                        }
                        jQuery('#messages').html(messages);
                        jQuery('#chat_id').val(id);
                        jQuery('#dd_user_'+id).find('.badge').hide();
                    }
                },
                error: function(data) {
                    //console.log(data);
                }
            });
        }

        jQuery(document).ready(function($) {
            // CREATE
            $("#btn-save").click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('input[name="csrf-token"]').val()
                    }
                });
                var formData = {
                    message: jQuery('#message').val(),
                    chat_id: jQuery('#chat_id').val()
                };
                var state = jQuery('#btn-save').val();

                $.ajax({
                    type: 'POST',
                    url: '/chatoperator',
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        let message = ''
                        let className = (userId === data.from_id) ? 'bg-blue-100 ' : 'bg-gray-100 order-2 ';
                        let className2 = (userId === data.from_id) ? '' : 'justify-end ';

                        let avatar = data.avatar ? '<img src="' + data.avatar + '"/>' : data.name;

                        message += '<div class="clear-both flex">\
                            <div class="' + className + 'mx-2 my-2 p-2 rounded-lg clear-both" style="width: calc(100% - 50px)">\
                                <div>' + data.message + '</div>\
                                <div class="text-sm text-right text-gray-400">' + data.created_at + '</div>\
                            </div>\
                            <div class="'+ className2 +'py-2 mt-1 flex" style="width: 50px"><div class="w-12 h-12 border-2 overflow-hidden rounded-full text-center leading-10 pt-0.5">' + avatar + '</div></div></div>';
                        jQuery('#messages').prepend(message);
                        jQuery('#chat_form').trigger("reset");
                    },
                    error: function(data) {
                        console.log('error',data);
                    }
                });
            });
        });
    </script>

@endsection
