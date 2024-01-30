@if ($errors->any())
    <div class="" role="alert">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
