@extends('layouts.master')
@section('content')
    <div>
        <h5>Modifier une filiale</h5>
        <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('firm.update') }}">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Raison sociale</label>
                                <input type="text" class="form-control" placeholder="" required name="name"
                                    value="{{ $firm['name'] }}">
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $firm['email'] }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Adresse</label>
                                <input type="text" class="form-control" placeholder="" required name="address"
                                    value="{{ $firm['address'] }}">
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Ifu</label>
                                <input type="text" class="form-control" name="ifu" value="{{ $firm['ifu'] }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="text" class="form-control" placeholder="" required name="telephone"
                                    value="{{ $firm['telephone'] }}">
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Manager</label>
                                <input type="text" class="form-control" name="manager" value="{{ $firm['manager'] }}">
                            </div>
                        </div>
                        <input type="hidden" name="createdBy" value="{{ $firm['createdBy'] }}">
                        <input type="hidden" name="createdAt" value="{{ $firm['createdAt'] }}">
                        <input type="hidden" name="deletedFlag" value="{{ $firm['deletedFlag'] }}">
                        <input type="hidden" name="enterpriseId" value="{{ $firm['enterpriseId'] }}">
                        <input type="hidden" name="enterpriseParentCompanyId"
                            value="{{ $firm['enterpriseParentCompanyId'] }}">
                        <div class="d-flex justify-content-end"> <button type="submit"
                                class="btn btn-primary">Enregistrer</button></div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
