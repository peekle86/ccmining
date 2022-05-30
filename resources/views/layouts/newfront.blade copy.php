<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />

  <link href="{{ asset('assets/tailwind.min.css') }}" rel="stylesheet">
  <script src="{{ asset('assets/alpine.min.js') }}"></script>
  @yield('styles')
  
  <style>
    .container {
      padding-left: 15px;
      padding-right: 15px;
    }
  </style>
</head>
<a class="navbar-brand" href="{{ url('/') }}">
    
</a>
<body class="bg-gray-50">
  <div class="page" id="app">
    <nav x-data="{ open: false || window.innerWidth > 1023 }" class="bg-white shadow-sm">
      <div class="container mx-auto flex justify-between space-x-5 items-center py-6 relative">
        <a href="{{ route('newfront.dashboard') }}" class="text-2xl font-bold">{{ config('app.name', 'Laravel') }}</a>
        <div class="flex lg:space-x-10 space-x-4">
          <ul class="lg:flex lg:space-x-2 absolute lg:relative top-20 lg:top-0 left-0 w-full bg-white py-3 lg:py-0" x-show="open">
            <li><a class="py-2 px-4 block" href="{{ route('newfront.dashboard') }}">Dashboard</a></li>
            <li><a class="py-2 px-4 block" href="{{ route('newfront.farm') }}">Farm</a></li>
            <li><a class="py-2 px-4 block" href="{{ route('newfront.affiliate') }}">Affiliate</a></li>
            <li><a class="py-2 px-4 block" href="{{ route('newfront.profile') }}">Profile</a></li>
            <li><a class="py-2 px-4 block" href="{{ route('newfront.support') }}">Support</a></li>
          </ul>
          
          <div class="flex space-x-2">
            <a href="{{ route('newfront.cart') }}" class="space-x-1 flex py-2 px-3 lg:px-6 items-center bg-green-400 hover:bg-green-500 rounded-full text-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="space-x-1 flex py-2 px-3 lg:px-6 items-center bg-gray-600 hover:bg-gray-500 rounded-full text-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              <span class="hidden lg:block">{{ __('Logout') }}</span>
            </a>
  
  
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
  
            <button type="button" class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
              <span class="sr-only">Open main menu</span>
              <svg class="h-6 w-6 block" :class="{ 'hidden': open, 'block': !(open) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
              <svg class="h-6 w-6 hidden" :class="{ 'block': open, 'hidden': !(open) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <div class="py-12">
      <div class="container mx-auto space-y-10">
            @yield('content')
        </div>
    </div>

    <footer class="bg-gray-900 text-white text-sm">
      <div class="container mx-auto flex flex-col md:flex-row py-12 space-y-10 md:space-y-0">
        
        <div class="md:w-1/2 md:flex md:space-y-0 space-y-10">
            <div class="md:w-1/2">
            <ul class="space-y-2 text-gray-400">
                <li class="font-bold mb-6 text-white uppercase">Tools</li>
                <li><a href="#">Overclocking Database</a></li>
                <li><a href="#">Best Mining GPUs</a></li>
                <li><a href="#">Mining Calculator</a></li>
                <li><a href="#">Knowledge Base</a></li>
                <li><a href="#">News</a></li>
                <li><a href="#">Ideas</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
            </div>

            <div class="md:w-1/2">
            <ul class="space-y-2 text-gray-400">
                <li class="font-bold mb-6 text-white uppercase">Resources</li>
                <li><a href="#">Watch us on Youtube</a></li>
                <li><a href="#">Partnership inquiries</a></li>
                <li><a href="#">Terms of service</a></li>
                <li><a href="#">Support</a></li>
                <li><a href="#">Statistics</a></li>
                <li><a href="#">Payouts</a></li>
            </ul>
            </div>
        </div>
        
        <div class="md:w-1/2 md:justify-end flex">
            <div class="md:text-right">
                <a href="{{ route('newfront.dashboard') }}" class="text-2xl font-bold">{{ config('app.name', 'Laravel') }}</a>
                <div class="mt-5 font-bold uppercase flex items-center space-x-2">
                  <div>Language:</div>
                  <a href="#"><img class="w-8" src="{{ asset('storage/icons/us.svg') }}" alt=""></a>
                </div>
            </div>
          </div>
      </div>

      

      <div class="py-6 border-t border-gray-800">
        <div class="container mx-auto text-center md:text-left">
          © 2021. All rights reserved.
        </div>
      </div>
    </footer>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
  @yield('scripts')
  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>