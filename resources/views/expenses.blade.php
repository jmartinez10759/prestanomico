@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Registro de Gastos</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                     <form method="POST" action="{{ route('finished') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="rfc" class="col-md-4 col-form-label text-md-end">RFC</label>

                            <div class="col-md-6">
                                <input id="rfc"
                                        type="text"
                                        class="form-control @error('rfc') is-invalid @enderror"
                                        name="rfc"
                                        value="{{ old('rfc') }}"
                                        required
                                        autocomplete="rfc"
                                        autofocus
                                >

                                @error('rfc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birthdate" class="col-md-4 col-form-label text-md-end">Fecha de Nacimiento</label>

                            <div class="col-md-6">
                                <input id="birthdate"
                                        type="date"
                                        class="form-control @error('birthdate') is-invalid @enderror"
                                        name="birthdate"
                                        value="{{ old('birthdate') }}"
                                        required
                                        autocomplete="birthdate"
                                        autofocus
                                >

                                @error('birthdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="monthly_salary" class="col-md-4 col-form-label text-md-end">Ingreso Mensual</label>

                            <div class="col-md-6">
                                <input id="monthly_saly"
                                        type="text"
                                        class="form-control @error('monthly_salary') is-invalid @enderror"
                                        name="monthly_salary"
                                        value="{{ old('monthly_salary') }}"
                                        autocomplete="monthly_salary"
                                        autofocus
                                >

                                @error('monthly_salary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="monthly_expenses" class="col-md-4 col-form-label text-md-end">Gastos Mensuales</label>

                            <div class="col-md-6">
                                <input id="monthly_expenses"
                                        type="text"
                                        class="form-control @error('monthly_expenses') is-invalid @enderror"
                                        name="monthly_expenses"
                                        value="{{ old('monthly_expenses') }}"
                                        required
                                        autocomplete="monthly_expenses"
                                        autofocus
                                >

                                @error('monthly_expenses')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="dependents" class="col-md-4 col-form-label text-md-end">Numero de Dependientes</label>
                            <div class="col-md-6">
                                <select class="form-control" name="dependents" id="dependents">
                                    <option value="0">Ninguno</option>
                                    <option value="1">1 Persona</option>
                                    <option value="2">2 Personas</option>
                                    <option value="3">3 Personas</option>
                                    <option value="4">4 Personas</option>
                                    <option value="5">5 Personas</option>
                                    <option value="6">6 Personas</option>
                                    <option value="7">7 Personas</option>
                                    <option value="8">8 Personas</option>
                                    <option value="9">9 Personas</option>
                                    <option value="10">10 Personas</option>
                                    <option value="other">Mas de 10</option>
                                </select>
                                @error('dependents') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                            </div>
                        </div>






                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a class="btn btn-danger" href="{{route('view.address')}}">
                                    Regresar
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    Finalizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script> </script>
