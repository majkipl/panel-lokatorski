@if ($errors->any())
    <div class="col-12 message">
        @foreach ($errors->all() as $error)
        <h3 class="alert alert-error" role="alert">{{ $error }}</h3>
        @endforeach
    </div>
@endif
