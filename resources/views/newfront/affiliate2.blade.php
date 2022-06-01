@extends('layouts.newfront')

@section('content')

    <h1 class="text-2xl font-bold">{{ __('dashboard._affiliate') }}</h1>

    <div class="bg-blue-500 text-white space-y-3 border border-blue-100 px-8 py-8 rounded-lg">
        <div class="font-bold text-2xl">{{ __('dashboard._invite_f_a_get') }} {{ $user->ref_percent ?? $setting->ref }}% {{ __('dashboard._of_their_earn') }}</div>
        <div>{{ __('dashboard._rewards_a_paid') }}</div>
        <div class="text-lg font-bold pt-5">{{ __('dashboard._y_ref_link') }}:</div>
        <input type="text" id="inputText" class="text-blue-500 w-full md:w-1/2 lg:w-1/3 font-bold py-2 px-4 rounded"
            value="{{ env('APP_URL', 'http://localhost') }}/?ref={{ auth()->user()->ref }}" readonly>
        <div class="font-bold pt-5">
            {{ $user->referrals()->count() }} {{ __('dashboard._refs') }} /
            ${{ array_sum($ref_earning) ? number_format(array_sum($ref_earning), 2) : '0.00' }} {{ __('dashboard._earned') }}
        </div>
    </div>

    <script>
        var text = document.getElementById("inputText");
        text.onclick = function() {
        text.select();
            document.execCommand("copy");
        }
    </script>

    <div class="bg-white space-y-3 border border-blue-100 p-8 rounded-lg">
        <div class="flex text-center uppercase">
            <div class="text-sm flex-1">
                <div>
                    <div class="mb-2 flex items-center justify-center mx-auto w-14 h-14 bg-gray-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="blue">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-gray-500 font-bold">{{ __('dashboard._clicks') }}</div>
                <div class="font-bold text-xl">
                    {{ $clicks ?? 0 }}
                </div>
            </div>

            <div class="text-sm flex-1">
                <div>
                    <div class="mb-2 flex items-center justify-center mx-auto w-14 h-14 bg-gray-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="blue">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                </div>
                <div class="text-gray-500 font-bold">{{ __('dashboard._signed_up') }}</div>
                <div class="font-bold text-xl">
                    {{ $user->referrals()->count() ?? 0 }}
                </div>
            </div>

            <div class="text-sm flex-1">
                <div>
                    <div class="mb-2 flex items-center justify-center mx-auto w-14 h-14 bg-gray-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="blue">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-gray-500 font-bold">{{ __('dashboard._earns') }}</div>
                <div class="font-bold text-xl">
                    {{ $earns ?? 0 }}
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white space-y-3 border border-blue-100 p-8 rounded-lg">

        <canvas id="click_chart" height="70"></canvas>
    </div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
<script>
    let clicks = {!! json_encode($clicks_graph) !!}
    let registers = {!! json_encode($registrations_graph) !!}
    let earns = {!! json_encode($earns_graph) !!}


    new Chart(document.getElementById("click_chart"), {
        type: 'line',
        data: {
            labels: clicks.labels,
            datasets: [
                {
                    data: clicks.data,
                    label: "{{ __('dashboard._clicks') }}",
                    backgroundColor: '#cdff93',
                    borderColor: 'green',
                    fill: false
                }, {
                    data: registers.data,
                    label: "{{ __('dashboard._signed_up') }}",
                    backgroundColor: '#90dafb',
                    borderColor: 'blue',
                    fill: false
                }, {
                    data: earns.data,
                    label: "{{ __('dashboard._earns') }}",
                    backgroundColor: '#ffa9a3',
                    borderColor: 'red',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            stacked: false,
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });


    {{--new Chart(document.getElementById("click_chart"), {--}}
        {{--type: 'line',--}}
        {{--data: {--}}
            {{--labels: clicks.labels,--}}
            {{--datasets: [{--}}
                {{--data: clicks.data,--}}
                {{--label: "{{ __('dashboard._clicks') }}",--}}
                {{--backgroundColor: '#cdff93',--}}
                {{--borderColor: 'green',--}}
                {{--fill: false--}}
            {{--}, {--}}
                {{--data: registers.data,--}}
                {{--label: "{{ __('dashboard._signed_up') }}",--}}
                {{--backgroundColor: '#90dafb',--}}
                {{--borderColor: 'blue',--}}
                {{--fill: false--}}
            {{--}, {--}}
                {{--data: earns.data,--}}
                {{--label: "{{ __('dashboard._earns') }}",--}}
                {{--backgroundColor: '#ffa9a3',--}}
                {{--borderColor: 'red',--}}
                {{--fill: false--}}
            {{--}--}}
            {{--]--}}
        {{--},--}}
        {{--options: {--}}
            {{--scales: {--}}
                {{--y: {--}}
                    {{--min: 0,--}}
                    {{--ticks: {--}}
                        {{--stepSize: 1--}}
                    {{--}--}}
                {{--}--}}
            {{--}--}}
        {{--}--}}
    {{--});--}}







    //graphInit('click_chart', [clicks, registers, earns], ['Clicks', 'Registrations', 'Earn']);
    // graphInit('reg_chart', registers,'Registrations');
    // graphInit('earn_chart', earns,'Earn');


    function graphInit(id, graph_data, title=[]) {
//    console.log(graph_data)

        const colors = [
            {
                backgroundColor: '#cdff93',
                borderColor: 'green',
            },
            {
                backgroundColor: '#90dafb',
                borderColor: 'blue',
            },
            {
                backgroundColor: '#ffa9a3',
                borderColor: 'red',
            },
        ]
        const ctx = document.getElementById(id).getContext('2d');
        const labels = graph_data[0]['labels'];
        const datasets = [];

        for(el in graph_data) {
            datasets.push({
                label: title[el],
                backgroundColor: colors[el].backgroundColor,
                borderColor: colors[el].borderColor,
                data: graph_data[el]['data'],
            });
        }

        // console.log(labels)
        // console.log(datasets)

        const config = {
            type: 'line',
            //data: { datasets },
            datasets: { datasets },
            labels: { labels },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const chart = new Chart(
            ctx,
            config
        );
    }

    function daysInThisMonth() {
        var now = new Date();
        return new Date(now.getFullYear(), now.getMonth()+1, 0).getDate();
    }

</script>

@endsection
