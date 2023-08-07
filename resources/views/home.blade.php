@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Registro de Domicilio</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                     <form method="POST" action="{{ route('redirectTo.expenses') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">Calle</label>

                            <div class="col-md-6">
                                <input id="address"
                                        type="text"
                                        class="form-control @error('address') is-invalid @enderror"
                                        name="address"
                                        value="{{ $address }}"
                                        required
                                        autocomplete="address"
                                        autofocus
                                >

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_int" class="col-md-4 col-form-label text-md-end">No Interior</label>

                            <div class="col-md-6">
                                <input id="no_int"
                                        type="text"
                                        class="form-control @error('no_int') is-invalid @enderror"
                                        name="no_int"
                                        value="{{ $no_int }}"
                                        required
                                        autocomplete="no_int"
                                        autofocus
                                >

                                @error('no_int')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_int" class="col-md-4 col-form-label text-md-end">No Exterior</label>

                            <div class="col-md-6">
                                <input id="no_ext"
                                        type="text"
                                        class="form-control @error('no_ext') is-invalid @enderror"
                                        name="no_ext"
                                        value="{{ $no_ext }}"
                                        autocomplete="no_ext"
                                        autofocus
                                >

                                @error('no_ext')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cp" class="col-md-4 col-form-label text-md-end">Codigo Postal</label>

                            <div class="col-md-6">
                                <input id="cp"
                                        type="text"
                                        class="form-control @error('cp') is-invalid @enderror"
                                        name="cp"
                                        onblur="getZipCode()"
                                        value="{{ $cp }}"
                                        required
                                        autocomplete="cp"
                                        autofocus
                                >

                                @error('cp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="state" class="col-md-4 col-form-label text-md-end">Estado</label>

                            <div class="col-md-6">
                                <input id="state"
                                        type="text"
                                        class="form-control @error('state') is-invalid @enderror"
                                        name="state"
                                        value="{{ $state }}"
                                        required
                                        autocomplete="state"
                                        readonly
                                >

                                @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="city" class="col-md-4 col-form-label text-md-end">Municipio</label>

                            <div class="col-md-6">
                                <input id="city"
                                        type="text"
                                        class="form-control @error('city') is-invalid @enderror"
                                        name="city"
                                        value="{{ $city }}"
                                        required
                                        autocomplete="city"
                                        readonly
                                >

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="colony" class="col-md-4 col-form-label text-md-end">Colonia</label>
                            <div class="col-md-6">
                                <select class="form-control" name="colony" id="colony"></select>
                                @error('colony') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a class="btn btn-danger" href="{{route('view.registers')}}">
                                    Regresar
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    Siguiente
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

        function getZipCode() {

            var colony    = document.getElementById("colony");
            var zipCode   = document.getElementsByName("cp")[0].value;

            if(!zipCode)
                return alert("Necesita agregar una Codigo Postal");

            var url = "{{url('zip-code')}}?cp="+zipCode;

            fetch(url,{
                headers : {"X-Requested-With": "XMLHttpRequest"}
            })
                .then(data => { return data.json()})
                .then(response => {
                    document.getElementById('state').value  = response.estado;
                    document.getElementById('city').value   = response.delegacion_municipio;

                    var render = document.getElementById('colony');
                    render.innerHTML = colonyModels(response.colonias);
                })

        }

        function colonyModels(fields){
            var html = '';
            for (var i = 0; i < fields.length; i++){
                var selected = '';
                html +=
                    '<option value="'+fields[i].colonia+'" '+selected+'>'+fields[i].colonia+'</option>'
            }

            return html;
        }

        getZipCode();

    </script>



@endsection
