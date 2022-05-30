@include('partials.header', ['title' => $article->name])
<div class="crypto-bg"></div>

<section class="pt-36 pb-12 bg-white px-3">
    <div class="max-w-3xl mx-auto">
        <div class="flex space-x-2 justify-center">
            @forelse ($categories_menu as $menu)
            <a class="btn main-btn" href="/blog/{{ $menu->slug }}">{{ $menu->name }}</a>
            @empty

            @endforelse

        </div>

        <div class="mb-3 mt-10 text-center text-gray-500">{!! $breadcrumb !!}</div>

        <h2 class="w-full my-8 text-center">
            {{ $article->name }}
        </h2>
        <div class="-mt-10 mb-10 text-center text-gray-500">{{ $article->created_at }}</div>
        <div>
            {!! $article->content !!}
        </div>
    </div>
</section>

@include('partials.startNow')

@include('partials.footer')
