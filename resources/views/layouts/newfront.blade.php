@include('partials.header_dashboard')
<div class="py-12"></div>


    <div class="py-12 newfront">
      <div class="container mx-auto space-y-10 px-3">
            @yield('content')
        </div>
    </div>

    @include('partials.footer_dashboard')
