@inject('helpers', 'App\Http\Helpers\CartHelper' )

@extends('layouts.newfront')

@section('content')

    <div class="flex justify-between space-x-2">
        <h1 class="text-2xl font-bold">{{ __('checkout.checkout_title') }}</h1>

        <a href="{{ route('newfront.cart') }}"
           class="uppercase mx-auto py-2 px-4 border-2 text-blue-500 border-blue-400 hover:text-blue-400 hover:border-blue-300 rounded items-center flex space-x-1 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                      clip-rule="evenodd"/>
            </svg>
            <span>{{ __('cart.back') }}</span>
        </a>
    </div>
    @foreach ($checkouts as $checkout)
        <div class="bg-white space-y-3 border border-blue-100 p-8 rounded-lg">
            <div class="flex space-x-4 items-center">
                @if($checkout->status == 1)
                    <div class="text-green-500 bg-green-100 inline-block py-2 px-5 font-bold">Aproved</div>
                @else
                    <div class="text-yellow-500 bg-yellow-100 inline-block py-2 px-5 font-bold">Pending</div>
                @endif

                @if($checkout->tx)
                    <div>txid: <a href="https://www.blockchain.com/btc/tx/{{ $checkout->tx }}"
                                  target="_blank">{{ $checkout->tx }}</a></div>
                @endif
            </div>

            <div>
                <div class="pb-10">
                    <div class="flex flex-col space-y-5">

                        <div class="text-center">
                            <div class="font-bold">{{ __('checkout.amount_in') }} USD</div>
                            <div>
                                ${{ number_format($total[$checkout->id], 2) }}
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="font-bold">BTC {{ __('checkout.address') }} </div>
                            <div>
                                <input type="text" value="{{ auth()->user()->userWallet->address ?? '' }}" readonly
                                       class="block p-2 shadow-sm border rounded-lg text-center w-full"/>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="font-bold">{{ __('checkout.amount_in') }} BTC</div>
                            <div>
                                <input type="text"
                                       value="{{ number_format($total[$checkout->id] / $checkout->btc_price, 8) }}"
                                       readonly class="block p-2 shadow-sm border rounded-lg text-center w-full"/>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <tr id="hard_{{ $key }}">
                                    <td class="px-2 py-4">
                                        <div class="text-sm text-center text-blue-600">
                                            @if($hard->pivot->amount > 0)
                                                <a href="{{ route('newfront.farm') }}">{{ $hard->model }} {{ \App\Services\ContractService::getContractStatus($hard->pivot->amount) }}</a>
                                            @else
                                                <a href="{{ $hard->url }}">{{ $hard->model }} {{ \App\Services\ContractService::getContractStatus($hard->pivot->price) }}</a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="{{ $Farm::getColor($hard->profit) }} px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                            $<span>
                                                @if( $hard->algoritm_id == 5 )
                                                    {{ $helpers->calcPercent($hard->profit / 360 * $hard->pivot->price / 100, $hard->pivot->percent, 2) }}
                                                @else
                                                    {{ $helpers->calcPercent($hard->profit, $hard->pivot->percent, 2) }}
                                                @endif
                                            </span>/day
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        $<span>{{ $hard->pivot->price }}</span>
                                    </td>
                                    <td class="relative px-6 whitespace-nowrap text-sm text-center">
                                        {{ $periods->find($hard->pivot->period_id)->period }} days
                                    </td>
                                    <td class="relative px-6 whitespace-nowrap text-sm text-center">
                                        {{ $currencies->find($hard->pivot->currency_id)->symbol }}
                                    </td>
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
                                <tr id="hard_{{ $key }}">
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-center text-blue-600">
                                            @if($hard->algoritm_id == 5)
                                                <a href="{{ route('newfront.farm') }}">{{ $hard->model }}</a>
                                            @else
                                                <a href="{{ $hard->url }}">{{ $hard->model }}</a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="text-sm text-center text-gray-900">
                                            <span>{!! $helpers->getUnit($helpers->calcPercent($hard->hashrate, $hard->pivot->percent)) !!}</span>
                                            <small x-text="unit" class="text-gray-500 ml-0.5"></small>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                        <span x-text="power">{{ $hard->power ? $helpers->calcPercent($hard->power, $hard->pivot->percent) : '-' }}</span>
                                            <small class="text-gray-500 ml-0.5">W</small></div>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $hard->algoritm->algoritm }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="{{ $Farm::getColor($hard->profit) }}
                                        px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        $<span>
                                            @if( $hard->algoritm_id == 5 )
                                                {{ $helpers->calcPercent($hard->profit / 360 * $hard->pivot->price / 100, $hard->pivot->percent, 2) }}
                                            @else
                                                {{ $helpers->calcPercent($hard->profit, $hard->pivot->percent, 2) }}
                                            @endif
                                        </span>/day
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        $<span>{{ $hard->pivot->price }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        {{ $hard->pivot->percent }}%
                                    </td>
                                    <td class="relative px-6 whitespace-nowrap text-sm">
                                        {{ $periods->find($hard->pivot->period_id)->period }} {{ __('dashboard._days') }}
                                    </td>
                                    <td class="relative px-6 whitespace-nowrap text-sm text-center">
                                        {{ $currencies->find($hard->pivot->currency_id)->symbol }}
                                    </td>
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
        </div>
    @endforeach

    <div>
        {{ $checkouts->links() }}
    </div>

@endsection
