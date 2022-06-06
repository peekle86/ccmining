<div id="payment_block" class="bg-blue-500 text-white space-y-3 border border-blue-100 px-8 py-8 rounded-lg">
    @include('layouts.includes.payment_messages')
    <div class="font-bold text-2xl">{{ __('qiwi_payment_message.title') }}</div>
    <div>{!! __('qiwi_payment_message.description', ['note' => $note]) !!}</div>

    <div class="text-lg font-bold pt-5">{{ __('cart_blocks.payment_link') }}:</div>

    <input id="address" type="hidden" value="{{ $link }}" disabled class="input-copy">
    <input id="payment_id" type="hidden" value="{{ $payment_id }}">
    <div class="flex space-x-5">
        <div class="flex-1">
            <input type="text" id="inputText" class="text-blue-500 w-full md:w-2/2 lg:w-3/3 font-bold py-2 px-4 rounded"
                   value="{{ $link }}" readonly>
        </div>
        <div class="flex-1">
            <a href="{{ $link }}"
                class="py-2 md:w-1/2 lg:w-1/3 border-2 text-white-500 border-white-400 hover:text-green-400 hover:border-green-300 text-white block text-center w-full rounded-lg">
                {{ __('cart_blocks.payment_page') }}
            </a>
        </div>
    </div>
    <div class="font-bold pt-5">{{ __('cart_blocks.amount_payable') }}: {{ $total }}</h4></div>

        <div class="flex space-x-5">
            <div class="flex-1">
                <button
                    class="py-3 border-2 text-white-500 border-white-400 hover:text-green-400 hover:border-green-300 text-white block text-center w-full rounded-lg сonfirm_transaction">
                    {{ __('cart_blocks.i_paid') }}
                </button>
            </div>
            <div class="flex-1">
                <button
                    class="py-3 border-2 text-white-500 border-white-400 hover:text-red-400 hover:border-red-300 text-white block text-center w-full rounded-lg reject_сonfirm_transaction">
                    {{ __('cart_blocks.cancel') }}
                </button>
            </div>
        </div>
    </div>
