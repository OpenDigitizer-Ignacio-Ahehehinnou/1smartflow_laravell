@extends('layouts.dashlay')

@section('content')
    @php
        $heure = date('H');
        if ($heure >= 6 && $heure < 12) {
            $message = 'Bonjour M./Mme';
        } else {
            $message = 'Bonsoir M./Mme';
        }
    @endphp
    @if (session()->has('success'))
        <div class="alert alert-success">
            <h3>{{ session()->get('success') }}</h3>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h5>Dashboard</h5>
    <div class="mb-3" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
    <h5 class="mt-2">{{ $message }} {{ session('session.userDto.firstName') }}
        {{ session('session.userDto.lastName') }}</h5>
    {{-- <div class="col-12 col-md-6 mt-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Documents en attente d'approbation</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Vestibulum at eros</li>
            </ul>
        </div>
    </div> --}}


@endsection
