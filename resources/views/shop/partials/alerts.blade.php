@if(session('success'))
<div class="alert alert-success ac-alert" role="alert">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger ac-alert" role="alert">{{ session('error') }}</div>
@endif
@if($errors->any())
<div class="alert alert-danger ac-alert" role="alert">
    @foreach($errors->all() as $error)
    <span>{{ $error }}</span>@if(!$loop->last)<br>@endif
    @endforeach
</div>
@endif
