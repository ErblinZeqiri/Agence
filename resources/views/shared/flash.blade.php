@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@php
    //Partie du bas jusqu'avant le "@yield('content')" à enlever ou pas
@endphp
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="my-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
