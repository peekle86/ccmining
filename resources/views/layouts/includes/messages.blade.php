<div class="validation_messages">
    @if(session()->get('success'))
        <div class="bg-green-100 border border-green-400 text-black-700 px-4 py-3 rounded relative validation_messages" role="alert">
            <strong class="font-bold">{{ session()->get('success') }}</strong>
        </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative validation_messages" role="alert">
                <strong class="font-bold"> {{ $error }}</strong>
            </div>
        @endforeach
    @endif
</div>





