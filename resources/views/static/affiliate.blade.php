@include('partials.header')
<div class="py-12"></div>

<section class="bg-white py-8">
    <div class="container mx-auto px-3 my-12">
      <h2 class="w-full my-2 text-center">
          {{ __('welcome.o_aff_p') }}
      </h2>

      <div class="flex flex-col lg:flex-row start space-x-7 leading-7">
          <div class="flex-1">
              <div>
                  <img class="inline-block" src="/img/aff_1.svg" alt="">
              </div>
              <div class="title">{{ __('welcome.with_cond') }}</div>
              <div class="desc">{{ __('welcome.just_reg') }}</div>
          </div>


          <div class="flex-1">
              <div>
                  <img class="inline-block" src="/img/start_2.svg" alt="">
              </div>
              <div class="title">{{ __('welcome.att_pay') }}</div>
              <div class="desc">{{ __('welcome.you_w_get') }}</div>
          </div>


          <div class="flex-1">
              <div>
                  <img class="inline-block" src="/img/aff_3.svg" alt="">
              </div>
              <div class="title">{{ __('welcome.inst_pay') }}</div>
              <div class="desc">{{ __('welcome.pay_for_aff') }}</div>
          </div>

          <div class="flex-1">
              <div>
                  <img class="inline-block" src="/img/aff_4.svg" alt="">
              </div>
              <div class="title">{{ __('welcome.no_lim') }}</div>
              <div class="desc">{{ __('welcome.w_unl_ref') }}</div>
          </div>

          <div class="flex-1">
              <div>
                  <img class="inline-block" src="/img/aff_5.svg" alt="">
              </div>
              <div class="title">{{ __('welcome.mult_ling') }} </div>
              <div class="desc">{{ __('welcome.o_w_mult') }}</div>
          </div>
      </div>
    </div>
  </section>

<section class="bg-white">
    <div class="container text-center mx-auto">
        <h3 class="w-full my-2  uppercase">
                <a href="{{ route('register', ['affiliate' => true]) }}" class="btn main-btn">{{ __('welcome.bec_a_part') }}</a>
        </h3>
    </div>
</section>

  <section class="bg-white py-12 px-3 ">
      <div class="container mx-auto my-12">
        <h2 class="w-full my-2 text-center uppercase">
            {{ __('welcome.h_i_work') }}
        </h2>

        <div class="flex start flex-col lg:flex-row items-center">
            <div class="flex-1">
                <div class="desc">
                    {{ __('welcome.activ_y_aff') }}
                </div>
            </div>
            <div class="">
                <img src="/img/arrow.svg" class="inline-block" alt="">
            </div>

            <div class="flex-1">
                <div class="desc">
                    {{ __('welcome.pl_y_ref') }}
                </div>
            </div>
            <div class="">
                <img src="/img/arrow.svg" class="inline-block" alt="">
            </div>

            <div class="flex-1">
                <div class="desc">
                    {{ __('welcome.y_ref_buy') }}
                </div>
            </div>
            <div class="">
              <img src="/img/arrow.svg" class="inline-block" alt="">
          </div>

          <div class="flex-1">
              <div class="desc">
                {{ __('welcome.get_y_rew') }}
              </div>
          </div>
        </div>
      </div>
  </section>

  <section class="py-12 bg-white mb-0 px-3 ">
      <h2 class="w-full my-8 text-center">
        {{ __('welcome.h_bec_part') }}
      </h2>
      <div class="container mx-auto">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div class="blue-section p-10 space-x-10">
                  <div>
                      <h3>{{ __('welcome.use_y_web') }}</h3>
                      <ul class="check-1">
                          <li>{{ __('welcome.post_artic') }}</li>
                          <li>{{ __('welcome.place_banner') }}</li>
                          <li>{{ __('welcome.place_text') }}</li>
                          <li>{{ __('welcome.place_calc') }}</li>
                      </ul>

                  </div>
              </div>

              <div class="blue-section p-10 space-x-10">
                  <div>
                      <h3>{{ __('welcome.use_social') }}</h3>

                      <ul class="check-1">
                          <li>{{ __('welcome.pl_aff_group') }}</li>
                          <li>{{ __('welcome.pl_aff_page') }}</li>
                          <li>{{ __('welcome.comm_them') }}</li>
                          <li>{{ __('welcome.comm_top') }}</li>
                          <li>{{ __('welcome.rec_and_post') }}</li>
                      </ul>
                  </div>
              </div>

              <div class="blue-section p-10 space-x-10">
                  <div>
                      <h3>{{ __('welcome.comm_on_forum') }}</h3>

                      <ul class="check-1">
                          <li>{{ __('welcome.crea_top') }}</li>
                          <li>{{ __('welcome.ans_them') }}</li>
                          <li>{{ __('welcome.send_aff') }}</li>
                      </ul>
                  </div>
              </div>

              <div class="blue-section p-10 space-x-10">
                  <div>
                      <h3>{{ __('welcome.adv_yout') }}</h3>

                      <ul class="check-1">
                          <li>{{ __('welcome.rec_a_pub') }}</li>
                          <li>{{ __('welcome.put_o_off') }}</li>
                      </ul>
                  </div>
              </div>

              <div class="blue-section p-10 space-x-10">
                  <div>
                      <h3>{{ __('welcome.place_off') }}</h3>
                      <p>{{ __('welcome.you_can_leave') }}</p>
                  </div>
              </div>

              <div class="blue-section p-10 space-x-10">
                  <div>
                      <h3>{{ __('welcome.full_toolbox') }}</h3>

                      <div class="flex">
                          <div class="flex-1">
                              <ul class="check-1">
                                  <li>{{ __('welcome._vid') }}</li>
                                  <li>{{ __('welcome.hig_anal') }}</li>
                                  <li>{{ __('welcome.land_pag') }}</li>
                              </ul>
                          </div>
                          <div class="flex-1">
                              <ul class="check-1">
                                  <li>{{ __('welcome._bann') }}</li>
                                  <li>{{ __('welcome._anim') }}</li>
                                  <li>{{ __('welcome.min_calc') }}</li>
                              </ul>
                          </div>
                      </div>
                      <div class="pt-5">
                          <a href="{{ route('register', ['affiliate' => true]) }}" class="btn main-btn">{{ __('welcome.bec_a_part') }} »</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>

  <section class="py-12 bg-white mb-0 px-3 ">
      <h2 class="w-full my-8 text-center">
        {{ __('welcome._tos') }}
      </h2>
      <div class="container mx-auto">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div class="blue-section p-10 space-x-10">
                  <div>
                      <ul class="check-1">
                          <li>{{ __('welcome.pay_under') }}</li>
                          <li>{{ __('welcome.for_evr_usr') }}</li>
                          <li>{{ __('welcome.the_usr_is') }}</li>
                          <li>{{ __('welcome.the_browser') }}</li>
                          <li>{{ __('welcome.the_partner') }}</li>
                          <li>{{ __('welcome.by_signing_up') }}</li>
                          <li>{{ __('welcome.these_cond') }}</li>
                      </ul>
                  </div>
              </div>

              <div class="blue-section p-10 space-x-10">
                  <div>
                      <h3>{{ __('welcome.use_social') }}</h3>

                      <ul class="check-1">
                          <li>{{ __('welcome.the_values') }}</li>
                          <li>{{ __('welcome.it_is_forb') }}</li>
                      </ul>

                      <ul class="check-2">
                          <li>{{ __('welcome.in_active_adv') }}</li>
                          <li>{{ __('welcome.sites_that') }}</li>
                          <li>{{ __('welcome.in_contextual') }}</li>
                          <li>{{ __('welcome.for_creating') }}</li>
                          <li>{{ __('welcome.in_mailings') }}</li>
                          <li>{{ __('welcome.on_web_pub') }}</li>
                          <li>{{ __('welcome.on_web_close') }}</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </section>

@include('partials.startNow')

@include('partials.footer')
