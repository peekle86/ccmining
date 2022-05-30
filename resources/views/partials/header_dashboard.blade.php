<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link href="{{ asset('tailwind.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('styles.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/alpine.min.js') }}"></script>
    @yield('styles')

  </head>
  <body class="leading-normal tracking-normal">

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
              <a class="inline-block py-2 px-4 text-white no-underline" href="{{ route('newfront.dashboard') }}">{{ __('dashboard._dashboard') }}</a>
            </li>
            <li class="mr-3">
                <a class="inline-block py-2 px-4 text-white no-underline" href="{{ route('newfront.farm') }}">{{ __('dashboard._farm') }}</a>
            </li>
            <li class="mr-3">
                <a class="inline-block py-2 px-4 text-white no-underline" href="{{ route('newfront.affiliate') }}">{{ __('dashboard._affiliate') }}</a>
            </li>
            <li class="mr-3">
              <a class="inline-block py-2 px-4 text-white no-underline" href="{{ route('newfront.profile') }}">{{ __('dashboard._profile') }}</a>
            </li>
            <li class="mr-3">
                <a class="inline-block py-2 px-4 text-white no-underline" href="{{ route('newfront.support') }}">{{ __('dashboard._support') }}</a>
            </li>
          </ul>

          <ul class="list-reset xl:space-x-3 xl:space-y-0 py-4 xl:py-0 flex items-center pr-3">
            <li>
                <a href="/cart" class="main-btn bg-gray-600 flex no-underline font-bold hover:bg-gray-500 items-center px-3 py-2.5 rounded space-x-1 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="cart-count">
                        {{ auth()->user()->userCart ? auth()->user()->userCart->items->count() : 0 }}
                    </span>
                </a>
            </li>

            @if(count(config('panel.available_languages', [])) > 1)
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
            @endif
            <li class="mr-3">
                <a class="btn main-btn" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
