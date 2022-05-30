@include('partials.header')
<div class="py-12"></div>

<section class="py-12 bg-white mb-20 px-3 faq">
    <h2 class="w-full my-8 text-center">
        FAQ
    </h2>
    <div class="container mx-auto">
        <div class="flex flex-col xl:flex-row space-y-10 xl:space-y-0 xl:space-x-10">
            <div>
                <ul class="menu-left">
                    @foreach ($faqs as $faq)
                        <li class="whitespace-nowrap"><a href="#faq_{{ $faq->id }}">{{ $faq->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="flex-auto">
                @foreach ($faqs as $faq)
                    <div class="relative pb-20">
                        <div id="faq_{{ $faq->id }}" class="absolute -top-28"></div>
                        <h3>{{ $faq->name }}</h3>

                        <div class="space-y-2">
                            @forelse ($faq->faqs as $item)
                                <dl>
                                    <dt onclick="showFaq(this)">{{ $item->question }}</dt>
                                    <dd>{{ $item->answer }}</dd>
                                </dl>
                            @empty

                            @endforelse
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@include('partials.startNow')

<script>
    function showFaq(el) {
        el.parentNode.classList.toggle('active');
    }
</script>

@include('partials.footer')
