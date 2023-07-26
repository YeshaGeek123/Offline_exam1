@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        @foreach ($errors->all() as $error)
            <div class="font-medium text-danger">
                Error: {{ $error }}
            </div>
        @endforeach
    </div>
@endif
