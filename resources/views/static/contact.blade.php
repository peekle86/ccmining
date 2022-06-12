@include('partials.header')
<div class="py-12"></div>

<section class="py-12 bg-white mb-0 px-3 faq">
    <h2 class="w-full my-8 text-center">
      {{ __('welcome.h_off') }}
    </h2>
    <div class="container mx-auto">

      <div class="flex flex-col md:flex-row space-y-10 md:space-y-0 md:space-x-5">
        <div class="md:w-1/3 space-y-5">
          <div class="blue-section p-9">
            <div>
                <h4>{{ __('welcome.cont') }}</h4>
                <ul>
                    <li>Cryptonite Crypto Cloud Mining Solutions Limited</li>
                    <li>8 Shepherd Market</li>
                    <li>London</li>
                    <li>W1J 7QE</li>
                    <li>Company No. 13299796</li>
                </ul>
            </div>
          </div>

          <div class="blue-section p-9">
            <div>
                <h4>{{ __('welcome.fin_dep') }}</h4>
                <p>
                  <a href="mailto:contact@ccgmining.com">contact@ccgmining.com</a>
                </p>
            </div>
          </div>
        </div>

        <div class="md:w-2/3">
          <img src="/img/map.jpg" class="w-full" alt="">
        </div>
      </div>
    </div>
</section>

@include('partials.contactForm')

<section class="pb-12 bg-white mb-0 px-3 ">
  <h2 class="w-full my-8 text-center">
    {{ __('welcome.o_dep') }}
  </h2>
  <div class="container mx-auto px-3">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="blue-section p-9">
          <div>
              <h4>{{ __('welcome.fin_dep') }}</h4>
              <p>
                <a href="mailto:finance@ccgmining.com">finance@ccgmining.com</a>
              </p>
          </div>
        </div>

        <div class="blue-section p-9">
          <div>
              <h4>{{ __('welcome.i_dep') }}</h4>
              <p>
                <a href="https://ccmining.net/ru/contact">https://ccmining.net/ru/contact</a>
              </p>
          </div>
        </div>

        <div class="blue-section p-9">
          <div>
              <h4>B2B {{ __('welcome.dep') }}</h4>
              <p>
                <a href="mailto:contact@b2b@ccgmining.com">contact@b2b@ccgmining.com</a>
              </p>
          </div>
        </div>
      </div>
  </div>
</section>

@include('partials.startNow')

@include('partials.footer')
