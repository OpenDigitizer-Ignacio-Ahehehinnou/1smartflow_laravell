@extends('layouts.master')
@section('content')
<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table">
                <div class="d-table-cell align-middle">

                    <div class="text-center">
                        <img src="{{ asset('img/photos/401.svg') }}" style="background-color: none" alt="">
                        <div>
                            <p class="h4">Accès non autorisé.</p>
                            <p class="h6 mt-3 mb-4">Vous n'avez pas les droits requis pour effectuer cette action.</p>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

@endsection
