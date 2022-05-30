@extends('layouts.newfront')

@section('content')

<div class="flex justify-between">
    <h1 class="text-2xl font-bold">Payouts</h1>

    <div class="space-x-1">
        <a class="border py-2 px-5 rounded-full hover:bg-blue-600 bg-blue-500 text-white" href="{{ route('newfront.withdraw') }}">Request payment</a>
    </div>
</div>

<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Payout ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Method
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created at
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ( $transactions as $transaction )
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        #{{ $transaction->id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 flex space-x-2">
                                        <img class="h-6 w-6" src="{{ asset('storage/icons/crypto/' . $transaction->currency->symbol . '.svg') }}" alt="">
                                        <div>{{ $transaction->currency->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $transaction->amount }} {{ $transaction->currency->symbol }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->currency->created_at }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($transaction->status == 0) bg-blue-100 text-blue-800 @endif
                                    @if($transaction->status == 1) bg-yellow-100 text-yellow-800 @endif
                                    @if($transaction->status == 2) bg-red-100 text-red-800 @endif
                                    @if($transaction->status == 3) bg-green-100 text-green-800 @endif
                                    ">
                                        {{ $transaction::STATUS_RADIO[$transaction->status] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">empty</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg border p-8 shadow">
    <h2 class="mb-3 text-xl font-bold">Payout status explanation</h2>
    <div class="space-y-2">
        <div class="flex items-center">
            <div class="h-2.5 w-2.5 flex-shrink-0 rounded-full mr-2 bg-blue-500"></div>
            <div>You have to confirm the payout by clicking the link in the confirmation email.</div>
        </div>
        <div class="flex items-center">
            <div class="h-2.5 w-2.5 flex-shrink-0 rounded-full mr-2 bg-yellow-500"></div>
            <div>The request is being processed.</div>
        </div>
        <div class="flex items-center">
            <div class="h-2.5 w-2.5 flex-shrink-0 rounded-full mr-2 bg-green-500"></div>
            <div>The request has been completed successfully.</div>
        </div>
        <div class="flex items-center">
            <div class="h-2.5 w-2.5 flex-shrink-0 rounded-full mr-2 bg-red-500"></div>
            <div>The payout was cancelled due to incorrect payout details or other reasons.</div>
        </div>
    </div>

</div>


@endsection