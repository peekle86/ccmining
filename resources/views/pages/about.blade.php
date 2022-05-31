@include('partials.header')
<div class="py-12"></div>

<section class="py-12 bg-white mb-20 px-3 ">
    <h2 class="w-full my-8 text-center">
        {{ $content->title }}
    </h2>
    <div class="container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="blue-section p-10 space-x-10">
                <div>
                    {!! $content->first_text !!}
                </div>
            </div>
            <div class="blue-section p-10 space-x-10">
                <div class="space-y-6">
                    {!! $content->second_text !!}
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.startNow')

@include('partials.footer')
