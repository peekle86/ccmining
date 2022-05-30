@extends('layouts.newfront')
@section('content')

    @if(session('message'))
        <div class="row mb-2">
            <div class="col-lg-12">
                <div class="font-bold bg-green-50 rounded border-green-300 border p-3 text-green-500" role="alert">{{ session('message') }}</div>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="row mb-2">
            <div class="col-lg-12">
                <div class="font-bold bg-red-50 rounded border-red-300 border p-3 text-red-500" role="alert">{{ session('error') }}</div>
            </div>
        </div>
    @endif
    @if($errors->count() > 0)
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1 class="text-2xl font-bold">{{ trans('global.my_profile') }}</h1>

    @if ($errors->has('password'))
        <span class="text-red-500" role="alert">{{ $errors->first('password') }}</span>
    @endif

    <div x-data="{ show_pass: false }" class="bg-white rounded-lg border p-6 shadow space-y-4 lg:w-1/2">
        <div>
            <ul class="space-y-3">
                <li>
                    <span class="font-bold">E-mail:</span> {{ $user->email }}
                    @if( $user->verified )
                        <span class="rounded p-2 bg-green-50 text-green-500">{{ __('dashboard._verif') }}</span>
                    @else
                        <span class="rounded p-2 bg-red-50 text-red-500">{{ __('dashboard._no_verif') }}</span>
                        <span>
                            <form action="/verify-email" method="post">
                                @csrf
                                <button class="text-white hover:bg-blue-400 bg-blue-500 rounded px-3 py-1" type="submit">{{ __('dashboard._send_conf_email') }}</button>
                            </form>
                        </span>
                    @endif
                </li>

                <li>
                    <span class="font-bold">{{ __('dashboard._registration_date') }}:</span> {{ $user->created_at }}
                </li>
            </ul>
        </div>

        <form method="POST" class="space-y-4 " action="{{ route('newfront.profile.update') }}">
            @csrf

            <div>
                <label for="name"
                    class="block text-sm font-medium text-gray-900">{{ trans('cruds.user.fields.name') }}</label>
                <input type="text" placeholder="Your name" name="name" id="name" autocomplete="name"
                    class="block py-2 px-5 w-full shadow-sm border rounded-lg"
                    value="{{ old('name', $user->name) }}" required>
                @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <div class="text-gray-400 text-sm -space-y-1 pt-1">
                    <div>{{ __('dashboard._profile_under_message') }}</div>
                </div>
            </div>

            <div class="flex space-x-5">
                <div class="flex-1">
                    <button @click.prevent="show_pass = !show_pass"
                        class="py-3 border border-gray-600 hover:text-gray-600 hover:border-gray-500 block text-center w-full rounded-lg">
                       {{ __('dashboard._change_password') }}
                    </button>
                </div>
                <div class="flex-1">
                    <button type="submit"
                        class="py-3 bg-blue-600 hover:bg-blue-500 text-white block text-center w-full rounded-lg">{{ __('dashboard._save_profile') }}</button>
                </div>

            </div>

        </form>

        <form x-show="show_pass" class="space-y-4" method="POST" action="{{ route('profile.password.update') }}">
            @csrf
            <div class="form-group {{ $errors->has('curr_password') ? 'has-error' : '' }}">
                <label class="block text-sm font-medium text-gray-900" for="curr_password">
                    {{ trans('cruds.user.fields.password') }}</label>
                <input class="block py-2 px-5 w-full shadow-sm border rounded-lg" type="password" placeholder="******"
                    name="curr_password" id="curr_password" required>
                @if ($errors->has('curr_password'))
                    <span class="text-red-500" role="alert">{{ $errors->first('curr_password') }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="block text-sm font-medium text-gray-900" for="password">
                    {{ trans('cruds.user.fields.new_password') }}</label>
                <input class="block py-2 px-5 w-full shadow-sm border rounded-lg" type="password" placeholder="******"
                    name="password" id="password" required>
                @if ($errors->has('password'))
                    <span class="text-red-500" role="alert">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-900" for="password_confirmation">Repeat New
                    {{ trans('cruds.user.fields.password') }}</label>
                <input class="block py-2 px-5 w-full shadow-sm border rounded-lg" type="password" placeholder="******"
                    name="password_confirmation" id="password_confirmation" required>
            </div>
            <div class="form-group">
                <button type="submit"
                    class="py-3 bg-blue-600 hover:bg-blue-500 text-white block text-center w-full rounded-lg">{{ trans('global.save') }}</button>
            </div>
        </form>

        <div class="border-b pt-2"></div>

        <div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="space-x-1 flex py-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>{{ __('global.logout') }}</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    Dropzone.options.avatarDropzone = {
    url: '{{ route('newfront.profile.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="avatar"]').remove()
      $('form').append('<input type="hidden" name="avatar" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="avatar"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($user) && $user->avatar)
      var file = {!! json_encode($user->avatar) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="avatar" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
@endsection
