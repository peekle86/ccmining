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
                    <h3>OUR COMPANY:</h3>
                    <p>Bithash Mining was founded in 2016 during the boom of cryptocurrencies. And today everything we
                        do is based on the principle "We make it easy for you".
                        Bithash Mining - is an international company offering comprehensive solutions based on
                        blockchain technology. So far, we have gained the confidence of over 45 000 private clients and
                        over 850 business clients.
                        Our branches are located in 6 offices in 5 countries: Poland, Great Britain, Russia, Latvia,
                        Austria and Czech Republic. Our primary goal is to build the highest computing hashing power in
                        Europe. Our mission is to provide professional services and consistently strive to achieve the
                        greatest satisfaction of every customer.
                        The foundation of our company is ripped, competent and highly qualified team. Thanks to this, we
                        effectively deal with the changing market, with great flexibility by adapting working methods
                        and technologies to the current needs and expectations of customers
                        With pleasure we also accept new challenges while maintaining high quality and stability.</p>
                </div>
            </div>
            <div class="blue-section p-10 space-x-10">
                <div class="space-y-6">
                    <p class="font-bold">
                        We are working on a common goal - the success of our client. ccg mining partners value us for
                        responding to their needs in a timely manner.
                        We would like to present experienced professionals working in our ccg mining head office
                        team.am.
                    </p>
                    <p>We are working on a common goal - the success of our client. Bithash Mining partners value us for
                        responding to their needs in a timely manner.</p>
                    <p>We would like to present experienced professionals working in our Bithash Mining Head Office
                        Team.</p>
                    <p>We are working on a common goal - the success of our client. Bithash Mining partners value us for
                        responding to their needs in a timely manner.</p>
                    <p>We would like to present experienced professionals working in our Bithash Mining Head Office
                        Team.</p>
                    <div class="pt-6 flex space-x-2">
                        <div>
                            <img src="/img/pic.png" style="" alt="">
                        </div>
                        <div class="space-y-4">
                            <a href="#">CEO | Bithash Mining LTD</a>
                            <img src="/img/sign_black.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.startNow')

@include('partials.footer')
