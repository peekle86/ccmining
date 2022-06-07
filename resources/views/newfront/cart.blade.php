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
    @include('layouts.includes.messages')
    <div class="flex space-x-5 cart_payments_block">

        <div class="flex-1">
            <div class="col-4 mb-4">
                <div class="d-flex justify-content-center align-items-center">
                    <button type="button"
                            class="payment border-2 text-blue-500 border-blue-400 hover:text-blue-400 hover:border-blue-300 text-white block text-center w-full rounded-lg payment_block"
                            data-payment="{{ \App\Models\PaymentSystem::BTC }}"
                            style="height: 60px">
                        <svg width="158" height="56" viewBox="0 0 158 56" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M39.4556 31.9947C37.5537 39.3266 29.8261 43.7875 22.1954 41.9588C14.5688 40.1314 9.92456 32.7066 11.8264 25.3761C13.7297 18.0442 21.4559 13.582 29.0866 15.4094C36.716 17.238 41.3588 24.6642 39.457 31.9947H39.4556Z"
                                fill="#F7931A"/>
                            <path
                                d="M28.8093 26.6996C28.37 28.3959 25.6604 27.5333 24.7804 27.3223L25.5567 24.3243C26.4354 24.5353 29.2677 24.9299 28.8093 26.6996ZM28.34 31.546C27.857 33.4166 24.5894 32.4059 23.5307 32.1516L24.3889 28.8351C25.4476 29.0907 28.8448 29.5954 28.34 31.546ZM28.7766 23.2743L29.4178 20.8072L27.8543 20.4323L27.2321 22.8338C26.8215 22.7355 26.3999 22.6437 25.9797 22.552L26.6073 20.1334L25.0451 19.7598L24.4052 22.2256C24.0642 22.1508 23.7313 22.0774 23.4079 22.0001V21.9922L21.2536 21.477L20.8389 23.0803C20.8389 23.0803 21.9986 23.3359 21.974 23.3516C22.6057 23.5037 22.7203 23.9061 22.7012 24.2247L21.9726 27.0352C22.0163 27.0457 22.0722 27.0614 22.135 27.085L21.9699 27.0457L20.948 30.9823C20.8703 31.1658 20.6752 31.4437 20.2317 31.3389C20.2468 31.3598 19.0966 31.0662 19.0966 31.0662L18.3203 32.7835L20.3532 33.2711C20.7325 33.3629 21.1036 33.4586 21.4678 33.5477L20.8211 36.0423L22.3819 36.4172L23.0232 33.9488C23.4488 34.0603 23.8622 34.1625 24.2674 34.2595L23.6289 36.7161L25.1925 37.0897L25.8392 34.599C28.5037 35.0841 30.5065 34.8887 31.3511 32.5737C32.0305 30.7083 31.317 29.6334 29.9144 28.9321C30.9363 28.7053 31.7044 28.0603 31.9104 26.7271C32.1929 24.9063 30.7508 23.9284 28.7779 23.2756L28.7766 23.2743Z"
                                fill="white"/>
                            <path
                                d="M48.4474 38.1018H47.8007C47.5405 38.1026 47.2809 38.0784 47.0257 38.0297C46.9001 38.0047 46.7741 37.9815 46.6478 37.9603L49.0245 28.472C49.4611 28.105 49.9454 27.8612 50.487 27.7432C51.0273 27.6317 51.4625 27.5701 51.8009 27.5701C52.8337 27.5701 53.5445 27.8834 53.9293 28.5048C54.3113 29.1301 54.505 29.994 54.505 31.103C54.505 32.0049 54.3481 32.8714 54.0357 33.7025C53.7374 34.5083 53.3057 35.2626 52.7573 35.9362C52.2324 36.5828 51.5754 37.1195 50.8268 37.5132C50.0986 37.9007 49.2797 38.1032 48.4474 38.1018ZM53.1325 23.2757C52.6108 23.2729 52.0908 23.3315 51.584 23.45C51.1037 23.568 50.6221 23.7279 50.1432 23.935L52.3766 15L46.7897 15.8311L40.5547 41.0094C41.264 41.3376 42.0077 41.5925 42.7731 41.7697C43.5521 41.9558 44.2916 42.0948 44.9901 42.1892C45.6846 42.2783 46.304 42.3321 46.8443 42.3426C47.3832 42.3531 47.7652 42.3596 47.9821 42.3596C49.6616 42.3596 51.2265 42.0529 52.6659 41.442C54.0725 40.8537 55.3461 40.0072 56.4151 38.95C57.4871 37.878 58.3372 36.6199 58.92 35.2428C59.5357 33.8097 59.8479 32.2731 59.8382 30.7228C59.8382 29.6846 59.7058 28.7159 59.4425 27.8126C59.2007 26.9581 58.7852 26.1579 58.2201 25.4583C57.6546 24.7828 56.9385 24.2381 56.1245 23.8642C55.2854 23.4749 54.2881 23.2743 53.1325 23.2743V23.2757Z"
                                fill="black"/>
                            <path
                                d="M69.6664 21.1818C70.5481 20.8279 71.2564 20.1647 71.6474 19.3269C71.852 18.8982 71.953 18.4421 71.953 17.9544C71.953 17.0787 71.6528 16.4246 71.0525 15.9946C70.4724 15.574 69.7642 15.3487 69.0374 15.3536C68.5326 15.3536 68.0578 15.4454 67.6117 15.6289C66.7314 15.9871 66.0234 16.6501 65.6279 17.4864C65.4246 17.9165 65.3208 18.3839 65.3237 18.8563C65.3237 19.7372 65.6225 20.3913 66.2255 20.8161C66.8258 21.2447 67.4998 21.4584 68.2447 21.4584C68.7495 21.4584 69.2216 21.3693 69.6677 21.1818H69.6664ZM70.1889 23.662H64.8175L60.3125 41.8834H65.647L70.1889 23.662Z"
                                fill="black"/>
                            <path
                                d="M74.8545 19.1221L80.4415 18.291L79.0703 23.6604H85.0543L83.9738 27.8841H78.0252L76.4426 34.255C76.3045 34.7416 76.2199 35.2407 76.1902 35.7442C76.1629 36.207 76.2257 36.6055 76.3689 36.9398C76.5122 37.2753 76.7701 37.5349 77.1439 37.7171C77.5164 37.9033 78.0484 37.9976 78.7483 37.9976C79.3227 37.9976 79.8835 37.9452 80.4265 37.8403C80.9822 37.7338 81.5294 37.5892 82.0637 37.4077L82.4621 41.3575C81.7403 41.6118 80.9613 41.8294 80.1195 42.0129C79.2763 42.2004 78.279 42.2895 77.1261 42.2895C75.4685 42.2895 74.1846 42.0535 73.2692 41.5816C72.3551 41.1097 71.7084 40.4608 71.3209 39.6415C70.9389 38.8235 70.7697 37.881 70.8161 36.8205C70.8666 35.756 71.0344 34.6378 71.3209 33.4593L74.8545 19.1221Z"
                                fill="black"/>
                            <path
                                d="M84.8165 34.5989C84.8165 33.0298 85.0811 31.5498 85.6091 30.1655C86.1115 28.8212 86.8838 27.5848 87.8821 26.5265C88.8866 25.4756 90.1089 24.6383 91.4703 24.0686C92.8715 23.4695 94.4418 23.168 96.1718 23.168C97.2537 23.168 98.221 23.2663 99.0724 23.4629C99.874 23.6434 100.654 23.9044 101.399 24.2416L99.5595 28.2621C99.0693 28.0728 98.5703 27.9053 98.0641 27.76C97.5471 27.6066 96.9181 27.5332 96.1718 27.5332C94.3914 27.5332 92.9834 28.1231 91.9356 29.299C90.8918 30.4749 90.3666 32.0584 90.3666 34.0444C90.3666 35.2216 90.6312 36.1733 91.1606 36.9022C91.6886 37.631 92.6641 37.9928 94.0803 37.9928C94.7788 37.9928 95.4528 37.922 96.0995 37.7857C96.6914 37.6636 97.2705 37.4899 97.8295 37.2666L98.2279 41.3867C97.5539 41.6384 96.809 41.8652 95.9931 42.0645C95.1745 42.2572 94.2017 42.3568 93.0734 42.3568C91.5822 42.3568 90.3202 42.147 89.2874 41.7341C88.2559 41.3146 87.4019 40.7588 86.7306 40.0536C86.0546 39.3449 85.5553 38.4976 85.2708 37.576C84.9665 36.6108 84.8134 35.6074 84.8165 34.5989Z"
                                fill="black"/>
                            <path
                                d="M113.252 28.5033C113.636 29.1496 113.828 30.0515 113.828 31.2037C113.828 31.9195 113.726 32.6772 113.525 33.4716C113.331 34.2435 113.021 34.9844 112.606 35.6712C112.196 36.3411 111.693 36.8956 111.097 37.3335C110.496 37.7739 109.803 37.9928 109.012 37.9928C108.005 37.9928 107.312 37.669 106.927 37.0241C106.545 36.3765 106.353 35.4772 106.353 34.321C106.353 33.604 106.452 32.8502 106.656 32.0532C106.862 31.2575 107.166 30.5247 107.575 29.8535C107.982 29.185 108.485 28.6305 109.084 28.19C109.682 27.7539 110.415 27.5231 111.166 27.5345C112.173 27.5345 112.869 27.8583 113.252 28.502V28.5033ZM108.51 42.3568C110.264 42.3568 111.81 42.0029 113.142 41.2989C114.438 40.626 115.574 39.7004 116.476 38.5814C117.373 37.4593 118.057 36.1986 118.495 34.8428C118.948 33.4545 119.178 32.0676 119.178 30.6846C119.178 29.5769 119.022 28.5649 118.708 27.6551C118.419 26.7823 117.948 25.9751 117.323 25.2824C116.68 24.5943 115.878 24.0605 114.981 23.7238C114.03 23.3554 112.93 23.168 111.679 23.168C109.977 23.168 108.459 23.5219 107.14 24.2232C105.846 24.9072 104.707 25.8329 103.791 26.946C102.87 28.0614 102.167 29.3282 101.717 30.6846C101.256 32.0263 101.019 33.4298 101.016 34.8428C101.016 35.9492 101.166 36.9585 101.482 37.8709C101.796 38.7833 102.256 39.5751 102.87 40.2436C103.482 40.9135 104.257 41.4313 105.198 41.801C106.131 42.1693 107.237 42.3568 108.51 42.3568Z"
                                fill="black"/>
                            <path
                                d="M127.587 21.4571C128.095 21.4571 128.57 21.3693 129.017 21.1818C129.461 20.9957 129.851 20.7493 130.191 20.4373C130.526 20.1226 130.798 19.7556 131.001 19.3269C131.203 18.8983 131.311 18.4421 131.311 17.9544C131.311 17.0788 131.006 16.4246 130.405 15.9946C129.822 15.5732 129.111 15.3479 128.381 15.3536C127.877 15.3536 127.401 15.4454 126.957 15.6289C126.523 15.8092 126.126 16.0622 125.784 16.3761C125.445 16.6907 125.173 17.0578 124.969 17.4878C124.765 17.9164 124.662 18.3713 124.662 18.8563C124.662 19.7372 124.964 20.3914 125.566 20.8161C126.166 21.2448 126.841 21.4584 127.587 21.4584V21.4571ZM124.99 41.8821L129.528 23.6621H124.153L119.648 41.8834L124.99 41.8821Z"
                                fill="black"/>
                            <path
                                d="M133.372 24.4945C133.776 24.3804 134.229 24.2454 134.72 24.096C135.931 23.7409 137.175 23.4977 138.434 23.3697C139.29 23.2826 140.15 23.2414 141.01 23.2465C143.823 23.2465 145.763 24.033 146.834 25.6035C147.904 27.1739 148.089 29.3225 147.394 32.0452L144.94 41.8808H139.57L141.949 32.2523C142.094 31.6506 142.208 31.0699 142.292 30.5023C142.377 29.9386 142.373 29.4431 142.273 29.0131C142.186 28.6021 141.95 28.234 141.607 27.9736C141.255 27.7088 140.725 27.5751 140.003 27.5751C139.307 27.5751 138.599 27.6472 137.877 27.7848L134.381 41.8795H129.008L133.372 24.4945Z"
                                fill="black"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="flex-1">
            <div class="col-4 mb-4">
                <div class="d-flex justify-content-center align-items-center">
                    <button type="button"
                            class="payment border-2 text-blue-500 border-blue-400 hover:text-blue-400 hover:border-blue-300 text-white block text-center w-full rounded-lg payment_block"
                            data-payment="{{ \App\Models\PaymentSystem::USDT }}"
                            style="height: 60px">
                        <img width="158" height="56" src="{{ asset('images/tether_trx.png') }}">
                    </button>
                </div>
            </div>
        </div>

        @if(app()->getLocale() == 'ru')
            <div class="flex-1">
                <div class="col-4 mb-4">
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="button"
                                class="payment border-2 text-blue-500 border-blue-400 hover:text-blue-400 hover:border-blue-300 text-white block text-center w-full rounded-lg payment_block"
                                data-payment="{{ \App\Models\PaymentSystem::QIWI }}"
                                style="height: 60px">
                            <svg width="158" height="56" viewBox="0 0 150 50" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M52.7861 42.0291C56.0245 42.0291 59.5378 43.1299 63.4276 46.5464C63.8173 46.8884 64.3361 46.4633 63.9954 46.0381C60.1737 41.2537 56.6389 40.3429 53.1137 39.5734C48.8007 38.6305 46.5832 36.2246 45.0375 33.5836C44.7303 33.0588 44.5917 33.1514 44.5642 33.8271C44.5295 34.6524 44.5881 35.7461 44.7746 36.8219C44.6 36.8291 44.4255 36.8279 44.2486 36.8279C38.0803 36.8279 33.0787 31.8689 33.0787 25.7521C33.0787 19.6364 38.0803 14.6786 44.2498 14.6786C50.418 14.6786 55.4196 19.6364 55.4196 25.7521C55.4196 26.1879 55.3981 26.6189 55.3479 27.0405C54.5326 26.8944 52.9272 26.8778 51.8011 26.974C51.378 27.0108 51.4377 27.2068 51.7581 27.2638C55.4507 27.9252 57.9861 30.1945 58.5671 34.3116C58.5791 34.4066 58.7058 34.4339 58.7548 34.3519C60.3249 31.7549 61.1519 28.7815 61.1468 25.7521C61.1468 16.5014 53.5811 9 44.2498 9C34.9173 9 27.3516 16.5003 27.3516 25.7521C27.3516 35.0051 34.9173 42.5065 44.2498 42.5065C46.7243 42.5065 49.182 42.0291 52.7861 42.0291ZM54.0437 35.9468C54.7956 36.5761 55.0239 37.3254 54.6271 37.8539C54.4059 38.1436 54.0473 38.3039 53.6169 38.3039C53.1971 38.304 52.7906 38.1578 52.4682 37.8907C51.7844 37.2981 51.5836 36.3386 52.0294 35.7936C52.204 35.5798 52.4873 35.4623 52.8268 35.4623C53.2392 35.4623 53.6719 35.6344 54.0437 35.9468ZM57.5128 34.346C57.6227 35.0799 57.3896 35.3839 57.1541 35.3839C56.8971 35.3839 56.5756 35.087 56.1966 34.4992C55.8213 33.9197 55.6838 33.2547 55.8703 32.9186C55.9922 32.6966 56.2492 32.5992 56.5732 32.7215C57.2008 32.9554 57.4458 33.9078 57.5128 34.346ZM80.9355 30.5104L78.987 28.1864C78.9413 28.1317 78.9122 28.0651 78.9033 27.9944C78.8943 27.9238 78.9059 27.8522 78.9365 27.7878C78.9671 27.7235 79.0156 27.6692 79.0762 27.6313C79.1368 27.5933 79.207 27.5734 79.2786 27.5737H83.3538C83.5474 27.0013 83.6574 26.3898 83.6574 25.7533C83.6574 22.8439 81.4722 20.3347 78.4741 20.3347C75.4761 20.3347 73.2909 22.8439 73.2909 25.7533C73.2909 28.6626 75.4761 31.1374 78.4741 31.1374C79.3826 31.1374 80.2146 30.907 80.9367 30.5092L80.9355 30.5104ZM89.7504 34.4351C89.962 34.6678 89.7886 35.0407 89.4694 35.0407H85.0225C84.9332 35.0408 84.8449 35.0214 84.7639 34.9838C84.6829 34.9463 84.6113 34.8915 84.554 34.8234L83.8008 33.9244C82.2148 34.9462 80.3645 35.4891 78.4741 35.4872C73.0602 35.4872 68.6563 31.1208 68.6563 25.7533C68.6563 20.3858 73.0602 16.0198 78.4741 16.0198C83.8881 16.0198 88.292 20.3858 88.292 25.7533C88.292 27.6889 87.7182 29.4915 86.732 31.0091L89.7504 34.4351ZM130.835 16.4694H127.205C127.077 16.4697 126.955 16.5202 126.864 16.6099C126.774 16.6996 126.723 16.8211 126.723 16.9479V34.5621C126.723 34.8269 126.938 35.0407 127.205 35.0407H130.835C131.102 35.0407 131.318 34.8269 131.318 34.5621V16.9468C131.318 16.8195 131.267 16.6975 131.177 16.6075C131.086 16.5175 130.963 16.467 130.835 16.467V16.4694ZM124.727 16.4694H120.667C120.564 16.469 120.463 16.5014 120.38 16.5619C120.297 16.6223 120.235 16.7077 120.204 16.8054L116.991 27.2151L113.459 16.7936C113.426 16.6985 113.365 16.6159 113.283 16.5575C113.201 16.4991 113.102 16.4679 113.001 16.4682H110.168C110.067 16.4678 109.968 16.499 109.886 16.5574C109.803 16.6158 109.741 16.6984 109.709 16.7936L106.178 27.2151L102.964 16.8054C102.934 16.7075 102.872 16.6219 102.789 16.5612C102.706 16.5005 102.605 16.4679 102.502 16.4682H98.4409C98.3647 16.4683 98.2895 16.4864 98.2216 16.5208C98.1536 16.5553 98.0949 16.6052 98.05 16.6665C98.0053 16.7272 97.9758 16.7978 97.9641 16.8722C97.9525 16.9465 97.959 17.0226 97.9831 17.094L103.948 34.7177C104.014 34.9124 104.199 35.0431 104.406 35.0431H107.629C107.837 35.0431 108.021 34.9124 108.087 34.7189L111.584 24.4221L115.081 34.7177C115.147 34.9124 115.332 35.0431 115.539 35.0431H118.763C118.971 35.0431 119.155 34.9124 119.221 34.7177L125.186 17.094C125.21 17.0227 125.216 16.9467 125.205 16.8723C125.198 16.798 125.164 16.7274 125.12 16.6665C125.075 16.6051 125.016 16.5551 124.948 16.5207C124.88 16.4862 124.804 16.4682 124.728 16.4682L124.727 16.4694ZM96.4458 16.9479V34.5621C96.4458 34.8269 96.2306 35.0407 95.9629 35.0407H92.3336C92.2057 35.0407 92.0831 34.9903 91.9926 34.9006C91.902 34.8109 91.851 34.6892 91.8507 34.5621V16.9468C91.8507 16.6819 92.0659 16.467 92.3336 16.467H95.9629C96.2294 16.467 96.4458 16.6808 96.4458 16.9468V16.9479Z"
                                      fill="#FF8C00"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <div class=" d-flex justify-content-center align-items-center">
                    <button type="button"
                            class="payment border-2 text-blue-500 border-blue-400 hover:text-blue-400 hover:border-blue-300 text-white block text-center w-full rounded-lg payment_block"
                            data-payment="{{ \App\Models\PaymentSystem::MASTER_CARD }}"
                            style="height: 60px">
                        <svg width="158" height="56" viewBox="0 0 158 56" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M83.9986 16.0293H78.6469C77.0289 16.0293 75.7844 16.5364 75.0376 18.1846L64.832 41.8929H72.0506C72.0506 41.8929 73.2952 38.7234 73.5441 37.9627C74.2909 37.9627 81.385 37.9627 82.3807 37.9627C82.6296 38.8502 83.2519 41.7662 83.2519 41.7662H89.7237L83.9986 16.0293ZM75.5354 32.6378C76.1577 31.1164 78.2735 25.4112 78.2735 25.4112C78.2735 25.538 78.8958 23.8898 79.1447 23.0023L79.6426 25.2844C79.6426 25.2844 81.0116 31.4968 81.2605 32.7646H75.5354V32.6378Z"
                                fill="#3362AB"/>
                            <path
                                d="M65.326 33.4C65.326 38.7248 60.5966 42.2748 53.2535 42.2748C50.1421 42.2748 47.1551 41.6408 45.5371 40.8801L46.5328 35.0481L47.404 35.4285C49.6442 36.4427 51.1377 36.8231 53.8758 36.8231C55.8672 36.8231 57.983 36.0624 57.983 34.2874C57.983 33.1464 57.1117 32.3857 54.3737 31.1179C51.76 29.8501 48.2752 27.8215 48.2752 24.1448C48.2752 19.0735 53.1291 15.6504 59.9743 15.6504C62.5879 15.6504 64.8282 16.1575 66.1972 16.7914L65.2015 22.3699L64.7037 21.8627C63.4591 21.3556 61.8412 20.8485 59.4765 20.8485C56.8628 20.9753 55.6182 22.1163 55.6182 23.1306C55.6182 24.2716 57.1117 25.1591 59.4765 26.3001C63.4591 28.2019 65.326 30.3572 65.326 33.4Z"
                                fill="#3362AB"/>
                            <path
                                d="M4.5918 16.2845L4.71626 15.7773H15.4197C16.9132 15.7773 18.0333 16.2845 18.4067 17.9326L20.7714 29.3431C18.4067 23.2575 12.9305 18.313 4.5918 16.2845Z"
                                fill="#F9B50B"/>
                            <path
                                d="M35.8294 16.0291L25.0015 41.766H17.6585L11.4355 20.213C15.916 23.129 19.6498 27.6931 21.0188 30.8627L21.7656 33.5251L28.4863 15.9023H35.8294V16.0291Z"
                                fill="#3362AB"/>
                            <path d="M38.6939 15.9023H45.5391L41.1831 41.766H34.3379L38.6939 15.9023Z" fill="#3362AB"/>
                            <g clip-path="url(#clip0_1565_11828)">
                                <path
                                    d="M134.513 16.6653L120.68 16.7129L121.099 42.0375L134.932 41.9899L134.513 16.6653Z"
                                    fill="#FF5F00"/>
                                <path
                                    d="M121.59 29.4262C121.504 24.2753 123.812 19.6986 127.426 16.73C124.698 14.5893 121.278 13.302 117.57 13.3147C108.787 13.3448 101.801 20.5803 101.95 29.4934C102.098 38.4066 109.323 45.5934 118.106 45.5633C121.814 45.5506 125.191 44.2401 127.847 42.0809C124.135 39.1822 121.675 34.577 121.59 29.4262Z"
                                    fill="#EB001B"/>
                                <path
                                    d="M153.662 29.2082C153.81 38.1213 146.824 45.3568 138.041 45.3869C134.334 45.3996 130.914 44.1123 128.186 41.9716C131.844 39.0028 134.107 34.4263 134.022 29.2754C133.936 24.1246 131.477 19.5643 127.764 16.6207C130.421 14.4616 133.798 13.151 137.505 13.1383C146.288 13.1082 153.514 20.3398 153.662 29.2082Z"
                                    fill="#F79E1B"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_1565_11828">
                                    <rect width="53" height="32.5227" fill="white" transform="translate(101 13)"/>
                                </clipPath>
                            </defs>
                        </svg>

                    </button>
                </div>
            </div>

            <div class="flex-1">
                <div class="d-flex justify-content-center align-items-center">
                    <button type="button"
                            class="payment border-2 text-blue-500 border-blue-400 hover:text-blue-400 hover:border-blue-300 text-white block text-center w-full rounded-lg payment_block"
                            data-payment="{{ \App\Models\PaymentSystem::MIR }}"
                            style="height: 60px">
                        <svg width="133" height="45" viewBox="0 0 115 38" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_b_402_2302)">
                                <rect width="133" height="45" rx="2" fill="#0D2655" fill-opacity="0.4"/>
                                <rect x="0.5" y="0.5" width="132" height="44" rx="1.5" stroke="#3B4A69"/>
                            </g>
                            <g clip-path="url(#clip0_402_2302)">
                                <path
                                    d="M95.2359 11.0557H81.4023C82.2082 15.7074 86.6403 20.0854 91.4753 20.0854H102.488C102.623 19.675 102.623 18.9909 102.623 18.5805C102.623 14.476 99.2651 11.0557 95.2359 11.0557Z"
                                    fill="url(#paint0_linear_402_2302)"/>
                                <path
                                    d="M82.6133 20.9092V32.2648H89.3286V26.2449H95.2381C98.4614 26.2449 101.282 23.9191 102.222 20.9092H82.6133Z"
                                    fill="#4FAD50"/>
                                <path
                                    d="M58.9727 11.0557V32.1251H64.8822C64.8822 32.1251 66.3595 32.1251 67.1654 30.6202C71.1946 22.5481 72.4033 20.0854 72.4033 20.0854H73.2092V32.1251H79.9245V11.0557H74.015C74.015 11.0557 72.5376 11.1925 71.7318 12.5606C68.3741 19.5382 66.4938 23.0954 66.4938 23.0954H65.688V11.0557H58.9727Z"
                                    fill="#4FAD50"/>
                                <path
                                    d="M30.7695 32.2633V11.1938H37.4849C37.4849 11.1938 39.3652 11.1938 40.4396 14.2038C43.1257 22.139 43.3944 23.2335 43.3944 23.2335C43.3944 23.2335 43.9316 21.3181 46.3491 14.2038C47.4235 11.1938 49.3038 11.1938 49.3038 11.1938H56.0192V32.2633H49.3038V20.9077H48.498L44.7374 32.2633H41.7827L38.0221 20.9077H37.2163V32.2633H30.7695Z"
                                    fill="#4FAD50"/>
                            </g>
                            <defs>
                                <filter id="filter0_b_402_2302" x="-29" y="-29" width="191" height="103"
                                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feGaussianBlur in="BackgroundImage" stdDeviation="14.5"/>
                                    <feComposite in2="SourceAlpha" operator="in"
                                                 result="effect1_backgroundBlur_402_2302"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_402_2302"
                                             result="shape"/>
                                </filter>
                                <linearGradient id="paint0_linear_402_2302" x1="81.3784" y1="15.6353" x2="102.575"
                                                y2="15.6353" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#27B1E6"/>
                                    <stop offset="1" stop-color="#148ACA"/>
                                </linearGradient>
                                <clipPath id="clip0_402_2302">
                                    <rect width="72" height="29.0323" fill="white" transform="translate(31 8)"/>
                                </clipPath>
                            </defs>
                        </svg>

                    </button>
                </div>
            </div>
        @endif

        <div class="flex-1">
            <div class="d-flex justify-content-center align-items-center">
                <input id="payment_type" type="hidden" name="payment" value="0">
                <button type="button"
                        data-locale="{{ app()->getLocale() }}"
                        data-url="{{ route('newfront.payment_checkout') }}"
                        class="py-3 bg-blue-600 hover:bg-blue-500 text-white block text-center w-full rounded-lg btn_checkout_form"
                        style="height: 60px">
                    <span>{{ __('cart.pay_out') }}</span>
                </button>
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
