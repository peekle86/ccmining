@include('partials.header')
<div class="crypto-bg"></div>
<div class="py-12"></div>

@include('partials.termsMenu')

  <section class="py-12 px-3 faq">
      <h2 class="w-full my-8 text-center">
        {{ $page->title }}
      </h2>
      <div class="container mx-auto bg-white py-10">

        <div class="terms-item">
          {!! $page->page_text !!}
        </div>

      </div>
  </section>

@include('partials.contactForm')

@include('partials.footer')
