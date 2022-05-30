@extends('layouts.newfront')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
@section('content')

    <h1 class="text-2xl font-bold">{{ __('farm._title') }}</h1>

    <div x-data="{ active: {{ $hardware_types->first()->id }} }">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 uppercase max-w-3xl mx-auto text-center">

            @forelse ($hardware_types as $type )
                <a @click.prevent="active = {{ $type->id }}" href="#"
                   :class="active == {{ $type->id }} ? 'bg-blue-50' : ''"
                   class="pt-6 pb-6 px-2 bg-white border text-sm rounded-lg hover:bg-blue-50 shadow-sm">
                    <div><img class="mb-2 mx-auto h-8 w-8"
                              src="{{ asset('storage/icons/crypto/' . $type->symbol . '.svg') }}" alt=""></div>
                    <div class="font-bold">{{ $type->symbol }}</div>
                    @if($type->id == 5)
                        <div class="text-gray-500">{{ __('farm._subtitle') }}</div>
                    @else
                        <div class="text-gray-500">{{ $type->algoritm }}</div>
                    @endif
                </a>
            @empty

            @endforelse
        </div>

        <div class="flex flex-col">
            <div x-show="active == 5">
                <div x-data="cloud()" class="pt-3 items-center justify-center text-black" id="calc_modal">
                    <div class="w-600 mx-auto bg-white rounded-xl max-w-4xl py-12 px-6 space-y-5"
                         onclick="event.stopPropagation();">
                        <div class="h-40 border-b flex items-center justify-center pb-8">
                            <img src="/img/power_3.svg" id="img_power" alt="power">
                        </div>

                        <div>
                            <div class="text-xl">{{ __('welcome.sel_ghs') }}:</div>
                            <div class="text-gray-600 text-sm">*{{ __('welcome.cont_per') }}</div>
                        </div>

                        <div>
                            <input oninput="changeCalc(this)" @input="calc()" value="2500" x-model="power" type="range"
                                   id="power_range" min="2500" max="{{ $setting->max_th * 1000 }}"
                                   class="range range-lg w-full">
                        </div>

                        <div class="flex space-x-2">
                            <div class="flex-1">
                                <div>{{ __('welcome.inv_in') }} $</div>
                                <input oninput="changeCalc(this)" x-model="amount" value="250" type="number" step="10"
                                       id="amount" min="250" max="{{ $setting->price_th * $setting->max_th * 1000 }}"
                                       class="w-full border p-3 bg-gray-100 rounded">
                            </div>
                            <div class="flex-1 hidden">
                                <div>{{ __('welcome.pow_in') }} GH/s</div>
                                <input oninput="changeCalc(this)" type="number" step="10"
                                       max="{{ $setting->max_th * 1000 }}" id="power"
                                       class="w-full border p-3 bg-gray-100 rounded">
                            </div>
                        </div>

                        <div class="flex space-x-2 text-center text-sm whitespace-nowrap">
                            <div class="flex-1 rounded">
                                <div class="border py-5 px-2">
                                    <div>{{ __('welcome.d_inc') }}</div>
                                    <div class="text-blue-600 text-2xl font-bold"><span id="income_d">0</span></div>
                                </div>
                            </div>
                            <div class="flex-1 rounded">
                                <div class="border py-5 px-2">
                                    <div>{{ __('welcome.m_inc') }}</div>
                                    <div class="text-blue-600 text-2xl font-bold"><span id="income_m">0</span></div>
                                </div>
                            </div>
                            <div class="flex-1 rounded">
                                <div class="border py-5 px-2">
                                    <div>{{ __('welcome.y_inc') }}</div>
                                    <div class="text-blue-600 text-2xl font-bold"><span id="income_y">0</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center pt-4">
                            <a href="#" @click="submitData()"
                               class="mx-auto md:ml-0 btn action-btn">{{ __('welcome.buy') }}</a>
                        </div>
                    </div>

                    <div style="display: none" x-show="show" class="fixed z-10 inset-0 overflow-y-auto"
                         aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div
                            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                 aria-hidden="true"></div>

                            <!-- This element is to trick the browser into centering the modal contents. -->
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                  aria-hidden="true">&#8203;</span>

                            <div
                                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div
                                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
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
                                                {{ __('dashboard._added_cart') }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button @click="show = 0" type="button"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">{{ __('global.close') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="active == 5" class="space-y-2">
                <h2 class="text-xl font-bold">{{ __('dashboard._my_cloud') }}</h2>
                <div class="flex flex-col w-full overflow-x-auto pb-2">
                    <table class="min-w-full rounded-sm overflow-hidden divide-y divide-gray-200">
                        <thead class="bg-gray-100 text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                        <tr>
                            <th scope="col" class="px-1 py-3 text-center tracking-wider">
                                <div>{{ __('farm._description') }}</div>
                            </th>
                            <th scope="col" class="px-1 py-3 text-center tracking-wider">
                                <div>{{ __('farm._sum') }}</div>
                            </th>
                            <th scope="col" class="px-1 py-3 text-center whitespace-normal tracking-wider">
                                <div>{{ __('dashboard._start_date') }}</div>
                            </th>
                            <th scope="col" class="px-1 py-3 text-center whitespace-normal tracking-wider">
                                <div>{{ __('dashboard._end_date') }}</div>
                            </th>
                            <th scope="col" class="px-1 py-3 text-center tracking-wider">
                                <div>{{ __('farm._earn') }}</div>
                            </th>
                            <th scope="col" class="px-1 py-3 text-center tracking-wider">
                                <div>{{ __('farm._status') }}</div>
                            </th>
                            {{-- <th scope="col" style="width: 132px;" class="w-auto py-3 text-center tracking-wider">
                                <div style="width: 132px;">{{ __('dashboard._edit') }}</div>
                            </th> --}}
                        </tr>
                        </thead>

                        @forelse ($hardware_my as $k => $hardware_type )
                            @if($k == 5)
                                <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($hardware_type as $contract)
                                    <tr>
                                        <td class="py-4 px-1 text-center">
                                            <div class="text-sm text-blue-600">
                                                {{ $contract->hardware->model }}
                                            </div>
                                        </td>
                                        <td class="px-1 py-4 text-center whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                ${{ number_format($contract->amount, 2) }}</div>
                                        </td>
                                        <td class="px-1 py-4 text-center text-sm text-gray-500">
                                            {{ $contract->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-1 py-4 text-center text-sm text-gray-500">
                                            {{ $contract->created_at->addDays($contract->period->period)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-1 py-4 text-center whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                ${{ number_format($contract->transactions()->sum('in_usd'), 2) }}</div>
                                        </td>
                                        <td class="px-1 py-4 text-center whitespace-nowrap">
                                            <div
                                                class="text-sm text-gray-900">{{ \App\Services\ContractService::getContractStatus($contract->amount) }}</div>
                                        </td>

                                        {{-- <td class="py-4 relative text-sm justify-center flex">
                                            <a href="/my/{{ $contract->id }}" style="width: 132px;" class="py-2 px-4 bg-blue-600 hover:bg-blue-500 flex space-x-1 items-center rounded text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span>{{ __('dashboard._edit') }}</span>
                                            </a>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9"
                                            class="px-1 py-4 text-center text-sm text-gray-500">{{ __('dashboard._empty') }}</td>
                                    </tr>
                                @endforelse

                                </tbody>
                            @endif
                        @empty
                            <tbody>
                            <tr>
                                <td colspan="9"
                                    class="px-1 py-4 text-center text-sm text-gray-500">{{ __('dashboard._empty') }}</td>
                            </tr>
                            </tbody>
                        @endforelse
                    </table>
                </div>
            </div>

            <div x-show="active != 5" class="space-y-2 overflow-auto">
                <h2 class="text-xl font-bold">{{ __('dashboard._available_hardware') }}</h2>
                <div class="flex flex-col w-full pb-2">
                    <table class="min-w-full max-w-full rounded-sm overflow-auto divide-y divide-gray-200">
                        <thead class="bg-gray-100 text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                        <tr>
                            <th scope="col" class="py-3 text-center tracking-wider">
                                <div style="width:250px">{{ __('dashboard._model') }}</div>
                            </th>
                            <th scope="col" class="py-3 text-center tracking-wider">
                                <div style="width:80px">{{ __('dashboard._hashrate') }}</div>
                            </th>
                            <th scope="col" class="py-3 px-2 text-center tracking-wider">
                                <div style="width:60px">{{ __('dashboard._power') }}</div>
                            </th>
                            <th scope="col" class="py-3 text-center tracking-wider">
                                <div style="width:80px">{{ __('dashboard._algo') }}</div>
                            </th>
                            <th scope="col" class="py-3 text-center tracking-wider">
                                <div style="width:120px">{{ __('dashboard._profitability') }}</div>
                            </th>
                            <th scope="col" class="py-3 text-center tracking-wider">
                                <div style="width:140px">{{ __('dashboard._last_7_days') }}</div>
                            </th>
                            <th scope="col" class="w-auto py-3 text-center tracking-wider">
                                <div style="width:90px">90 {{ __('dashboard._days') }}
                                    <div class="tooltip">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                        <div class="py-1 px-3 shadow-sm rounded">
                                            {{ __('dashboard._hardware_renting_period') }}
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th scope="col" class="w-auto py-3 text-center tracking-wider">
                                <div style="width:90px">180 {{ __('dashboard._days') }}
                                    <div class="tooltip">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                        <div class="py-1 px-3 shadow-sm rounded">
                                            {{ __('dashboard._hardware_renting_period') }}
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th scope="col" class="w-auto py-3 text-center tracking-wider">
                                <div style="width:90px">360 {{ __('dashboard._days') }}
                                    <div class="tooltip">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                        <div class="py-1 px-3 shadow-sm rounded">
                                            {{ __('dashboard._hardware_renting_period') }}
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th scope="col" class="w-auto py-3 text-center tracking-wider">
                                <div style="width: 132px;">{{ __('dashboard._rent') }}</div>
                            </th>
                        </tr>
                        </thead>
                        @forelse ($hardware_available as $k => $hardware_type )
                            @if($k != 5)
                                <tbody x-show="active == {{ $k }}" class="bg-white divide-y divide-gray-200">

                                @foreach ($hardware_type as $hard)
                                    <tr>
                                        <td class="py-4 px-1">
                                            <div class="text-sm text-blue-600" style="width: 250px">
                                                <a href="{{ $hard->url }}">{{ $hard->model }}</a>
                                            </div>
                                        </td>
                                        <td class="py-4 px-1">
                                            <div class="text-sm text-center text-gray-900">
                                                {!! $Farm::getUnit($hard->hashrate) !!}
                                            </div>
                                        </td>
                                        <td class="py-4 px-1">
                                            <div class="text-sm text-gray-900 text-center">{{ $hard->power }}<small
                                                    class="text-gray-500 ml-0.5">W</small></div>
                                        </td>
                                        <td class="py-4 px-1">
                                            <div
                                                class="text-sm text-center text-gray-900">{{ $hard->algoritm->algoritm }}</div>
                                        </td>
                                        <td class="py-4 px-1 text-center">
                                    <span class="
                                        {{ $Farm::getColor($hard->profit) }}
                                        px-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        ${{ number_format($hard->profit, 2) }}/{{ __('dashboard._day') }}
                                    </span>
                                        </td>
                                        <td>
                                            <div style="width:140px;padding:3px 0">
                                                <canvas height="140" id="profitabilityHistory_{{ $hard->id }}"></canvas>
                                            </div>

                                            @php
                                                $tmp = stristr($hard->script, 'labels:');
                                                $labels = stristr($tmp, ']', true) .']';
                                                $tmp = stristr($tmp, 'data:');
                                                $data = stristr($tmp, ']', true) .']';
                                                echo '<script>';
                                                    echo 'chartData = {' . $labels . ',' . $data . '}';
                                                echo '</script>';
                                            @endphp
                                            <script>

                                                var ctx = document.getElementById("profitabilityHistory_{{ $hard->id }}").getContext("2d");
                                                var myChart = new Chart(ctx, {
                                                    type: 'line',
                                                    data: {
                                                        labels: chartData.labels.slice(0, 7),
                                                        datasets: [{
                                                            label: false,
                                                            fill: false,
                                                            lineTension: 0.2,
                                                            borderWidth: 2,
                                                            backgroundColor: '#0A0',
                                                            borderColor: '#0A0',
                                                            borderCapStyle: 'butt',
                                                            borderDash: [],
                                                            borderDashOffset: 0.0,
                                                            borderJoinStyle: 'miter',
                                                            pointBorderColor: '#0A0',
                                                            pointBackgroundColor: 'rgba(75,192,192,0.4)',
                                                            pointBorderWidth: 0,
                                                            pointHoverRadius: 0,
                                                            pointHoverBackgroundColor: '#0A0',
                                                            pointHoverBorderColor: '#0A0',
                                                            pointHoverBorderWidth: 0,
                                                            pointRadius: 0,
                                                            pointHitRadius: 0,
                                                            data: chartData.data.slice(0, 7),
                                                        }]
                                                    },
                                                    options: {
                                                        layout: {
                                                            padding: {
                                                                top: 15
                                                            }
                                                        },
                                                        tooltips: {
                                                            enabled: false
                                                        },
                                                        animation: {
                                                            duration: 0, // general animation time
                                                        },
                                                        hover: {
                                                            animationDuration: 0, // duration of animations when hovering an item
                                                        },
                                                        responsiveAnimationDuration: 0, // animation duration after a resize
                                                        elements: {
                                                            line: {
                                                                tension: 0, // disables bezier curves
                                                            }
                                                        },
                                                        legend: {
                                                            display: false
                                                        },
                                                        scales: {
                                                            xAxes: [{
                                                                display: false,
                                                                type: 'time',
                                                                time: {
                                                                    displayFormats: {
                                                                        day: 'MMM D'
                                                                    },
                                                                    tooltipFormat: 'MMMM Do YYYY'
                                                                },
                                                            }],
                                                            yAxes: [{
                                                                display: false,
                                                                ticks: {}
                                                            }]
                                                        }
                                                    }
                                                });

                                            </script>
                                        </td>
                                        <td class="py-4 px-1 text-sm text-gray-500">
                                            ${{ number_format($hard->price/4, 2) }}
                                        </td>
                                        <td class="py-4 px-1 text-sm text-gray-500">
                                            ${{ number_format($hard->price/2, 2) }}
                                        </td>
                                        <td class="py-4 px-1 text-sm text-gray-500">
                                            ${{ number_format($hard->price, 2) }}
                                        </td>
                                        @if( ! auth()->user()->userCart || ! optional($cart_items)->find($hard->id) )
                                            <td x-data="cartForm()" x-init="init({{ json_encode([
                                        'id' => $hard->id,
                                        'model' => $hard->model,
                                        'profitability' => $hard->profit,
                                        'price' => $hard->price,
                                        'power' => $hard->power,
                                        'hashrate' => $hard->hashrate
                                    ]) }})" class="relative text-sm">
                                                <div class="justify-end flex">
                                                    <button x-show="!cart" @click="show = 1; calc()" style="width:132px"
                                                            class="py-2 pl-3 pr-1 bg-green-600 hover:bg-green-500 rounded items-center flex space-x-1 text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                        </svg>
                                                        <span>{{ __('dashboard._rent') }}</span>
                                                    </button>

                                                    <a href="{{ route('newfront.cart') }}" style="width: 132px;"
                                                       x-show="cart"
                                                       class="py-2 px-4 bg-gray-600 hover:bg-gray-500 rounded items-center flex space-x-1 text-white"
                                                       style="display:none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                        </svg>
                                                        <span>{{ __('dashboard._at_cart') }}</span>
                                                    </a>

                                                    <div style="display: none" x-show="show"
                                                         class="fixed z-10 inset-0 overflow-y-auto"
                                                         aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                        <div
                                                            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                                            <div
                                                                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                                                aria-hidden="true"></div>

                                                            <!-- This element is to trick the browser into centering the modal contents. -->
                                                            <span
                                                                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                                aria-hidden="true">&#8203;</span>

                                                            <div
                                                                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                    <div class="sm:flex sm:items-start">
                                                                        <div
                                                                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                            <!-- Heroicon name: outline/exclamation -->
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                 class="h-4 w-4" fill="none"
                                                                                 viewBox="0 0 24 24"
                                                                                 stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                      stroke-linejoin="round"
                                                                                      stroke-width="2"
                                                                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                                            </svg>
                                                                        </div>
                                                                        <div
                                                                            class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
                                                                            <h3 class="text-lg font-bold leading-6 text-gray-900 whitespace-normal"
                                                                                id="modal-title">
                                                                                {{ $hard->model }}
                                                                            </h3>
                                                                            <div>
                                                                                <table id="first_pop"
                                                                                       class="text-center mb-5">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th class="text-center w-1/3">
                                                                                            HASHRATE
                                                                                        </th>
                                                                                        <th class="text-center w-1/3">
                                                                                            POWER
                                                                                        </th>
                                                                                        <th class="text-center w-1/3">
                                                                                            PROFITABILITY
                                                                                        </th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td><span
                                                                                                x-text="hashrate"></span>
                                                                                            <span x-text="unit"></span>
                                                                                        </td>
                                                                                        <td><span x-text="power"></span>
                                                                                            w
                                                                                        </td>
                                                                                        <td>$<span
                                                                                                x-text="profitability"></span>
                                                                                            /day
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table id="second_pop"
                                                                                       class="text-center">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th class="text-center w-1/3">
                                                                                            PRICE ($)
                                                                                        </th>
                                                                                        <th class="text-center w-1/3">
                                                                                            HARDWARE (%)
                                                                                        </th>
                                                                                        <th class="text-center w-1/3">
                                                                                            PERIOD
                                                                                        </th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>$<span
                                                                                                x-text="price"></span>
                                                                                        </td>
                                                                                        <td>
                                                                                            <select x-model="percent"
                                                                                                    @change='calc()'
                                                                                                    class="p-2 w-20 bg-white shadow-sm border rounded-lg text-center"
                                                                                                    required>
                                                                                                <option
                                                                                                    value=""></option>
                                                                                                <option value="10">10%
                                                                                                </option>
                                                                                                <option value="20">20%
                                                                                                </option>
                                                                                                <option value="30">30%
                                                                                                </option>
                                                                                                <option value="40">40%
                                                                                                </option>
                                                                                                <option value="50">50%
                                                                                                </option>
                                                                                                <option value="60">60%
                                                                                                </option>
                                                                                                <option value="70">70%
                                                                                                </option>
                                                                                                <option value="80">80%
                                                                                                </option>
                                                                                                <option value="90">90%
                                                                                                </option>
                                                                                                <option value="100">
                                                                                                    100%
                                                                                                </option>
                                                                                            </select>
                                                                                        </td>
                                                                                        <td>
                                                                                            <select x-model="period_id"
                                                                                                    @change='calc()'
                                                                                                    class="p-2 shadow-sm bg-white border rounded-lg">
                                                                                                @foreach ($periods as $period)
                                                                                                    <option
                                                                                                        value="{{ $period->id }}">{{ $period->period }}
                                                                                                        Days
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
                                                                <div
                                                                    class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                    <button @click="submitData()" type="button"
                                                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                        RENT
                                                                    </button>
                                                                    <button @click="show = 0" type="button"
                                                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                        Cancel
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @else
                                            <td class="relative text-sm">
                                                <div class="justify-end flex">
                                                    <a href="{{ route('newfront.cart') }}" style="width: 132px;"
                                                       class="py-2 px-4 bg-gray-600 hover:bg-gray-500 rounded items-center flex space-x-1 text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                        </svg>
                                                        <span>{{ __('dashboard._at_cart') }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach

                                </tbody>
                            @endif
                        @empty
                            <tbody>
                            <tr>
                                <td colspan="9"
                                    class="px-1 py-4 text-center text-sm text-gray-500">{{ __('dashboard._empty') }}
                                    empty
                                </td>
                            </tr>
                            </tbody>
                        @endforelse

                    </table>
                </div>
            </div>

            <div x-show="active != 5" class="space-y-2">
                <h2 class="text-xl font-bold" id="cloud_change">{{ __('dashboard._my_hardware') }}</h2>
                <div class="flex flex-col w-full overflow-x-auto pb-2">
                    <table class="min-w-full rounded-sm overflow-hidden divide-y divide-gray-200">
                        <thead class="bg-gray-100 text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                        <tr>
                            <th scope="col" class="py-3 text-center tracking-wider">
                                <div style="width:250px">{{ __('dashboard._model') }}</div>
                            </th>
                            <th scope="col" class="py-3 text-center tracking-wider">
                                <div style="width:80px">{{ __('dashboard._hashrate') }}</div>
                            </th>
                            <th scope="col" class="py-3 px-2 text-center tracking-wider">
                                <div style="width:60px">{{ __('dashboard._power') }}</div>
                            </th>
                            <th scope="col" class="py-3 text-center tracking-wider">
                                <div style="width:80px">{{ __('dashboard._algo') }}</div>
                            </th>
                            <th scope="col" class="py-3 text-center tracking-wider">
                                <div style="width:120px">{{ __('dashboard._profitability') }}</div>
                            </th>
                            <th scope="col" class="py-3 text-center tracking-wider">
                                <div style="width:140px">{{ __('dashboard._last_7_days') }}</div>
                            </th>
                            <th scope="col" class="py-3 text-center tracking-wider">
                                <div style="width:90px">{{ __('dashboard._rent_price') }}</div>
                            </th>
                            <th scope="col" class="py-3 text-center whitespace-normal tracking-wider">
                                <div style="width:90px">{{ __('dashboard._start_date') }}</div>
                            </th>
                            <th scope="col" class="py-3 text-center whitespace-normal tracking-wider">
                                <div style="width:90px">{{ __('dashboard._end_date') }}</div>
                            </th>
                            <th scope="col" class="w-auto py-3 text-center tracking-wider">
                                <div style="width: 132px;">{{ __('dashboard._edit') }}</div>
                            </th>
                        </tr>
                        </thead>

                        @forelse ($hardware_my as $k => $hardware_type )
                            @if($k != 5)
                                <tbody x-show="active == {{ $k }}" class="bg-white divide-y divide-gray-200">
                                @forelse ($hardware_type as $contract)
                                    <tr>
                                        <td class="py-4 px-1">
                                            <div class="text-sm text-blue-600 assic_title" style="width: 250px;">
                                                {{ $contract->hardware->model }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-1">
                                            <div class="text-sm text-center text-gray-900">
                                                {!! $Farm::getUnit($contract->hardware->hashrate) !!}
                                            </div>
                                        </td>
                                        <td class="py-4 px-1">
                                            <div
                                                    class="text-sm text-gray-900 text-center">{{ $contract->hardware->power }}
                                                <small class="text-gray-500 ml-0.5">W</small></div>
                                        </td>
                                        <td class="py-4 px-1">
                                            <div
                                                    class="text-sm text-gray-900 text-center">{{ $contract->hardware->algoritm->algoritm }}</div>
                                        </td>
                                        <td class="py-4 px-1 text-center">
                                <span class="
                                    {{ $Farm::getColor($contract->hardware->profit) }}
                                        px-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                                    ${{ number_format($contract->hardware->profit, 2) }}/day
                                </span>
                                        </td>
                                        <td>
                                            <div style="width:140px;padding:3px 0">
                                                <canvas height="140"
                                                        id="profitabilityHistory_{{ $contract->id . '_' . $contract->hardware->id }}"></canvas>
                                            </div>

                                            @php
                                                $tmp = stristr($contract->hardware->script, 'labels:');
                                                $labels = stristr($tmp, ']', true) .']';
                                                $tmp = stristr($tmp, 'data:');
                                                $data = stristr($tmp, ']', true) .']';
                                                echo '<script>';
                                                    echo 'chartData = {' . $labels . ',' . $data . '}';
                                                echo '</script>';
                                            @endphp
                                            <script>

                                                var ctx = document.getElementById("profitabilityHistory_{{ $contract->id . '_' . $contract->hardware->id }}").getContext("2d");
                                                var myChart = new Chart(ctx, {
                                                    type: 'line',
                                                    data: {
                                                        labels: chartData.labels.slice(0, 7),
                                                        datasets: [{
                                                            label: false,
                                                            fill: false,
                                                            lineTension: 0.2,
                                                            borderWidth: 2,
                                                            backgroundColor: '#0A0',
                                                            borderColor: '#0A0',
                                                            borderCapStyle: 'butt',
                                                            borderDash: [],
                                                            borderDashOffset: 0.0,
                                                            borderJoinStyle: 'miter',
                                                            pointBorderColor: '#0A0',
                                                            pointBackgroundColor: 'rgba(75,192,192,0.4)',
                                                            pointBorderWidth: 0,
                                                            pointHoverRadius: 0,
                                                            pointHoverBackgroundColor: '#0A0',
                                                            pointHoverBorderColor: '#0A0',
                                                            pointHoverBorderWidth: 0,
                                                            pointRadius: 0,
                                                            pointHitRadius: 0,
                                                            data: chartData.data.slice(0, 7),
                                                        }]
                                                    },
                                                    options: {
                                                        layout: {
                                                            padding: {
                                                                top: 15
                                                            }
                                                        },
                                                        tooltips: {
                                                            enabled: false
                                                        },
                                                        animation: {
                                                            duration: 0, // general animation time
                                                        },
                                                        hover: {
                                                            animationDuration: 0, // duration of animations when hovering an item
                                                        },
                                                        responsiveAnimationDuration: 0, // animation duration after a resize
                                                        elements: {
                                                            line: {
                                                                tension: 0, // disables bezier curves
                                                            }
                                                        },
                                                        legend: {
                                                            display: false
                                                        },
                                                        scales: {
                                                            xAxes: [{
                                                                display: false,
                                                                type: 'time',
                                                                time: {
                                                                    displayFormats: {
                                                                        day: 'MMM D'
                                                                    },
                                                                    tooltipFormat: 'MMMM Do YYYY'
                                                                },
                                                            }],
                                                            yAxes: [{
                                                                display: false,
                                                                ticks: {}
                                                            }]
                                                        }
                                                    }
                                                });

                                            </script>
                                        </td>
                                        <td class="px-1 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 text-center">
                                                ${{ number_format($contract->amount) }}</div>
                                        </td>
                                        <td class="px-1 py-4 text-sm text-gray-500">
                                            {{ $contract->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-1 py-4 text-sm text-gray-500">
                                            {{ $contract->created_at->addDays($contract->period->period)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-4 relative text-sm justify-center flex">
                                            <a href="/my/{{ $contract->id }}" style="width: 132px;"
                                               class="py-2 px-4 bg-blue-600 hover:bg-blue-500 flex space-x-1 items-center rounded text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                <span>{{ __('dashboard._edit') }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9"
                                            class="px-1 py-4 text-center text-sm text-gray-500">{{ __('dashboard._empty') }}</td>
                                    </tr>
                                @endforelse

                                </tbody>
                            @endif
                        @empty
                            <tbody>
                            <tr>
                                <td colspan="9"
                                    class="px-1 py-4 text-center text-sm text-gray-500">{{ __('dashboard._empty') }}</td>
                            </tr>
                            </tbody>

                        @endforelse
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function cloud() {
            return {
                show: 0,
                unit: '',
                setting: {!! json_encode($setting) !!},
                hard: {!! json_encode($hardware_available[5][0]) !!},
                amount: 250,
                percent: 100,
                power: 2500,
                calc() {
                    this.amount = parseInt(this.power * this.setting.price_th);
                    console.log(this.amount)
                },
                submitData() {
                    let hard_id = this.hard.id;
                    let amount = this.amount;
                    fetch('{{ route("newfront.cart.add") }}', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: JSON.stringify({hard_id, amount})
                    })
                        .then(() => {
                            this.show = 1;
                            let cart_count = document.getElementsByClassName('cart-count');
                            for (let i = 0; i < cart_count.length; i++) {
                                cart_count[i].innerHTML = parseInt(cart_count[i].innerText) + 1;
                            }
                            console.log('Form sucessfully submitted!');
                        })
                        .catch(() => {
                            console.log('Ooops! Something went wrong!');
                        })
                }
            }
        }
    </script>
    <script>

        function cartForm() {
            return {
                // cart: false,
                // submitData(hard_id) {
                //     fetch('{{ route("newfront.cart.add") }}', {
                //         method: 'POST',
                //         headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                //         body: JSON.stringify({ hard_id })
                //     })
                //     .then(() => {
                //         this.cart = true;
                //         let cart_count = document.getElementsByClassName('cart-count');
                //         for(let i=0; i <= cart_count.length; i++) {
                //             cart_count[i].innerHTML = parseInt( cart_count[i].innerText ) + 1;
                //         }
                //         console.log('Form sucessfully submitted!');
                //     })
                //     .catch((e) => {
                //         console.log('Ooops! Something went wrong!', e);
                //     })
                // }

                unit: '',
                cart: false,
                show: false,
                percent: 100,
                period_id: 1,
                setting: {!! json_encode($setting) !!},
                periods: {!! json_encode($periods) !!},
                hard: [],
                id: null,
                hashrate: null,
                power: null,
                profitability: null,
                price: 0,
                init: function (hardware) {
                    this.hard = hardware
                },
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
                    return this.calcPercent(this.hard.profitability).toFixed(2);
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
                    let hard_id = this.hard.id;
                    let period_id = this.period_id;
                    let percent = this.percent;
                    fetch('{{ route("newfront.cart.add") }}', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: JSON.stringify({hard_id, period_id, percent})
                    })
                        .then(() => {
                            this.cart = true;
                            this.show = false;
                            let cart_count = document.getElementsByClassName('cart-count');
                            for (let i = 0; i < cart_count.length; i++) {
                                cart_count[i].innerHTML = parseInt(cart_count[i].innerText) + 1;
                            }
                            console.log('Form sucessfully submitted!');
                        })
                        .catch(() => {
                            console.log('Ooops! Something went wrong!');
                        })
                }
            }
        }
    </script>
@endsection
