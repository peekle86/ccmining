@include('partials.header', ['title' => $category->name])
<div class="crypto-bg"></div>

<section class="pt-36 pb-12 bg-white px-3">
    <div class="container mx-auto px-4">
        <div class="flex space-x-2 justify-center">
            @forelse ($categories_menu as $menu)
            <a class="btn main-btn" href="/blog/{{ $menu->slug }}">{{ $menu->name }}</a>
            @empty

            @endforelse

        </div>

        <h2 class="w-full my-8 text-center pb-4">
            {{ $category->name }}
        </h2>

        <div class="grid grid-cols-3 gap-6">
        @forelse ($articles as $article)
            <a class="block no-underline rounded border text-black" style="background-color:#F3F8FF" href="/blog/{{ $category->slug }}/{{ $article->slug }}">
                @if($article->photo)
                    <img src="{{ $article->photo->getUrl() }}" class="block w-full">
                @endif
                <div class="py-6 px-8">
                    <div class="text-lg font-bold pb-3">{{ $article->name }}</div>
                    <div class="pb-3">{{ $article->desc }}</div>
                    <div class="text-gray-500">{{ $article->created_at->format('m/d/y h:i A') }}</div>
                </div>
            </a>
        @empty

        @endforelse
        </div>

        <div class="pt-10">
            {{ $articles->links() }}
        </div>
    </div>
</section>

@include('partials.startNow')

@include('partials.footer')
