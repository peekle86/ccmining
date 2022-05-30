@extends('layouts.newfront')
@section('content')

    <div class="flex justify-between space-x-2">
        <h1 class="text-2xl font-bold">{{ $hardwareItem->model }}</h1>
    </div>

    <div class="flex flex-col space-y-6">
        <div class="flex flex-col md:flex-row md:space-x-6 space-x-0 md:space-y-0 space-y-10">

            <div class="flex-1 bg-white rounded-lg border p-6 shadow space-y-5">
                <img src="{{ $hardwareItem->photo->url ?? '' }}" alt="{{ $hardwareItem->model }}">

                <div>
                    <h2 class="text-2xl mb-1">Description</h2>
                    {{ $hardwareItem->description ?? '' }}
                </div>
            </div>


            <div class="flex-1 bg-white rounded-lg border p-6 shadow space-y-4">
                <h2 class="text-2xl mb-1">My Profit</h2>
                <div>
                    <canvas id="profitabilityHistory" height="34px" width="100%"></canvas>
                </div>
                <div class="pt-6">
                    <table class="table table-striped rentability">
                        <thead>
                            <tr>
                                <th> Period</th>
                                <th class="text-right">/day</th>
                                <th class="text-right">/month</th>
                                <th class="text-right">/year</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-left"><b>Income</b></td>
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
                                <td class="text-left"><b>Electricity</b><span class="hidden-xs"
                                        style="padding-left:8px;" data-toggle="tooltip" data-placement="left"
                                        data-html="true" title=""
                                        data-original-title="You can change the cost of electricity (KWh) used in calculations in the local preferences on the page footer."><span
                                            class="glyphicon glyphicon-info-sign" style="color:#555;"></span></span></td>
                                <td class="text-right" style="color:#A00;">
                                    -${{ number_format($profit['electricity'], 2) }}
                                </td>
                                <td class="text-right" style="color:#A00;">
                                    -${{ number_format($profit['electricity'] * 30, 2) }}</td>
                                <td class="text-right" style="color:#A00;">
                                    -${{ number_format($profit['electricity'] * 365, 2) }}</td>
                            </tr>
                            <tr class="color50">
                                <td class="text-left"><b>Profit</b></td>
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
                    <h2 class="text-2xl mb-1">Algorithms</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Algorythm</th>
                                <th class="hidden-xs hidden-sm">Hashrate</th>
                                <th class="hidden-xs hidden-sm">Consumption</th>
                                <th> <span class="hidden-sm hidden-xs">Profitability</span><span
                                        class="visible-sm visible-xs">/day</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>EtHash</b>
                                    <div class="lg:hidden">{!! App\Http\Controllers\Newfront\FarmController::getUnit($hardwareItem->hashrate) !!} {{ $hardwareItem->power }}W</div>
                                </td>
                                <td class="hidden-xs hidden-sm">{!! App\Http\Controllers\Newfront\FarmController::getUnit($hardwareItem->hashrate) !!}<span
                                        style="color:silver; font-size:0.9em; margin-left:6px;">±5%</span></td>
                                <td class="hidden-xs hidden-sm">{{ $hardwareItem->power }}W<span
                                        style="color:silver; font-size:0.9em; margin-left:6px;">±10% </span></td>
                                </td>
                                <td style="width:160px;">
                                    <div class="rentability">
                                        <div class="hidden-xs" style="float:right; padding:8px;" data-toggle="tooltip"
                                            data-placement="left" data-html="true" title=""
                                            data-original-title="<b>Income : </b><font color=green>$219.60</font><br/><b>Electricity :</b> <font color=red>-$7.36</font>">
                                            <span class="glyphicon glyphicon-info-sign" style="color:#555;"></span></div>
                                        <div class="rentabilitylabel color50"><span> ${{ number_format($profit['income'], 2) }}</span><span
                                                class="hidden-xs"
                                                style="font-size:0.8em;margin-left:4px; font-weight:400;">/day</span></div>
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
                    <h2 class="text-2xl mb-1">Specifications</h2>
                    <div>
                        {!! $hardwareItem->specification ?? '' !!}
                    </div>
                </div>
            </div>

            <div class="flex-1 minable-coins">

                <div class="bg-white rounded-lg border p-6 shadow space-y-4">
                    <h2 class="text-2xl mb-1">Minable coins</h2>
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

    <script>
        function cartForm() {
            return {
                cart: false,
                submitData(hard_id) {
                    fetch('{{ route("newfront.cart.add") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ hard_id })
                    })
                    .then(() => {
                        this.cart = true;
                        console.log('Form sucessfully submitted!');
                    })
                    .catch(() => {
                        console.log('Ooops! Something went wrong!');
                    })
                }
            }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById("profitabilityHistory").getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chart_data['time'] ?? '') !!},
                datasets: [{
                    label: 'Profit',
                    fill: false,
                    lineTension: 0.4,
                    backgroundColor: '#FFF',
                    borderColor: '#0A0',
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: '#0A0',
                    pointBackgroundColor: 'rgba(75,192,192,0.4)',
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#0A0',
                    pointHoverBorderColor: '#0A0',
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: {!! json_encode($chart_data['amount'] ?? '') !!},
                }]
            },
            options: {
                    // legend: {
                    //     display: true
                    // },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                },
            plugins: [{
                beforeDraw: function(c) {
                    var data = c.data.datasets[0].data;
                    for (let i in data) {
                        let line = c.data.datasets[0]._meta['0'].data[i]._model;
                        if (data[i] < 0) {
                        line.backgroundColor = '#E82020';
                        line.borderColor = '#E82020';
                        }
                    }
                }
            }]
        });
    </script>
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

    </style>
@endsection
