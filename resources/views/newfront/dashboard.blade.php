@extends('layouts.newfront')

@section('content')
<div class="flex justify-between">
    <h1 class="text-2xl font-bold">{{ __('dashboard._dashboard') }}</h1>

    <div class="flex space-x-3">
        @foreach($currencies as $currency)
        <div class="flex space-x-1">
            <img class="h-6 w-6 float-left" src="{{ asset('storage/icons/crypto/' . $currency->symbol . '.svg') }}" alt=""> <span>{{ $currency->symbol }}</span> <strong>{{ $currency->in_usd }}</strong>
        </div>
        @endforeach
    </div>

    <div class="flex flex-col md:flex-row space-y-1 md:space-x-1 md:space-y-0">
        <a class="border py-2 px-5 rounded-full hover:bg-blue-600 bg-blue-500 text-white text-center" href="{{ route('newfront.withdraw.hisory') }}">{{ __('dashboard._p_history') }}</a>
        <a class="border py-2 px-5 rounded-full hover:bg-blue-600 bg-blue-500 text-white text-center" href="{{ route('newfront.withdraw') }}">{{ __('dashboard._r_payment') }}</a>
    </div>
</div>

<div class="bg-blue-500 text-white space-y-3 border border-blue-100 px-8 py-8 rounded-lg">
    <div class="font-bold text-2xl">{{ __('dashboard._invite_f_a_get') }} {{ $user->ref_percent ?? $setting->ref }}% {{ __('dashboard._of_their_earn') }}</div>
    <div>{{ __('dashboard._rewards_a_paid') }}</div>
    <div class="text-lg font-bold pt-5">{{ __('dashboard._y_ref_link') }}:</div>

    <input type="text" id="inputText" class="text-blue-500 w-full md:w-1/2 lg:w-1/3 font-bold py-2 px-4 rounded" value="{{ env('APP_URL', 'http://localhost') }}/?ref={{ auth()->user()->ref }}" readonly>
    <div class="font-bold pt-5">{{ $user->referrals()->count() }} {{ __('dashboard._refs') }} / ${{ array_sum($ref_earning) ? number_format(array_sum($ref_earning), 2) : '0.00' }} {{ __('dashboard._earned') }}</div>
</div>

<script>
    var text = document.getElementById("inputText");
    text.onclick = function() {
    text.select();
        document.execCommand("copy");
    }
</script>

<div class="grid md:grid-cols-2 lg:grid-cols-3 grid-cols-1 gap-4 uppercase text-center">

    <div class="pt-8 pb-6 px-8 bg-white border text-sm rounded-lg shadow-sm">
        <div class="flex space-x-5 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
            </svg>

            <div class="w-full pr-6 items-baseline">
                <div class="font-bold text-gray-500">{{ __('dashboard._available_for_w') }}</div>
                {{-- @foreach( $balances as $balance )
                    <div class="text-2xl"><img class="h-6 w-6" src="{{ asset('storage/icons/crypto/' . $currency->symbol . '.svg') }}" alt="">
                        {{ $balance->amount ?? '0.00000000' }} {{$balance->currency->symbol}}</div>
                @endforeach --}}

                    <div class="text-2xl"><img class="h-6 w-6 float-left" src="{{ asset('storage/icons/crypto/BTC.svg') }}" alt="">
                        {{ $balance['btc'] ? number_format( $balance['btc']->amount, 8 ) : '0.00000000' }} <span>BTC</span></div>
                <div class="text-2xl"><img class="h-6 w-6 float-left" src="{{ asset('storage/icons/crypto/ETH.svg') }}" alt="">
                        {{ $balance['eth'] ? number_format( $balance['eth']->amount, 8 ) : '0.00000000' }} <span>ETH</span></div>
                <div class="text-2xl"><img class="h-6 w-6 float-left" src="{{ asset('storage/icons/crypto/LTC.svg') }}" alt="">
                        {{ $balance['ltc'] ? number_format( $balance['ltc']->amount, 8 ) : '0.00000000' }} <span>LTC</span></div>
                <div class="text-2xl"><img class="h-10 w-10 -ml-1 -mt-1 float-left" src="{{ asset('storage/icons/crypto/USDT.svg') }}" alt="">
                        {{ $balance['usdt'] ? number_format( $balance['usdt']->amount, 2 ) : '0.00' }} <span>USDT</span></div>


            </div>
        </div>

        <div class="text-center pt-2">
            <span class="rounded-xl bg-blue-100 text-sm py-1 px-2">≈ ${{ number_format($total_usd, 2) }}</span>
        </div>
    </div>

    <div class="pt-8 pb-6 px-8 bg-white border text-sm rounded-lg shadow-sm">
        <div class="flex space-x-5 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            <div class="w-full pr-6">
                <div class="font-bold text-gray-500">{{ __('dashboard._pending_w') }}</div>
                <div class="text-2xl"><img class="h-6 w-6 float-left" src="{{ asset('storage/icons/crypto/BTC.svg') }}" alt="">{{ number_format( optional($pending)[1], 8 ) ?? '0.00000000' }} BTC</div>
                <div class="text-2xl"><img class="h-6 w-6 float-left" src="{{ asset('storage/icons/crypto/ETH.svg') }}" alt="">{{ number_format( optional($pending)[2], 8 ) ?? '0.00000000' }} ETH</div>
                <div class="text-2xl"><img class="h-6 w-6 float-left" src="{{ asset('storage/icons/crypto/LTC.svg') }}" alt="">{{ number_format( optional($pending)[3], 8 ) ?? '0.00' }} LTC</div>
                <div class="text-2xl"><img class="h-10 w-10 -ml-1 -mt-1 float-left" src="{{ asset('storage/icons/crypto/USDT.svg') }}" alt="">{{ number_format( optional($pending)[4], 2 ) ?? '0.00' }} USDT</div>
            </div>
        </div>

        <div class="text-center pt-2">
            <span class="rounded-xl bg-blue-100 text-sm py-1 px-2">≈ ${{ number_format( $pend_usd, 2 ) }}</span>
        </div>
    </div>

    <div class="pt-8 pb-6 px-8 bg-white border text-sm rounded-lg shadow-sm">
        <div class="flex space-x-5 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>

            <div class="w-full pr-6">
                <div class="font-bold text-gray-500">{{ __('dashboard._a_t_earns') }}</div>
                <div class="text-2xl"><img class="h-6 w-6 float-left" src="{{ asset('storage/icons/crypto/BTC.svg') }}" alt=""> {{ number_format(optional($earning)[1], 8) ?? '0.00000000' }} BTC</div>
                <div class="text-2xl"><img class="h-6 w-6 float-left" src="{{ asset('storage/icons/crypto/ETH.svg') }}" alt=""> {{ number_format(optional($earning)[2], 8) ?? '0.00000000' }} ETH</div>
                <div class="text-2xl"><img class="h-6 w-6 float-left" src="{{ asset('storage/icons/crypto/LTC.svg') }}" alt=""> {{ number_format(optional($earning)[3], 8) ?? '0.00000000' }} LTC</div>
                <div class="text-2xl"><img class="h-10 w-10 -ml-1 -mt-1 float-left" src="{{ asset('storage/icons/crypto/USDT.svg') }}" alt=""> {{ number_format(optional($earning)[4], 2) ?? '0.00' }} USDT</div>
            </div>
        </div>

        <div class="text-center pt-2">
            <span class="rounded-xl bg-blue-100 text-sm py-1 px-2">≈ ${{ number_format( $earn_usd, 2 ) }}</span>
        </div>
    </div>
</div>

<div class="border rounded-lg overflow-hidden shadow-sm bg-white p-5">
    <canvas id="profitabilityHistory" height="70"></canvas>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
<script>

    let graph_earn = {!! json_encode($graph_earn) !!}
    graphInit('profitabilityHistory', graph_earn,'Profit($)');

    function graphInit(id, graph_data, title="") {
        const ctx = document.getElementById(id).getContext('2d');
        const labels = graph_data['labels'];
        const data = {
            labels: labels,
            datasets: [{
                label: title,
                backgroundColor: '#cdff93',
                borderColor: 'green',
                data: graph_data['data'],
            }]
        };
        const config = {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y: {
                        min: 0,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        };
        const chart = new Chart(
            ctx,
            config
        );
    }

    // function daysInThisMonth() {
    //     var now = new Date();
    //     return new Date(now.getFullYear(), now.getMonth()+1, 0).getDate();
    // }



</script>

@endsection
