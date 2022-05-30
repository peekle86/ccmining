<section class="bg-white pt-6 pb-12 px-3 ">
    <div class="container mx-auto mb-12">
      <h2 class="w-full my-2 text-center uppercase">
        {{ __('welcome.start_now') }}
      </h2>

      <div class="flex start flex-col md:flex-row">
          <div class="flex-1">
              <div>
                  <img class="inline-block" src="{{ asset('/img/start_1.svg') }}" alt="">
              </div>
              <div class="title">{{ __('welcome.start_now_1') }}</div>
              <div class="desc">
                  <a href="/about">{{ __('welcome.start_now_1_d') }} »</a>
              </div>
          </div>
          <div class="">
              <img src="{{ asset('/img/arrow.svg') }}" class="inline-block" alt="">
          </div>

          <div class="flex-1">
              <div>
                  <img class="inline-block" src="{{ asset('/img/start_2.svg') }}" alt="">
              </div>
              <div class="title">{{ __('welcome.start_now_2') }} </div>
              <div class="desc">
                <a href="#" onclick="toggleModal('calc_modal');return false;">{{ __('welcome.start_now_2_d') }} »</a>
              </div>
          </div>
          <div class="">
              <img src="{{ asset('/img/arrow.svg') }}" class="inline-block" alt="">
          </div>

          <div class="flex-1">
              <div>
                  <img class="inline-block" src="{{ asset('/img/start_3.svg') }}" alt="">
              </div>
              <div class="title">{{ __('welcome.start_now_3') }}</div>
              <div class="desc">
                <a href="{{ route('newfront.farm') }}">{{ __('welcome.start_now_3_d') }} »</a>
              </div>
          </div>
      </div>
    </div>
</section>
