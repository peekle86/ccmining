@include('partials.header')
    @php
        // Session::put('chat_token', );
        $all_data = request()->session()->all();
        // dump( $all_data );
    @endphp
    <div class="main-bg mt-20  text-white">
        <div>
        <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center pt-5">
            <!--Left Col-->
            <div class="flex flex-col w-full md:w-3/5 justify-center items-start text-center md:text-left">
            <h1 class="mb-4 text-5xl leading-tight text-white">
                <span class="main-color">CLOUD MINING</span> PLATFORM
            </h1>
            <p class="leading-normal text-lg mb-8 mt-4 text-gray-300">
                {{ __('welcome.slider_desc') }}
            </p>
            <a href="#" onclick="toggleModal('calc_modal');return false;" class="mx-auto md:ml-0 btn action-btn">
                {{ __('welcome.calc') }}
            </a>
            </div>
            <!--Right Col-->
            <div class="w-full md:w-2/5 text-center md:text-right pt-5">
                <img src="/img/main_slider.png" class="inline-block" alt="">
            </div>
        </div>
        </div>

        <div class="container mx-auto px-3 pt-5 pb-20">
            <div class="flex flex-col md:flex-row border after_slider rounded">
                <div class="flex-1 pb-6 pt-6 px-10 space-y-2 border-b md:border-b-0 md:border-r">
                    <div class="sum pb-2">250$</div>
                    <div class="title">{{ __('welcome.min_dep') }}</div>
                    <div class="desc">{{ __('welcome.min_dep_desc') }}</div>
                </div>

                <div class="flex-1 pb-6 pt-6 px-10 space-y-2 border-b md:border-b-0 md:border-r">
                    <div class="sum pb-2">130%</div>
                    <div class="title">{{ __('welcome.avg_inc') }}</div>
                    <div class="desc">{{ __('welcome.avg_inc_desc') }}</div>
                </div>

                <div class="flex-1 pb-6 pt-6 px-10 space-y-2">
                    <div class="sum pb-2">24/7</div>
                    <div class="title">{{ __('welcome.f_payd') }}</div>
                    <div class="desc">{{ __('welcome.f_payd_desc') }}</div>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-white py-20">
      <div class="container mx-auto px-3 my-12 space-y-6">
        <h2 class="w-full my-2 text-center">
            {{ __('welcome.how_do') }}
        </h2>

        <div class="flex flex-col md:flex-row start">
            <div class="flex-1">
                <div>
                    <img class="inline-block" src="/img/how_1.svg" alt="">
                </div>
                <div class="title">{{ __('welcome.reg_acc') }}</div>
                <div class="desc">{{ __('welcome.reg_acc_desc') }}</div>
            </div>
            <div class="flex-1">
                <img src="/img/arrow.svg" class="inline-block" alt="">
            </div>

            <div class="flex-1">
                <div>
                    <img class="inline-block" src="/img/how_2.svg" alt="">
                </div>
                <div class="title">{{ __('welcome.start_min') }}</div>
                <div class="desc">{{ __('welcome.start_min_desc') }}</div>
            </div>
            <div class="flex-1">
                <img src="/img/arrow.svg" class="inline-block" alt="">
            </div>

            <div class="flex-1">
                <div>
                    <img class="inline-block" src="/img/how_3.svg" alt="">
                </div>
                <div class="title">{{ __('welcome.rec_money') }}</div>
                <div class="desc">{{ __('welcome.rec_money_desc') }}</div>
            </div>
        </div>
      </div>
    </section>

    <section class="pb-12 bg-white flex flex-col space-y-5 px-3 ">
        <div class="flex flex-col md:flex-row blue-section p-8 md:p-16 container mx-auto space-y-10 md:space-y-0 md:space-x-10">
            <div class="flex-1">
                <h2>{{ __('welcome.w_i_bit') }}</h2>
                <p>{{ __('welcome.w_i_bit_desc') }}</p>
            </div>
            <div class="flex-1 text-center">
                <img src="/img/what_btc.png" class="inline-block" alt="">
            </div>
        </div>

        <div class="flex flex-col md:flex-row blue-section p-8 md:p-16 container mx-auto space-y-10 md:space-y-0 md:space-x-10">
            <div class="flex-1 text-center">
                <img src="/img/what_cloud.png" class="inline-block" alt="">
            </div>

            <div class="flex-1">
                <h2>{{ __('welcome.w_i_cloud') }}</h2>
                <p>{{ __('welcome.w_i_cloud_desc') }}</p>
            </div>
        </div>
    </section>

    <section class="py-12 bg-white mb-20 px-3 ">
        <h2 class="w-full my-8 text-center">
            {{ __('welcome.w_w_offer') }}
        </h2>
        <div class="container mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <div class="blue-section py-5 px-3 md:p-10 space-x-10">
                    <div>
                        <h3>{{ __('welcome.w_w_offer_1') }}</h3>

                        <p>{{ __('welcome.w_w_offer_1_d') }}</p>
                    </div>
                </div>

                <div class="blue-section py-5 px-3 md:p-10 space-x-10">
                    <div>
                        <h3>{{ __('welcome.w_w_offer_2') }}</h3>

                        <p>{{ __('welcome.w_w_offer_2_d') }}</p>
                        <div class="flex space-x-1 pt-2.5 overflow-x-auto text-white">
                            <a href="#" class="text-white no-underline hover:opacity-80 blue-bg py-1 pr-2 pl-1 flex-auto flex items-center space-x-1">
                                <img src="/img/eth.svg" alt="">
                                <div class="">Ethereum</div>
                            </a>

                            <a href="#" class="text-white no-underline hover:opacity-80 blue-bg py-1 pr-2 pl-1 flex-auto flex items-center space-x-1">
                                <img src="/img/lt.svg" alt="">
                                <div class="">Litecoin</div>
                            </a>

                            <a href="#" class="text-white no-underline hover:opacity-80 blue-bg py-1 pr-2 pl-1 flex-auto flex items-center space-x-1">
                                <img src="/img/monero.svg" alt="">
                                <div class="">Monero</div>
                            </a>

                            <a href="#" class="text-white no-underline hover:opacity-80 blue-bg py-1 pr-2 pl-1 flex-auto flex items-center space-x-1">
                                <img src="/img/zcash.svg" alt="">
                                <div class="">Zcash</div>
                            </a>

                            <a href="#" class="text-white no-underline hover:opacity-80 blue-bg py-1 pr-2 pl-1 flex-auto flex items-center space-x-1">
                                <img src="/img/btc.svg" alt="">
                                <div class="">Bitcoin</div>
                            </a>

                            <a href="#" class="text-white no-underline hover:opacity-80 blue-bg py-1 pr-2 pl-1 flex-auto flex items-center space-x-1">
                                <img src="/img/bch.svg" alt="">
                                <div class="">BCH</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 main-bg px-3 mb-8">
        <div class="container mx-auto py-14">
            <div class="grid  md:grid-cols-2 gap-4 grid-cols-1">
                <div>
                    <h2 class="text-white">{{ __('welcome.w_choos') }}</h2>

                    <p class="text-gray-300">{{ __('welcome.w_choos_d') }}</p>
                    <div class="flex space-x-5 pt-6">
                        <img src="/img/pic.png" style="" alt="">
                        <img src="/img/txt.png" alt="">
                    </div>
                </div>
                <div class="text-center">
                    <img src="/img/what_btc.png" class="inline-block" alt="">
                </div>
            </div>
        </div>
    </section>

    @include('partials.startNow')


    @if( $reviews->count() )

        <section class="py-8 bg-white mb-20 px-3 ">
            <h2 class="w-full my-2 text-center">
                {{ __('welcome.w_c_say') }}
            </h2>
            <div class="container mx-auto py-5">
                <div class="carousel">
                    <div class="carousel-inner">
                        @foreach ($reviews as $review)
                            <input class="carousel-open" type="radio" id="carousel-{{ $loop->iteration }}" name="carousel" aria-hidden="true" hidden="" @if( $loop->first ) checked="checked" @endif>
                            <div class="blue-section py-5 px-3 md:p-10 relative carousel-item">
                                <div class="absolute top-4 right-4">
                                    <img src="/img/quate.svg" alt="">
                                </div>
                                <div>
                                    <h3>{{ $review->title }}</h3>
                                    <p>{{ $review->review }}</p>
                                </div>
                            </div>
                            <label for="carousel-{{ $loop->first ? $loop->count : $loop->iteration - 1 }}" class="carousel-control prev control-{{ $loop->iteration }}">‹</label>
                            <label for="carousel-{{ $loop->last ? 1 : $loop->iteration + 1 }}" class="carousel-control next control-{{ $loop->iteration }}">›</label>
                        @endforeach

                        <ol class="carousel-indicators">
                        @foreach ($reviews as $review)
                            <li>
                                <label for="carousel-{{ $loop->iteration }}" class="carousel-bullet">•</label>
                            </li>
                        @endforeach
                        </ol>


                        {{-- <input class="carousel-open" type="radio" id="carousel-2" name="carousel" aria-hidden="true" hidden="">
                        <div class="blue-section py-5 px-3 md:p-10 relative carousel-item">
                            <div class="absolute top-4 right-4">
                                <img src="/img/quate.svg" alt="">
                            </div>
                            <div>
                                <h3>2) This is great, I advise everyone</h3>
                                <p>CCG Mining is a professional team that is doing everything in its power to make the tagline " We make it easy for you " available to anyone, regardless of where they live, knowledge about cryptocurrencies, and the </p>
                            </div>
                        </div>
                        <label for="carousel-1" class="carousel-control prev control-2">‹</label>
                        <label for="carousel-3" class="carousel-control next control-2">›</label>

                        <input class="carousel-open" type="radio" id="carousel-3" name="carousel" aria-hidden="true" hidden="">
                        <div class="blue-section py-5 px-3 md:p-10 relative carousel-item">
                            <div class="absolute top-4 right-4">
                                <img src="/img/quate.svg" alt="">
                            </div>
                            <div>
                                <h3>3) This is great, I advise everyone</h3>
                                <p>CCG Mining is a professional team that is doing everything in its power to make the tagline " We make it easy for you " available to anyone, regardless of where they live, knowledge about cryptocurrencies, and the </p>
                            </div>
                        </div>
                        <label for="carousel-2" class="carousel-control prev control-3">‹</label>
                        <label for="carousel-1" class="carousel-control next control-3">›</label>

                        <ol class="carousel-indicators">
                            <li>
                                <label for="carousel-1" class="carousel-bullet">•</label>
                            </li>
                            <li>
                                <label for="carousel-2" class="carousel-bullet">•</label>
                            </li>
                            <li>
                                <label for="carousel-3" class="carousel-bullet">•</label>
                            </li>
                        </ol> --}}
                    </div>
                </div>

            </div>
        </section>
    @endif





@include('partials.footer')
