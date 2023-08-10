
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Carga de Comprobantes</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                     <form method="POST" action="{{ route('voucher') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">Comprobante de Domicilio</label>

                            <div class="col-md-6">
                                <input id="voucher_address"
                                        type="file"
                                        accept="application/pdf,image/*"
                                        class="form-control"
                                        name="voucher_address"
                                        required
                                >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_int" class="col-md-4 col-form-label text-md-end">Comprobante de Ingresos</label>

                            <div class="col-md-6">
                                <input id="voucher_income"
                                        type="file"
                                        accept="application/pdf, image/*"
                                        class="form-control"
                                        name="voucher_income"
                                        required
                                >

                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Cargar Archivos
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
