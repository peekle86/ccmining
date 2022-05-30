@extends('layouts.newfront')

@section('content')


<h1 class="text-2xl font-bold">Affiliate</h1>


<div class="bg-blue-500 text-white space-y-3 border border-blue-100 px-8 py-8 rounded-lg">
    <div class="font-bold text-2xl">Invite friends and get 8% of their earnings</div>
    <div>Rewards are paid by Kryptex from its own funds. The invited person doesn't lose anything.</div>
    <div class="text-lg font-bold pt-5">Your referral link:</div>
    <input type="text" class="text-blue-500 font-bold py-2 px-4 rounded" value="{{ env('APP_URL', 'http://localhost') }}/?ref={{ auth()->user()->ref }}" readonly>
    <div class="font-bold pt-5">
        {{ $user->referrals()->count() }} referrals / ${{ array_sum($ref_earning) ? number_format(array_sum($ref_earning), 2) : '0.00' }} earned
    </div>
</div>

<div class="bg-white space-y-3 border border-blue-100 p-8 rounded-lg">
    <div class="flex text-center uppercase">
        <div class="text-sm flex-1">
            <div>
                <div class="mb-2 flex items-center justify-center mx-auto w-14 h-14 bg-gray-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="blue">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
            </div>
            <div class="text-gray-500 font-bold">Signed up</div>
            <div class="font-bold text-xl">
                {{ $user->referrals()->count() ?? 0 }}
            </div>
        </div>

        <div class="text-sm flex-1">
            <div>
                <div class="mb-2 flex items-center justify-center mx-auto w-14 h-14 bg-gray-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="blue">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-gray-500 font-bold">Confirmed email</div>
            <div class="font-bold text-xl">
                {{ $user->referrals()->count() ?? 0 }}
            </div>
        </div>

        <div class="text-sm flex-1">
            <div>
                <div class="mb-2 flex items-center justify-center mx-auto w-14 h-14 bg-gray-100 rounded-full">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="blue">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-gray-500 font-bold">Active users</div>
            <div class="font-bold text-xl">
                {{ $user->referrals()->count() ?? 0 }}
            </div>
        </div>
    </div>
</div>

@endsection
