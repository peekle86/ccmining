@extends('layouts.newfront')

@section('content')

<div class="flex justify-between">
    <h1 class="text-2xl font-bold">Payout request</h1>

    <div class="space-x-1">
        <a class="border py-2 px-5 rounded-full hover:bg-blue-600 bg-blue-500 text-white" href="{{ route('newfront.withdraw.hisory') }}">Payout history</a>
    </div>
</div>

<script>
    function init() {
        return {
            selected: '{{ old( "currency" ) ?? $currencies[0]->id }}'
        }
    }
</script>

<div x-data="init()" class="flex flex-col md:flex-row space-x-0 md:space-x-10 space-y-10 md:space-y-0">
    <div class="md:w-1/3">
        <div class="font-bold text-lg mb-4">Choose a method</div>
        <div class="bg-white rounded-lg border p-6 shadow">
            <div class="text-sm font-bold mb-4">Cryptocurrency</div>

            <ul class="space-y-2">
                @forelse ($currencies as $currency )
                    <li><a href="#" @click.prevent="selected={{ $currency->id }}" :class="selected == {{ $currency->id }} ? 'bg-blue-50' : ''" class="flex space-x-2 items-center whitespace-nowrap p-2 rounded-full">
                        <img class="h-6 w-6" src="{{ asset('storage/icons/crypto/' . $currency->symbol . '.svg') }}" alt="">
                        <span>{{ $currency->name }}</span>
                    </a></li>
                @empty

                @endforelse
            </ul>
        </div>
    </div>

    <div class="md:w-2/3">
        <div class="font-bold text-lg mb-4">Fill in the payment details</div>
        @forelse ($currencies as $currency )
            <form method="POST" action="{{ route('newfront.withdraw.post') }}">
                <input type="hidden" name="currency" value="{{ $currency->id }}">
                @csrf
                <div x-show="selected == {{ $currency->id }}" class="bg-white rounded-lg border p-6 shadow space-y-4">
                    <div>
                        <label for="amount_{{ $currency->id }}" class="block text-sm font-medium text-gray-900">{{ $currency->symbol }} amount</label>
                        <input type="text" placeholder="0.01" name="amount" id="amount_{{ $currency->id }}" autocomplete="amount" class="block py-2 px-5 w-full shadow-sm border rounded-lg" value="{{ old('amount') }}">
                        @error('amount')
                            <div class="error text-sm text-red-600">{{ $message }}</div>
                        @enderror
                        <div class="text-gray-400 text-sm -space-y-1 pt-1">
                            <div>Available for withdrawal: {{ optional(auth()->user()->userBalances())->where('currency_id', $currency->id )->first()->amount ?? 0 }} {{ $currency->symbol }}.</div>
                            <div>Minimum withdrawal amount: {{ $currency->min_withdrawal }} {{ $currency->symbol }}.</div>
                        </div>
                    </div>

                    <div>
                        <label for="address_{{ $currency->id }}" class="block text-sm font-medium text-gray-900">{{ $currency->name }} address</label>
                        <input type="text" name="address" id="address_{{ $currency->id }}" autocomplete="address" value="{{ old('address') }}" class="block py-2 px-5 w-full shadow-sm border rounded-lg">
                        @error('address')
                            <div class="error text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <button class="py-3 bg-blue-600 hover:bg-blue-500 text-white block text-center w-full rounded-lg">Request payment</button>
                    </div>
                </div>
            </form>
        @empty

        @endforelse

    </div>
</div>

@endsection
