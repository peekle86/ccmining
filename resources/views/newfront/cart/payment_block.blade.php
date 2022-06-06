<div id="payment_block" class="bg-blue-500 text-white space-y-3 border border-blue-100 px-8 py-8 rounded-lg">
    @include('layouts.includes.payment_messages')
    <div class="font-bold text-2xl">{{ __('cart_blocks.payment_block_title') }}</div>
    <div>{{ __('cart_blocks.payment_block_desc') }}</div>

    <div class="text-lg font-bold pt-5"> {{ __('cart_blocks.top_up_address') }}:</div>


    <div class="flex space-x-5">
        <div>
            <div class="referal__start text-left">
                {!! $qrCode !!}
            </div>
        </div>
    </div>
    <div class="flex space-x-5">
        <div class="flex-1">
            <input id="payment_id" type="hidden" value="{{ $payment_id }}">
            <input id="wallet_id" type="hidden" name="wallet_id" value="{{ $wallet->id }}">
            <input type="text"
                   class="text-blue-500 w-full md:w-1/2 lg:w-3/3 font-bold py-2 px-4 text-left rounded"
                   value="{{ $wallet->address }}" readonly>
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
