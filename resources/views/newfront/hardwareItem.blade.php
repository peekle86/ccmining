@extends('layouts.newfront')
@section('content')

    <div class="flex justify-between space-x-2">
        <h1 class="text-2xl font-bold">{{ $hardwareItem->model }}</h1>

        @if( ! auth()->user()->userCart || ! optional(auth()->user()->userCart->items())->find($hardwareItem->id) )
            <div x-data="init()" x-init="calc()" class="relative px-6 flex space-x-2 whitespace-nowrap text-sm">

                <button x-show="!cart" @click="show = 1"
                        class="mx-auto md:ml-0 btn action-btn items-center flex space-x-1 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>{{ __('hardware_item.rent') }} ASIC</span>
                </button>

                <div id="buy_popup" style="display: none" x-show="show" class="fixed z-10 inset-0 overflow-y-auto"
                     aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                             aria-hidden="true"></div>

                        <!-- This element is to trick the browser into centering the modal contents. -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                              aria-hidden="true">&#8203;</span>

                        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <!-- Heroicon name: outline/exclamation -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
                                        <h3 class="text-lg font-bold leading-6 text-gray-900 whitespace-normal"
                                            id="modal-title">
                                            {{ $hardwareItem->model }}
                                        </h3>
                                        <div>
                                            <table id="first_pop" class="text-center mb-5">
                                                <thead>
                                                <tr>
                                                    <th class="text-center w-1/3">{{ __('hardware_item.hashrate') }}</th>
                                                    <th class="text-center w-1/3">{{ __('hardware_item.profitability') }}</th>
                                                    <th class="text-center w-1/3">{{ __('hardware_item.profitability') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><span x-text="hashrate"></span> <span x-text="unit"></span></td>
                                                    <td><span x-text="power"></span> {{ __('hardware_item.w') }}</td>
                                                    <td>$<span x-text="profitability"></span> /{{ __('hardware_item.day') }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <table id="second_pop" class="text-center">
                                                <thead>
                                                <tr>
                                                    <th class="text-center w-1/3">{{ __('hardware_item.price') }}($)</th>
                                                    <th class="text-center w-1/3">{{ __('hardware_item.hardware') }} (%)</th>
                                                    <th class="text-center w-1/3">{{ __('hardware_item.period') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>$<span x-text="price"></span></td>
                                                    <td>
                                                        <select x-model="percent" @change='calc()'
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
                                                    </td>
                                                    <td>
                                                        <select x-model="period_id" @change='calc()'
                                                                class="p-2 shadow-sm bg-white border rounded-lg">
                                                            @foreach ($periods as $period)
                                                                <option value="{{ $period->id }}">{{ $period->period }}
                                                                    {{ __('hardware_item.days') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button @click="submitData()" type="button"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    {{ __('hardware_item.rent') }}
                                </button>
                                <button @click="show = 0" type="button"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    {{ __('hardware_item.cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <button x-show="!cart" @click="submitData({{ $hardwareItem->id }})" class="mx-auto md:ml-0 btn action-btn items-center flex space-x-1 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Rent ASIC</span>
                </button> --}}

                <a href="{{ route('newfront.cart') }}" style="width: 132px;" x-show="cart"
                   class="mx-auto btn bg-gray-600 hover:bg-gray-500 items-center flex space-x-1 text-white"
                   style="display:none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>{{ __('hardware_item.at_cart') }}</span>
                </a>
            </div>
        @else
            <div class="relative px-6 whitespace-nowrap text-sm">
                <a href="{{ route('newfront.cart') }}" style="width: 132px;"
                   class="mx-auto py-2 px-4 bg-gray-600 hover:bg-gray-500 rounded items-center flex space-x-1 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>{{ __('hardware_item.at_cart') }}</span>
                </a>
            </div>
        @endif
    </div>

    <div class="flex flex-col space-y-6">
        <div class="flex flex-col md:flex-row md:space-x-6 space-x-0 md:space-y-0 space-y-10">

            <div class="flex-1 bg-white rounded-lg border p-6 shadow space-y-5">
                <img src="{{ $hardwareItem->photo->url ?? '' }}" alt="{{ $hardwareItem->model }}">

                <div>
                    <h2 class="text-2xl mb-1">{{ __('hardware_item.description') }}</h2>
                    {{ $hardwareItem->description ?? '' }}
                </div>
            </div>

            <div class="flex-1 bg-white rounded-lg border p-6 shadow space-y-4">
                <h2 class="text-2xl mb-1">{{ __('hardware_item.profitability') }}</h2>
                <div>
                    <canvas id="profitabilityHistory" height="34px" width="100%"></canvas>
                </div>
                <div class="pt-6">
                    <table class="table table-striped rentability">
                        <thead>
                        <tr>
                            <th>{{ __('hardware_item.period_small') }}</th>
                            <th class="text-right">/{{ __('hardware_item.day') }}</th>
                            <th class="text-right">/{{ __('hardware_item.month') }}</th>
                            <th class="text-right">/{{ __('hardware_item.year') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left"><b>{{ __('hardware_item.income') }}</b></td>
                            <td class="text-right" style="color:#0A0;">
                                ${{ number_format($profit['income'], 2) }}
                            </td>
                            <td class="text-right" style="color:#0A0;">
                                ${{ number_format($profit['income'] * 30, 2) }}
                            </td>
                            <td class="text-right" style="color:#0A0;">
                                ${{ number_format($profit['income'] * 365, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><b>{{ __('hardware_item.electricity') }}</b><span class="hidden-xs"
                                                                          style="padding-left:8px;"
                                                                          data-toggle="tooltip" data-placement="left"
                                                                          data-html="true" title=""
                                                                          data-original-title="You can change the cost of electricity (KWh) used in calculations in the local preferences on the page footer."><span
                                            class="glyphicon glyphicon-info-sign" style="color:#555;"></span></span>
                            </td>
                            <td class="text-right" style="color:#A00;">
                                -${{ number_format($profit['electricity'], 2) }}
                            </td>
                            <td class="text-right" style="color:#A00;">
                                -${{ number_format($profit['electricity'] * 30, 2) }}</td>
                            <td class="text-right" style="color:#A00;">
                                -${{ number_format($profit['electricity'] * 365, 2) }}</td>
                        </tr>
                        <tr class="color50">
                            <td class="text-left"><b>{{ __('hardware_item.profit') }}</b></td>
                            <td class="text-right" style="font-weight:800; font-size:1.1em;">
                                ${{ number_format($profit['income'] - $profit['electricity'], 2) }}
                            </td>
                            <td class="text-right" style="font-weight:800; font-size:1.1em;">
                                ${{ number_format(($profit['income'] - $profit['electricity']) * 30, 2) }}
                            </td>
                            <td class="text-right" style="font-weight:800; font-size:1.1em;">
                                ${{ number_format(($profit['income'] - $profit['electricity']) * 365, 2) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pt-6">
                    <h2 class="text-2xl mb-1">{{ __('hardware_item.algorithms') }}</h2>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{ __('hardware_item.algorythm') }}</th>
                            <th class="hidden-xs hidden-sm">{{ __('hardware_item.hashrate') }}</th>
                            <th class="hidden-xs hidden-sm">{{ __('hardware_item.consumption') }}</th>
                            <th><span class="hidden-sm hidden-xs">{{ __('hardware_item.profitability') }}</span><span
                                        class="visible-sm visible-xs">/{{ __('hardware_item.day') }}</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><b>EtHash</b>
                                <div class="lg:hidden">{!! App\Http\Controllers\Newfront\FarmController::getUnit($hardwareItem->hashrate) !!} {{ $hardwareItem->power }}
                                    {{ __('hardware_item.w') }}
                                </div>
                            </td>
                            <td class="hidden-xs hidden-sm">{!! App\Http\Controllers\Newfront\FarmController::getUnit($hardwareItem->hashrate) !!}
                                <span
                                        style="color:silver; font-size:0.9em; margin-left:6px;">±5%</span></td>
                            <td class="hidden-xs hidden-sm">{{ $hardwareItem->power }}{{ __('hardware_item.w') }}<span
                                        style="color:silver; font-size:0.9em; margin-left:6px;">±10% </span></td>
                            </td>
                            <td style="width:160px;">
                                <div class="rentability">
                                    <div class="hidden-xs" style="float:right; padding:8px;" data-toggle="tooltip"
                                         data-placement="left" data-html="true" title=""
                                         data-original-title="<b>Income : </b><font color=green>$219.60</font><br/><b>Electricity :</b> <font color=red>-$7.36</font>">
                                        <span class="glyphicon glyphicon-info-sign" style="color:#555;"></span></div>
                                    <div class="rentabilitylabel color50">
                                        <span> ${{ number_format($profit['income'], 2) }}</span><span
                                                class="hidden-xs"
                                                style="font-size:0.8em;margin-left:4px; font-weight:400;">/{{ __('hardware_item.day') }}</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:space-x-6 space-x-0 md:space-y-0 space-y-10">
            <div class="flex-1">

                <div class="bg-white rounded-lg border p-6 shadow space-y-4">
                    <h2 class="text-2xl mb-1">{{ __('hardware_item.specifications') }}</h2>
                    <div>
                        {!! $hardwareItem->specification ?? '' !!}
                    </div>
                </div>
            </div>

            <div class="flex-1 minable-coins">

                <div class="bg-white rounded-lg border p-6 shadow space-y-4">
                    <h2 class="text-2xl mb-1">{{ __('hardware_item.minable_coins') }}</h2>
                    <div>
                        {!! $hardwareItem->coins ?? '' !!}
                        <div class="clear-both"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script>
        function init() {
            return {
                unit: '',
                cart: false,
                show: false,
                percent: 100,
                period_id: 1,
                setting: {!! json_encode($setting) !!},
                periods: {!! json_encode($periods) !!},
                hard: {!! json_encode($hard) !!},
                id: {{ $hardwareItem->id }},
                hashrate: {{ $hardwareItem->hashrate }},
                power: {{ $hardwareItem->power }},
                profitability: {{ $hardwareItem->profit }},
                price: {{ $hardwareItem->price / 360 * $periods->find(1)->period }},
                calc: function () {
                    this.hashrate = this.calcHashrate();
                    this.power = this.calcPower();
                    this.price = this.calcPrice();
                    this.profitability = this.calcProfit();
                },
                calcPercent: function (val) {
                    return val / 100 * this.percent
                },
                calcPrice() {
                    return this.calcPercent(this.hard.price / 360 * this.periods[this.period_id - 1].period).toFixed(2);
                },
                calcPower() {
                    return parseInt(this.calcPercent(this.hard.power));
                },
                calcProfit() {
                    return this.calcPercent(this.hard.profit).toFixed(2);
                },
                calcHashrate() {
                    return parseInt(this.getUnit(this.calcPercent(this.hard.hashrate)));
                },
                getUnit(value) {
                    switch (true) {
                        case (value / 1000000) >= 1:
                            this.unit = 'Th/s';
                            return value / 1000000;
                            break;

                        case (value / 1000) >= 1:
                            this.unit = 'Gh/s';
                            return value / 1000;
                            break;

                        default:
                            this.unit = 'Mh/s';
                            return value;
                            break;
                    }
                },
                submitData() {
                    let hard_id = this.id;
                    let period_id = this.period_id;
                    let percent = this.percent;
                    fetch('{{ route("newfront.cart.add") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ hard_id, period_id, percent })
                    })
                        .then(() => {
                        this.cart = true;
                    this.show = false;
                    let cart_count = document.getElementsByClassName('cart-count');
                    for(let i=0; i < cart_count.length; i++) {
                        cart_count[i].innerHTML = parseInt( cart_count[i].innerText ) + 1;
                    }
                    console.log('Form sucessfully submitted!');
                })
                .catch(() => {
                        console.log('Ooops! Something went wrong!');
                })
                }
            }
        }

        const popovers = {};
        let popoverId = 1;
        document.querySelectorAll('img[data-toggle=tooltip]').forEach(item => {
            let tooltip = document.createElement('div');
            tooltip.id = 'popover-'+popoverId;
            tooltip.setAttribute('role', 'tooltip');
            tooltip.innerHTML = item.title + '<div class="arrow" data-popper-arrow></div>';
            tooltip.classList.add('tooltip');
            item.before(tooltip);

            item.removeAttribute('title');
            item.removeAttribute('data-placement');
            item.dataset.id = tooltip.id;

            popovers[tooltip.id] = {
                instance: Popper.createPopper(item, tooltip, {
                    placement: 'top',
                    modifiers: [
                        {
                            name: 'offset',
                            options: {
                                offset: [0, 8],
                            },
                        },
                    ],
                }),
                img: item,
                tooltip: tooltip
            };
            popoverId++;
        });

        function show() {
            let popoverId = this.dataset.id,
                popover = popovers[popoverId];

            popover.tooltip.setAttribute('data-show', '');
            popover.instance.update();
            popover.tooltip.querySelector('div.arrow').style.display = 'block';
        }

        function hide() {
            let popoverId = this.dataset.id,
                popover = popovers[popoverId];

            popover.tooltip.removeAttribute('data-show');
        }

        const showEvents = ['mouseenter', 'focus'];
        const hideEvents = ['mouseleave', 'blur'];

        showEvents.forEach(event => {
            Object.entries(popovers).forEach(([id, popover]) => {
                popover.img.addEventListener(event, show);
            })
        });

        hideEvents.forEach(event => {
            Object.entries(popovers).forEach(([id, popover]) => {
                popover.img.addEventListener(event, hide);
            })
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    {!! $hardwareItem->script !!}
@endsection

@section('styles')
    <style>
        table {
            width: 100%;
        }

        th {
            text-align: left
        }

        td,
        th {
            padding: 3px 5px;
        }

        tr {
            border-top: 1px solid rgb(236, 236, 236);
        }

        table.table-striped tbody tr:nth-child(odd) {
            background: rgb(245, 245, 245);
        }


        img[data-toggle] {
            border-radius: 50%;
        }
        img[data-toggle]:hover {
            box-shadow: 0px 0px 15px 4px #626262;
            transform: translate(0, -3px);
            -webkit-transition: all .2s;
            transition: all .2s;
        }

        .tooltip {
            background: #333;
            color: white;
            font-weight: bold;
            padding: 4px 8px;
            font-size: 13px;
            border-radius: 4px;
            display: none;
            z-index: 999;
        }

        .tooltip[data-show] {
            display: block;
        }

        .arrow,
        .arrow::before {
            position: absolute;
            width: 8px;
            height: 8px;
            background: #333;
        }

        .arrow {
            visibility: hidden;
        }

        .arrow::before {
            visibility: visible;
            content: '';
            transform: rotate(45deg);
        }

        .tooltip[data-popper-placement^='top'] > .arrow {
            bottom: -4px;
        }

        .tooltip[data-popper-placement^='bottom'] > .arrow {
            top: -4px;
        }

        .tooltip[data-popper-placement^='left'] > .arrow {
            right: -4px;
        }

        .tooltip[data-popper-placement^='right'] > .arrow {
            left: -4px;
        }
    </style>
@endsection
