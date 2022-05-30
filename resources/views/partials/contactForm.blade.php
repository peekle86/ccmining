<section class="py-12 mb-20 px-3 contacts">
  <h2 class="w-full my-8 text-center">
    {{ __('welcome.contact_us') }}
  </h2>
  <div class="container mx-auto px-3">
      <div class="flex flex-col lg:flex-row space-y-10 lg:space-y-0 lg:space-x-6">
        <div class="lg:w-2/3">

          @if(session('success'))
            <div class="items-center justify-center modal text-black flex" id="success_pop" onclick="toggleModal('success_pop');return false;">
              <div class="w-600 bg-white rounded-xl max-w-4xl py-12 px-6 space-y-5" onclick="event.stopPropagation();">
                  {{ session('success') }}
              </div>
            </div>
            <div class="alert alert-success">
            {{ session('success') }}
            </div>
          @endif

          <form action="{{ route('newfront.contact') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <input type="text" placeholder="{{ __('welcome.full_name') }}" name="name" id="name">
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>

            <div>
                <input type="text" placeholder="{{ __('welcome.email') }}" name="email" id="email">
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>

            <div>
                <input type="text" placeholder="{{ __('welcome.sub') }}" name="subject" id="subject">
                <span class="text-danger">{{ $errors->first('subject') }}</span>
            </div>

            <div>
                <textarea name="message" placeholder="{{ __('welcome.e_y_m') }}" id="message" cols="30" rows="4"></textarea>
                <span class="text-danger">{{ $errors->first('message') }}</span>
            </div>

            <div class="flex items-end">
              <div class="flex-grow">

              </div>
              <div>
                <button type="submit" class="btn main-btn">{{ __('welcome.send_mess') }}</button>
              </div>
            </div>
          </form>
        </div>

        <div class="lg:w-1/3 pt-3">
          <div class="main-bg-color2 text-white space-y-8 px-10 pt-6 pb-14 rounded">
            <div class="text-lg font-bold">{{ __('welcome.ex_cust') }}</div>
            <div>
              <p class="text-gray-300 text-xl leading-9">{{ __('welcome.ex_cust_desc') }}</p>
            </div>
            <div>
              <a class="btn main-btn" href="/support">{{ __('welcome.sub_tic') }}</a>
            </div>
          </div>
        </div>

      </div>
  </div>
</section>
