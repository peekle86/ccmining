@php
    $meta = isset($title) ? \App\TitleHelper::get($title) : \App\TitleHelper::get();
@endphp
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link href="{{ asset('tailwind.css') }}" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('styles.css') }}" rel="stylesheet" />
  </head>
  <body class="leading-normal tracking-normal relative">

    <!--Nav-->
    <nav id="header" class="fixed w-full z-30 top-0 left-0 right-0 text-white">
      <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
        <div class="flex items-center">
          <a class="toggleColour py-2 px-4 text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="/">
            <img src="/img/logo.svg" alt="">
          </a>
        </div>
        <div class="block xl:hidden pr-4">
          <button id="nav-toggle" class="flex items-center p-1 text-white hover:text-gray-100 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
            <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <title>Menu</title>
              <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
            </svg>
          </button>
        </div>
        <div class="w-full space-x-3 flex-grow xl:flex xl:items-center xl:w-auto hidden mt-2 xl:mt-0 main-bg-color xl:bg-transparent text-black p-4 xl:p-0 z-20" id="nav-content">
          <ul class="list-reset xl:flex justify-center flex-1 items-center">
            <li class="mr-3">
                <a class="inline-block py-2 px-4 text-white no-underline" href="{{ route('blog.blog_category', 'news') }}">{{ __('welcome.blog') }}</a>
              </li>
            <li class="mr-3">
              <a class="inline-block py-2 px-4 text-white no-underline" href="{{ route('newfront.faq') }}">{{ __('welcome.faq') }}</a>
            </li>
            <li class="mr-3">
                <a class="inline-block py-2 px-4 text-white no-underline" href="{{ route('newfront.about') }}">{{ __('welcome.our_team') }}</a>
            </li>
            <li class="mr-3">
                <a class="inline-block py-2 px-4 text-white no-underline" href="{{ route('newfront.contact') }}">{{ __('welcome.contact_us') }}</a>
            </li>
            <li class="mr-3">
              <a class="inline-block py-2 px-4 text-white no-underline" href="{{ route('affiliate') }}">{{ __('welcome.affiliate') }}</a>
            </li>
          </ul>

          <ul class="list-reset xl:space-x-3 xl:space-y-0 space-y-4 py-4 xl:py-0 xl:flex justify-end items-center">

            @auth
                <li class="mr-3">
                    <a class="btn main-btn" href="{{ route('newfront.dashboard') }}">
                        {{ __('welcome.dashboard') }}
                    </a>
                </li>
            @else
                <li class="mr-3">
                    <a class="py-2 px-4 text-white no-underline flex" href="{{ route('login') }}">
                        {{ __('global.login') }} <img src="/img/logout.svg" class="ml-2" alt="">
                    </a>
                </li>
                <li class="mr-3">
                    <a class="btn main-btn" href="{{ route('register') }}">
                        {{ __('global.register') }}
                    </a>
                </li>
            @endauth
          </ul>

          <ul class="list-reset xl:flex justify-end items-center">
            <li class="mr-3" id="change_lang">
                <a onclick="dropDown(this);return false;" class="py-2 px-4 text-white no-underline flex space-x-2" href="#">
                    <img src="/img/{{ app()->getLocale() }}.svg" class="ml-2" alt="">
                    <span>{{ strtoupper(app()->getLocale()) }}</span>
                    <span><img src="/img/chevron-down.svg" alt=""></span>
                </a>
                <div class="hidden drop-down relative">
                    <ul>
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a class="py-2 px-4 text-white no-underline flex space-x-2" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    <img src="/img/{{ $localeCode }}.svg" class="ml-2" alt="">
                                    <span>{{ strtoupper($localeCode) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>




          </ul>
        </div>
      </div>
    </nav>
