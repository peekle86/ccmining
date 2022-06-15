<div class="fixed bottom-10 right-10 space-y-3 flex-col flex z-10">
    <a href="#" class="hover:opacity-90"><img width="40px" height="40px" src="{{ asset('img/tg.svg') }}" alt=""></a>
  </div>
@php
    $setting = App\Models\Setting::whereActive(1)->first();
@endphp
<!--Footer-->
    <footer class="main-bg pt-28 pb-16">
        <div class="container mx-auto px-3">

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

              <div class="flex lg:space-x-32 space-y-10 md:space-y-0 space-x-0 md:space-x-10 flex-col md:flex-row">
                  <div class="flex-1">
                      <div class="mb-8">
                          <a href="#">
                          <img src="/img/logo_footer.svg" alt="">
                          </a>
                      </div>
                      <div class="space-y-5">
                          <div class="font-bold">{{ __('welcome.pay') }}</div>
                          <div class="space-y-1">
                              <div class="flex space-x-1">
                                  <div class="b-main border">
                                      <img src="/img/pay03.svg" alt="">
                                  </div>
                                  <div class="b-main border">
                                      <img src="/img/pay04.svg" alt="">
                                  </div>
                              </div>
                              <div class="flex space-x-1">
                                  <div class="b-main border">
                                      <img src="/img/pay01.svg" alt="">
                                  </div>
                                  <div class="b-main border">
                                      <img src="/img/pay02.svg" alt="">
                                  </div>
                              </div>
                              <div class="flex space-x-1">
                                  <div class="b-main border">
                                      <img src="/img/qiwi.svg" alt="">
                                  </div>
                                  <div class="b-main border">
                                      <img src="/img/mir.svg" alt="">
                                  </div>
                              </div>
                          </div>

                      </div>
                  </div>

                  <div class="flex-1">
                      <div class="font-bold">{{ __('welcome.o_off') }}</div>
                      <ul class="text-gray-300 pt-4 leading-8">
                          <li>Cryptonite Crypto Cloud Mining Solutions Limited</li>
                          <li>8 Shepherd Market</li>
                          <li>London</li>
                          <li>W1J 7QE</li>
                          <li>Company No. 13299796</li>
                      </ul>
                  </div>
              </div>
              <div class="flex lg:space-x-32 space-y-10 md:space-y-0 space-x-0 md:space-x-10 flex-col md:flex-row">
                  <div class="flex-1">
                    <div class="font-bold">{{ __('welcome.toc') }}</div>
                        <ul class="text-gray-300 py-4 leading-8">
                            <li><a href="/terms">{{ __('welcome.r_toc') }} »</a></li>
                            <li><a href="/privacy">{{ __('welcome.r_priv') }} »</a></li>
                            <li><a href="/terms">{{ __('welcome.r_aml') }} »</a></li>
                            <li><a href="/refund">{{ __('welcome.r_risk') }} »</a></li>
                        </ul>
                      <div>{{ date('Y') }} ©  Bithash Mining LTD</div>
                  </div>

                  <div class="flex-1 space-y-3">
                      <div class="font-bold">{{ __('welcome.f_us') }}</div>
                      <div class="flex space-x-1 py-4">
                          <a href="#"><img src="/img/tw.svg" alt=""></a>
                          <a href="#"><img src="/img/telegram.svg" alt=""></a>
                          <a href="#"><img src="/img/vk.svg" alt=""></a>
                      </div>
                      <div class="flex">
                          <div class="flex-1"><img src="/img/ssl.svg" alt=""></div>
                          <div class="flex-1"><img src="/img/ddos.svg" alt=""></div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </footer>
      @if( ! Request::is('farm') )
      <div class="items-center justify-center modal text-black hidden" id="calc_modal" onclick="toggleModal('calc_modal');return false;">
        <div class="w-600 bg-white rounded-xl max-w-4xl py-12 px-6 space-y-5" onclick="event.stopPropagation();">
            <div class="h-40 border-b flex items-center justify-center pb-8">
                <img src="/img/power_3.svg" id="img_power" alt="power">
            </div>

            <div>
                <div class="text-xl">{{ __('welcome.sel_ghs') }}:</div>
                <div class="text-gray-600 text-sm">*{{ __('welcome.cont_per') }}</div>
            </div>

            <div>
                <input oninput="changeCalc(this)" type="range" id="power_range" min="2500" max="{{ $setting->max_th * 1000 }}" value="{{ $setting->max_th * 1000 / 4 }}" class="range range-lg w-full">
            </div>

            <div class="flex space-x-2">
                <div class="flex-1">
                    <div>{{ __('welcome.inv_in') }} $</div>
                    <input oninput="changeCalc(this)" type="number" step="10" id="amount" min="250" max="{{ $setting->price_th * $setting->max_th * 1000 }}" value="250" class="w-full border p-3 bg-gray-100 rounded">
                </div>
                <div class="flex-1 hidden">
                    <div>{{ __('welcome.pow_in') }} GH/s</div>
                    <input oninput="changeCalc(this)" type="number" step="10" max="{{ $setting->max_th * 1000 }}" id="power" value="" class="w-full border p-3 bg-gray-100 rounded">
                </div>
            </div>

            <div class="flex space-x-2 text-center text-sm whitespace-nowrap">
                <div class="flex-1 rounded">
                    <div class="border py-5 px-2">
                        <div>{{ __('welcome.d_inc') }}</div>
                        <div class="text-blue-600 text-2xl font-bold"><span id="income_d">0</span></div>
                    </div>
                </div>
                <div class="flex-1 rounded">
                    <div class="border py-5 px-2">
                        <div>{{ __('welcome.m_inc') }}</div>
                        <div class="text-blue-600 text-2xl font-bold"><span id="income_m">0</span></div>
                    </div>
                </div>
                <div class="flex-1 rounded">
                    <div class="border py-5 px-2">
                        <div>{{ __('welcome.y_inc') }}</div>
                        <div class="text-blue-600 text-2xl font-bold"><span id="income_y">0</span></div>
                    </div>
                </div>
            </div>

            <div class="text-center pt-4">
                <a href="{{ route('newfront.farm') }}" class="mx-auto md:ml-0 btn action-btn">{{ __('welcome.buy') }}</a>
            </div>
        </div>
    </div>
      @endif

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>

        @yield('scripts')
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>

        <script>
            let price_th = {{ $setting->price_th ?? 0 }};
            let profit_th = {{ $setting->profit_th ?? 0 }};
            let calc_modal = document.getElementById('calc_modal');
            let calc_amont = calc_modal.querySelector('#amount');

              if( calc_amont ) {
                  changeCalc(calc_amont);
              }


            function dropDown(el) {
                el.nextElementSibling.classList.toggle("hidden");
            }

            function toggleModal(id) {
                let modal = document.getElementById(id);
                modal.classList.toggle('hidden');
                modal.classList.toggle('flex');
            }

            function changeCalc(el) {
                  let max = parseInt(el.getAttribute('max'));
                  let min = parseInt(el.getAttribute('min'));
                  let power = 0;

                  if( parseInt(el.value) > max ) {
                      el.value = max;
                  }
                  if( el.id == 'power_range' ) {
                      power = calc_modal.querySelector('#power').value = parseInt(el.value);
                  }
                  if( el.id == 'power' ) {
                      power = calc_modal.querySelector('#power_range').value = parseInt(el.value);
                  }
                  if( el.id == 'amount' ) {
                      power = parseInt(parseInt(el.value) / price_th);

                      calc_modal.querySelector('#power').value = power;
                      calc_modal.querySelector('#power_range').value = power;
                  }
                  calculate(power, el.id)
                  changeCalcImg(power)

            }

            function calculate(power, id) {
              let income_d = calc_modal.querySelector('#income_d');
              let income_m = calc_modal.querySelector('#income_m');
              let income_y = calc_modal.querySelector('#income_y');

              let day_profit = profit_th * power;
              //let day_profit = parseInt(profit_th * power);

              income_d.innerHTML = day_profit.toLocaleString('en-US', {
                  style: 'currency',
                  currency: 'USD',
              });
              income_m.innerHTML = (day_profit * 30).toLocaleString('en-US', {
                  style: 'currency',
                  currency: 'USD',
              });
              income_y.innerHTML = (day_profit * 365).toLocaleString('en-US', {
                  style: 'currency',
                  currency: 'USD',
              });

              if( 'amount' != id ) {
                  calc_modal.querySelector('#amount').value = parseInt(power * price_th);
              }
            }

            function changeCalcImg(power) {
                let img_power = calc_modal.querySelector('#img_power');

                switch(true) {
                    case (power * price_th) < 3000:
                        img_power.src = '/img/power_1.svg';
                        break;
                    case (power * price_th) < 6000:
                        img_power.src = '/img/power_2.svg';
                        break;
                    case (power * price_th) < 9000:
                        img_power.src = '/img/power_3.svg';
                        break;
                    case (power * price_th) < 12000:
                        img_power.src = '/img/power_4.svg';
                        break;
                    case (power * price_th) < 15000:
                        img_power.src = '/img/power_5.svg';
                        break;
                    case (power * price_th) < 18000:
                        img_power.src = '/img/power_6.svg';
                        break;
                      case (power * price_th) < 21000:
                          img_power.src = '/img/power_7.svg';
                      break;
                      case (power * price_th) < 24000:
                          img_power.src = '/img/power_8.svg';
                      break;
                      default:
                          img_power.src = '/img/power_9.svg';
                          break;
                }
            }
        </script>

      <script>
        var navMenuDiv = document.getElementById("nav-content");
        var navMenu = document.getElementById("nav-toggle");

        document.onclick = check;
        function check(e) {
          var target = (e && e.target) || (event && event.srcElement);

          //Nav Menu
          if (!checkParent(target, navMenuDiv)) {
            // click NOT on the menu
            if (checkParent(target, navMenu)) {
              // click on the link
              if (navMenuDiv.classList.contains("hidden")) {
                navMenuDiv.classList.remove("hidden");
              } else {
                navMenuDiv.classList.add("hidden");
              }
            } else {
              // click both outside link and outside menu, hide menu
              navMenuDiv.classList.add("hidden");
            }
          }
        }
        function checkParent(t, elm) {
          while (t.parentNode) {
            if (t == elm) {
              return true;
            }
            t = t.parentNode;
          }
          return false;
        }
      </script>
    </body>
  </html>
