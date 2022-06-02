@extends('layouts.newfront')

@section('content')
    <div class="flex justify-between space-x-2">
        <h1 class="text-2xl font-bold">{{ __('cart.cart') }} {{ __('cart.total') }}
            : {{ \App\Services\CartService::getCartTotal() }}</h1>

        <a href="{{ route('newfront.farm') }}"
           class="uppercase mx-auto py-2 px-4 border-2 text-blue-500 border-blue-400 hover:text-blue-400 hover:border-blue-300 rounded items-center flex space-x-1 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                      clip-rule="evenodd"/>
            </svg>
            <span>{{ __('cart.back') }}</span>
        </a>
    </div>

    @if( $cloud )
        <div class="bg-white space-y-3 border border-blue-100 p-8 rounded-lg">
            <h2 class="text-xl font-bold">{{ __('cart.contract_title') }}</h2>
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
    @endif

    @if( $hards )
        <div class="bg-white space-y-3 border border-blue-100 p-8 rounded-lg">
            <h2 class="text-xl font-bold">{{ __('cart.rent_title') }} ASIC</h2>
            <div class="flex uppercase">
                <table class="min-w-full rounded-sm divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th scope="col"
                            class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('dashboard._model') }}
                        </th>
                        <th scope="col"
                            class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('dashboard._hashrate') }}
                        </th>
                        <th scope="col"
                            class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('dashboard._power') }}
                        </th>
                        <th scope="col"
                            class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('dashboard._algo') }}
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
                            class="whitespace-nowrap px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('dashboard._hardware') }} (%)
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

                    @forelse ($hards as $key => $hard)
                        <tr id="hard_{{ $key }}" x-data='func()'
                            x-init='init({!! json_encode($hard) !!}, {{$key}}, {{$hard->profit}}); changePercent({!! json_encode($hard) !!}, {{$key}}, {{$hard->profit}})'>
                            <td class="px-2 py-4 text-center">
                                <div class="text-sm">
                                    @if($hard->pivot->amount > 0)
                                        {{ $hard->model }}
                                    @else
                                        {{ $hard->model }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 py-4 text-center whitespace-nowrap">
                                <div class="text-sm text-right text-gray-900">
                                    <span x-text="hashrate"></span>
                                    <small x-text="unit" class="text-gray-500 ml-0.5"></small>
                                </div>
                            </td>
                            <td class="px-2 py-4 text-center whitespace-nowrap">
                                <div class="text-sm text-gray-900"><span x-text="power"></span>
                                    <small
                                            class="text-gray-500 ml-0.5">W
                                    </small>
                                </div>
                            </td>
                            <td class="px-2 py-4 text-center whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $hard->algoritm->algoritm }}</div>
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
                            <td class="px-2 py-4 whitespace-nowrap text-center">
                                @if($hard->pivot->amount > 0)
                                    -
                                @else
                                    @if($cart->total)
                                        {{ $hard->pivot->percent }}
                                    @else
                                        <select x-model="percent"
                                                @change='changePercent({!! json_encode($hard) !!}, {{$key}})'
                                                class="p-2 w-20 bg-white shadow-sm border rounded-lg text-center"
                                                required>
                                            <option value=""></option>
                                            <option value="10">10%</option>
                                            <option value="20">20%</option>
                                            <option value="30">30%</option>
                                            <option value="40">40%</option>
                                            <option value="50">50%</option>
                                            <option value="60">60%</option>
                                            <option value="70">70%</option>
                                            <option value="80">80%</option>
                                            <option value="90">90%</option>
                                            <option value="100">100%</option>
                                        </select>
                                    @endif
                                @endif
                            </td>
                            <td class="relative px-2 text-center whitespace-nowrap text-sm">
                                @if($cart->total)
                                    {{ $periods->find($hard->pivot->period_id)->period }}
                                @else
                                    <select x-model="period_id"
                                            @change='changePercent({!! json_encode($hard) !!}, {{$key}})'
                                            class="p-2 shadow-sm text-center bg-white border rounded-lg">
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
                                <td class="relative text-center whitespace-nowrap text-sm">
                                    <button @click="del({{ $hard->id }}, {{ $key }})"
                                            class="font-bold p-2 text-lg text-red-600">x
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="px-2 py-4 text-center whitespace-nowrap" colspan="9">
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
    @endif


    <div class="flex space-x-5 cart_payments_block">

        <div class="flex-1">
            <div class="col-4 mb-4">
                <div class="d-flex justify-content-center align-items-center">
                    <button type="button"
                            class="payment bg-blue-600 hover:bg-blue-500 text-white block text-center w-full rounded-lg payment_block"
                            data-payment="{{ \App\Models\PaymentSystem::QIWI }}">
                        <img src="/img/qiwi.svg" alt="">
                    </button>
                </div>
            </div>
        </div>

        <div class="flex-1">
            <div class=" d-flex justify-content-center align-items-center">
                <button type="button"
                        class="payment bg-blue-600 hover:bg-blue-500 text-white block text-center w-full rounded-lg payment_block"
                        data-payment="{{ \App\Models\PaymentSystem::MASTER_CARD }}">
                    <img src="/img/pay01.svg" alt="">
                </button>
            </div>
        </div>

        <div class="flex-1">
            <div class="d-flex justify-content-center align-items-center">
                <button type="button"
                        class="payment bg-blue-600 hover:bg-blue-500 text-white block text-center w-full rounded-lg payment_block"
                        data-payment="{{ \App\Models\PaymentSystem::VISA }}">
                    <img src="/img/pay02.svg" alt="">
                </button>
            </div>
        </div>

        <div class="flex-1">
            <div class="d-flex justify-content-center align-items-center">
                <button type="button"
                        class="payment bg-blue-600 hover:bg-blue-500 text-white block text-center w-full rounded-lg payment_block"
                        data-payment="{{ \App\Models\PaymentSystem::MIR }}">
                    <img src="/img/mir.svg" alt="">
                </button>
            </div>
        </div>

        <div class="flex-1">
            <div class="d-flex justify-content-center align-items-center">
                <input id="payment_type" type="hidden" name="payment" value="0">
                <button type="button"
                        data-locale="{{ app()->getLocale() }}"
                        data-url="{{ route('newfront.payment_checkout') }}"
                        class="py-3 bg-blue-600 hover:bg-blue-500 text-white block text-center w-full rounded-lg btn_checkout_form">
                    <span>Оплатить</span>
                </button>
            </div>
        </div>

        <div class="flex-1">
            <div x-data="checkout()" id="checkout_button">
                <div x-show="Object.keys(cart_items).length" class="text-center">
                    <button @click="checkout()"
                            class="py-3 bg-green-600 hover:bg-green-500 text-white block text-center w-full rounded-lg">
                        <span>{{ __('dashboard._checkout') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="seller-info-row"></div>



@endsection

@section('scripts')
    <script>
        let cart_items = [];

        function checkout() {
            return {
                checkout() {
                    console.log(cart_items)
                    fetch('{{ route("newfront.cart.checkout") }}', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: JSON.stringify({cart_items})
                    })
                        .then(() => {
                            window.location.replace('/checkout')
                        })
                        .catch(() => {
                            console.log('Ooops!');
                        })
                }
            }
        }

        function func() {
            console.log({!! json_encode($settings) !!});
            return {
                settings: {!! json_encode($settings) !!},
                periods: {!! json_encode($periods) !!},
                percent: 100,
                hashrate: 0,
                price: 0,
                priceFormat: 0,
                profitability: 0,
                profit: 0,
                power: 0,
                unit: '',
                period_id: '',
                currency_id: '',
                id: null,
                init(item, key, profit) {
                    console.log(item);
                    this.id = item.id;
                    this.percent = item.pivot.percent ?? 100;
                    this.period_id = item.pivot.period_id ?? {{ $periods->first()->id }};
                    this.currency_id = item.pivot.currency_id ?? 4;
                    this.profit = profit;
                    // if( item.algoritm_id == 5 ) {
                    //     this.currency_id = 3
                    // } else {

                    // }
                },
                del(hard_id, key) {
                    fetch('{{ route("newfront.cart.del") }}', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: JSON.stringify({hard_id})
                    })
                        .then(() => {
                            delete cart_items[this.id];
                            document.getElementById('hard_' + key).remove();

                            let cart_count = document.getElementsByClassName('cart-count');
                            for (let i = 0; i < cart_count.length; i++) {
                                cart_count[i].innerHTML = parseInt(cart_count[i].innerText) - 1;
                            }

                            if (!cart_items) {
                                document.getElementById('checkout_button').remove();
                            }
                        })
                        .catch(() => {
                            console.log('Ooops!');
                        })
                },
                changePercent(item, key) {
                    console.log(key);
                    this.price = item.price ? (this.periods[this.period_id - 1].period * (this.percent * (item.price / 100)) / 360) : item.pivot.amount;
                    this.priceFormat = this.price ? this.price.toLocaleString() : item.pivot.amount;
                    this.profitability = item.pivot.amount ? this.getCloudProfit(item) : this.money(this.getPercent(this.profit));
                    this.hashrate = item.hashrate ? this.getUnit(this.getPercent(item.hashrate)) : '-';
                    this.power = item.power ? this.money(this.getPercent(item.power)) : '-';
                    cart_items[key] = {};
                    cart_items[key].percent = this.percent ?? 100;
                    cart_items[key].period_id = this.period_id;
                    cart_items[key].currency_id = this.currency_id;
                    cart_items[key].price = this.price;
                },
                getCloudProfit(item) {
                    return this.money(item.profitability / 360 * item.pivot.amount / 100);
                },
                getPercent(value) {
                    return value / 100 * this.percent;
                },
                getUnit(value) {
                    switch (true) {
                        case (value / 1000000) >= 1:
                            this.unit = 'Th/s';
                            return this.money(value / 1000000);
                            break;

                        case (value / 1000) >= 1:
                            this.unit = 'Gh/s';
                            return this.money(value / 1000);
                            break;

                        default:
                            this.unit = 'Mh/s';
                            return this.money(value);
                            break;
                    }
                },
                money(value) {
                    return Number.parseFloat(value).toFixed(2);
                }
            }
        }

    </script>
@endsection
