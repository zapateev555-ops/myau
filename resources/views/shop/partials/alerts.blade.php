@if(session('success'))

<div class="alert alert-success ac-alert mb-3" role="alert">

    {{ session('success') }}

    <button type="button" class="btn-close ac-alert__close" aria-label="Закрыть"></button>

</div>

@endif

@if(session('error'))

<div class="alert alert-danger ac-alert mb-3" role="alert">

    {{ session('error') }}

    <button type="button" class="btn-close ac-alert__close" aria-label="Закрыть"></button>

</div>

@endif

@if($errors->any())

<div class="alert alert-danger ac-alert mb-3" role="alert">

    <ul class="mb-0">

        @foreach($errors->all() as $error)

        <li>{{ $error }}</li>

        @endforeach

    </ul>

    <button type="button" class="btn-close ac-alert__close" aria-label="Закрыть"></button>

</div>

@endif

