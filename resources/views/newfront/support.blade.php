@extends('layouts.newfront')

@section('content')

    <div class="flex justify-between">
        <h1 class="text-2xl font-bold">{{ __('support.support_title') }}</h1>
    </div>

    <div class="flex flex-col md:flex-row md:space-x-10 space-x-0 md:space-y-0 space-y-10">
        <div class="xl:w-2/3 w-full">
            <div class="bg-white rounded-lg border p-6 shadow">
                <div style="overscroll-behavior: none;">

                    <!-- HEADING -->
                    <div class="w-full bg-blue-400 h-16 pt-2 text-white flex justify-center shadow-md"
                        style="top:0px; overscroll-behavior: none;">
                        <div class="my-3 text-blue-100 font-bold text-lg tracking-wide">{{ __('support.support_chat') }}</div>
                    </div>

                    <!-- MESSAGES -->
                    <div class="pt-2 mb-2">
                        <div id="messages" class="overflow-auto break-all" style="height: 250px" style="overflow-wrap: anywhere;"></div>
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
                    </div>
                </form>
            </div>
        </div>

        <div class="xl:w-1/3 w-full">

            <div class="bg-white rounded-lg border p-6 shadow space-y-4" style="height: 444px">

                <div class="w-full bg-green-400 h-16 pt-2 text-white flex justify-center shadow-md"
                    style="top:0px; overscroll-behavior: none;">
                    <div class="my-3 text-green-100 font-bold text-lg tracking-wide">{{ __('support.contact_us') }}</div>
                </div>

                <!-- MESSAGES -->
                <div class="pt-6 mb-16">
                    <ul class="space-y-4 px-6">
                        @forelse ($contacts as $contact )
                            <li>
                                    <div class="flex space-x-2 items-center">
                                        <img class="w-6 h-6"
                                            src="{{ asset('storage/icons/contact/' . $contact::TYPE_SELECT[$contact->type] . '.svg') }}"
                                            alt="">
                                        <div>{{ $contact::TYPE_SELECT[$contact->type] }}</div>
                                        <div class="text-blue-700">{{ $contact->number }}</div>
                                    </div>
                                </li>
                        @empty

                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="flex space-x-10" x-data="{ activeTab: {{ optional($faqs->first())->id }} }">
        <div class="w-1/3">
            <div class="bg-white rounded-lg border p-6 shadow">
                <div class="font-bold text-xl">FAQ</div>
                <ul class="my-2 border-l-2">
                    @forelse ( $faqs as $faq )
                        <li class="cursor-pointer py-1 px-4 text-gray-500"
                            :class="activeTab=={{ $faq->id }} ? 'text-blue-500' : ''"
                            @click="activeTab = {{ $faq->id }}">{{ $faq->question }}</li>
                    @empty

                    @endforelse
                </ul>
            </div>
        </div>

        <div class="w-2/3">
            <div class="bg-white rounded-lg border p-6 shadow">
                @forelse ( $faqs as $faq )
                    <div x-show="activeTab=={{ $faq->id }}">
                        <div class="pb-2 font-bold text-xl">{{ $faq->question }}</div>{{ $faq->answer }}
                    </div>
                @empty

                @endforelse
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        jQuery(document).ready(function($) {

            let input = document.getElementById("message");

            let userId = {{ auth()->user()->id }}
            let userName = '{{ auth()->user()->name }}'

            input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    //formSend();
                    return false;
                }
            });

            $.ajax({
                type: 'GET',
                url: '/chat',
                dataType: 'json',
                success: function(data) {
                        console.log(data);
                    let messages = '';
                    for( mess in data ) {
                        let className = (userId === data[mess].from_id) ? 'bg-blue-100 ' : 'bg-gray-100 order-2 ';
                        let className2 = (userId === data[mess].from_id) ? '' : 'justify-end ';
                        let avatar = data[mess].avatar ? '<img src="' + data[mess].avatar + '"/>' : userName[0];
                        messages += '<div class="clear-both flex">\
                            <div class="' + className + 'mx-2 my-2 p-2 rounded-lg clear-both" style="width: calc(100% - 50px)">\
                                <div>' + data[mess].message + '</div>\
                                <div class="text-sm text-right text-gray-400">' + data[mess].created_at + '</div>\
                            </div>\
                            <div class="'+ className2 +'py-2 mt-1 flex" style="width: 50px" style="width: 50px"><div class="w-12 h-12 border-2 overflow-hidden rounded-full text-center leading-10 pt-0.5">' + avatar + '</div></div></div>';
                    }
                    jQuery('#messages').prepend(messages);

                },
                error: function(data) {
                    //console.log(data);
                }
            });

            // CREATE
            $("#btn-save").click(function(e) {
                e.preventDefault();
                formSend();
            });

            function formSend() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('input[name="csrf-token"]').val()
                    }
                });

                var formData = {
                    message: jQuery('#message').val(),
                };
                var state = jQuery('#btn-save').val();
                var type = "POST";
                var ajaxurl = '/chat';

                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        let message = ''
                        let className = (userId === data.from_id) ? 'bg-blue-100 ' : 'bg-gray-100 order-2 ';
                        let className2 = (userId === data.from_id) ? '' : 'justify-end ';
                        let avatar = data.avatar ? '<img src="' + data.avatar + '"/>' : userName[0];

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
                        //console.log(data);
                    }
                });
            }
        });
    </script>

@endsection
