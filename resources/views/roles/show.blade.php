@extends('layouts.master')
@section('content')

<h1>Rôle : {{ $role['libelle'] }}</h1>

<h2>Droits associés :</h2>
<ul>
    @foreach ($role['rights'] as $right)
        <li>{{ $right['nom_du_droit'] }}</li>
    @endforeach
</ul>

@endsection
