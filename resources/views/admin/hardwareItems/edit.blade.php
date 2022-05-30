@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.hardwareItem.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.hardware-items.update", [$hardwareItem->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="price">{{ trans('cruds.hardwareItem.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text" name="price" id="price" value="{{ old('price', $hardwareItem->price) }}" required>
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.price_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="model">{{ trans('cruds.hardwareItem.fields.model') }}</label>
                <input class="form-control {{ $errors->has('model') ? 'is-invalid' : '' }}" type="text" name="model" id="model" value="{{ old('model', $hardwareItem->model) }}" required>
                @if($errors->has('model'))
                    <div class="invalid-feedback">
                        {{ $errors->first('model') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.model_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="hashrate">{{ trans('cruds.hardwareItem.fields.hashrate') }}</label>
                <input class="form-control {{ $errors->has('hashrate') ? 'is-invalid' : '' }}" type="text" name="hashrate" id="hashrate" value="{{ old('hashrate', $hardwareItem->hashrate) }}">
                @if($errors->has('hashrate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hashrate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.hashrate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="power">{{ trans('cruds.hardwareItem.fields.power') }}</label>
                <input class="form-control {{ $errors->has('power') ? 'is-invalid' : '' }}" type="text" name="power" id="power" value="{{ old('power', $hardwareItem->power) }}">
                @if($errors->has('power'))
                    <div class="invalid-feedback">
                        {{ $errors->first('power') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.power_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="algoritm_id">{{ trans('cruds.hardwareItem.fields.algoritm') }}</label>
                <select class="form-control select2 {{ $errors->has('algoritm') ? 'is-invalid' : '' }}" name="algoritm_id" id="algoritm_id" required>
                    @foreach($algoritms as $id => $entry)
                        <option value="{{ $id }}" {{ (old('algoritm_id') ? old('algoritm_id') : $hardwareItem->algoritm->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('algoritm'))
                    <div class="invalid-feedback">
                        {{ $errors->first('algoritm') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.algoritm_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="profitability">{{ trans('cruds.hardwareItem.fields.profitability') }}</label>
                <input class="form-control {{ $errors->has('profitability') ? 'is-invalid' : '' }}" type="text" name="profitability" id="profitability" value="{{ old('profitability', $hardwareItem->profitability) }}" required>
                @if($errors->has('profitability'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profitability') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.profitability_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.hardwareItem.fields.available') }}</label>
                @foreach(App\Models\HardwareItem::AVAILABLE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('available') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="available_{{ $key }}" name="available" value="{{ $key }}" {{ old('available', $hardwareItem->available) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="available_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('available'))
                    <div class="invalid-feedback">
                        {{ $errors->first('available') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.available_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photo">{{ trans('cruds.hardwareItem.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.photo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.hardwareItem.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $hardwareItem->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="specification">{{ trans('cruds.hardwareItem.fields.specification') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('specification') ? 'is-invalid' : '' }}" name="specification" id="specification">{{ old('specification', $hardwareItem->specification) }}</textarea>
                @if($errors->has('specification'))
                    <div class="invalid-feedback">
                        {{ $errors->first('specification') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.specification_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="coins">{{ trans('cruds.hardwareItem.fields.coins') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('coins') ? 'is-invalid' : '' }}" name="coins" id="coins">{{ old('coins', $hardwareItem->coins) }}</textarea>
                @if($errors->has('coins'))
                    <div class="invalid-feedback">
                        {{ $errors->first('coins') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.coins_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="script">{{ trans('cruds.hardwareItem.fields.script') }}</label>
                <textarea class="form-control {{ $errors->has('script') ? 'is-invalid' : '' }}" name="script" id="script">{{ old('script', $hardwareItem->script) }}</textarea>
                @if($errors->has('script'))
                    <div class="invalid-feedback">
                        {{ $errors->first('script') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.script_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="url">{{ trans('cruds.hardwareItem.fields.url') }}</label>
                <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="text" name="url" id="url" value="{{ old('url', $hardwareItem->url) }}" required>
                @if($errors->has('url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.hardwareItem.fields.url_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.hardware-items.storeMedia') }}',
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
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($hardwareItem) && $hardwareItem->photo)
      var file = {!! json_encode($hardwareItem->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
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
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.hardware-items.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $order->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>
@endsection
