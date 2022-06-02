<div id="payment_block" class="bg-white space-y-3 border border-blue-100 p-8 rounded-lg">
    <h2 class="text-xl font-bold">{{ __('cart_blocks.payment_link') }}</h2>
    <div class="flex uppercase">
        <table class="min-w-full rounded-sm divide-y divide-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th scope="col"
                    class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('cart.contract_table_title') }}
                </th>
                <th scope="col"
                    class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('cart.income') }}
                </th>
                <th scope="col"
                    class="whitespace-nowrap px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('dashboard._amount') }} ($)
                </th>
                <th scope="col"
                    class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('dashboard._period') }}
                </th>
                <th scope="col"
                    class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('cart.pay') }}
                </th>
                <th scope="col"
                    class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">

                </th>

            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">

            @forelse ($cloud as $key => $hard)
                <tr id="hard_{{ $key }}" x-data='func()'
                    x-init='init({!! json_encode($hard) !!}, {{$key}}, {{$hard->profit}}); changePercent({!! json_encode($hard) !!}, {{$key}}, {{$hard->profit}})'>
                    <td class="px-2 py-4">
                        <div class="text-sm text-center text-blue-600">
                            @if($hard->pivot->amount > 0)
                                <a href="{{ route('newfront.farm') }}">{{ $hard->model }} {{ \App\Services\ContractService::getContractStatus($hard->pivot->amount) }}</a>
                            @else
                                <a href="{{ $hard->url }}">{{ $hard->model }}</a>
                            @endif
                        </div>
                    </td>
                    <td class="px-2 py-4 whitespace-nowrap text-center">
                            <span class="
                                {{ $Farm::getColor($hard->profitability) }}
                                    px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                $<span x-text="profitability"></span>/{{ __('dashboard._day') }}
                            </span>
                    </td>
                    <td class="px-2 py-4 whitespace-nowrap text-center">
                        $<span x-text="priceFormat"></span>
                    </td>
                    <td class="relative px-2 text-center whitespace-nowrap text-sm">
                        @if($cart->total)
                            {{ $periods->find($hard->pivot->period_id)->period }}
                        @else
                            <select x-model="period_id"
                                    @change='changePercent({!! json_encode($hard) !!}, {{$key}})'
                                    class="p-2 shadow-sm bg-white border rounded-lg">
                                @foreach ($periods as $period)
                                    <option
                                            value="{{ $period->id }}">{{ $period->period }} {{ __('dashboard._days') }}</option>
                                @endforeach
                            </select>
                        @endif
                    </td>
                    <td class="relative px-2 text-center whitespace-nowrap text-sm">
                        @if($cart->total)
                            {{ $currencies->find($hard->pivot->currency_id)->symbol }}
                        @else
                            <select x-model="currency_id"
                                    @change='changePercent({!! json_encode($hard) !!}, {{$key}})'
                                    class="p-2 shadow-sm bg-white border rounded-lg">
                                @foreach ($hard->currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->symbol }}</option>
                                @endforeach
                            </select>
                        @endif
                    </td>
                    @if(!$cart->total)
                        <td class="relative whitespace-nowrap text-sm">
                            <button @click="del({{ $hard->id }}, {{ $key }})"
                                    class="font-bold p-2 text-lg text-red-600">x
                            </button>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td class="px-2 py-4 whitespace-nowrap" colspan="9">
                        <div class="text-sm text-gray-600 text-center">
                            {{ __('dashboard._empty') }}
                        </div>
                    </td>
                </tr>
            @endforelse

            </tbody>

        </table>
    </div>
</div>


<div id="payment_block" class="col-12 mt-5 seller-infos">
{{--    @include('layouts.includes.payment_messages')--}}
    <div>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="wrap-text">
                    <div class="fato__text">
                        <h2>{{ __('qiwi_payment_message.title') }}</h2>
                        <div class="d-flex mb-3 mt-3 align-items-start">
                            <p class="numbered-paragr">{!! __('qiwi_payment_message.description', ['note' => $note]) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                <div class="referal__start">
                    <label for="">{{ __('cart_blocks.payment_link') }}</label>
                    <div class="d-flex">
                        <div class="link d-flex justify-content-center align-items-center">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.5 9.75095C7.82209 10.1815 8.23302 10.5378 8.70491 10.7957C9.17681 11.0535 9.69863 11.2068 10.235 11.2452C10.7713 11.2836 11.3097 11.2062 11.8135 11.0183C12.3173 10.8303 12.7748 10.5363 13.155 10.156L15.405 7.90595C16.0881 7.19869 16.4661 6.25143 16.4575 5.2682C16.449 4.28496 16.0546 3.34441 15.3593 2.64913C14.664 1.95385 13.7235 1.55947 12.7403 1.55092C11.757 1.54238 10.8098 1.92036 10.1025 2.60345L8.8125 3.88595"
                                    stroke="#8A8B8E" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                                <path
                                    d="M10.5006 8.24992C10.1785 7.81933 9.76762 7.46304 9.29573 7.20522C8.82383 6.9474 8.30201 6.79409 7.76565 6.75567C7.22929 6.71726 6.69095 6.79465 6.18713 6.98259C5.68331 7.17053 5.2258 7.46462 4.84564 7.84492L2.59564 10.0949C1.91255 10.8022 1.53457 11.7494 1.54311 12.7327C1.55165 13.7159 1.94604 14.6565 2.64132 15.3517C3.3366 16.047 4.27715 16.4414 5.26038 16.45C6.24362 16.4585 7.19088 16.0805 7.89814 15.3974L9.18064 14.1149"
                                    stroke="#8A8B8E" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <input id="address" type="text" value="{{ $link }}" disabled class="input-copy">
                        <input id="payment_id" type="hidden" value="{{ $payment_id }}">
                        <div class="col-3 ml-1">
                            <a href="{{ $link }}" target="_blank" class="d-flex save-changes go-pay mr-0 d-flex justify-content-center align-items-center">
                                {{ __('cart_blocks.payment_page') }}
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <span class="future_date" style="font-size: 20px; color: green; width: 200px"></span>

                        <button class="save-changes go-pay col-4 mt-4 mr-0 сonfirm_transaction">{{ __('cart_blocks.i_paid') }}</button>
                        <button class="save-changes go-pay col-4 mt-4 mr-0 reject_сonfirm_transaction">{{ __('cart_blocks.cancel') }}</button>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="save-changes btn-success go-pay col-12 mt-4 mr-2 transaction_loader"
                                type="button" disabled style="display: none">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('cart_blocks.confirm_transaction') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="referal__start text-center">
                    <h3>
                        {{ __('cart_blocks.payment_link') }}: {{ $total }}</h4>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>

