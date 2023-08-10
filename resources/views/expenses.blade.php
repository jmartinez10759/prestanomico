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
                                        value="{{ $rfc }}"
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
                                        value="{{ $birthdate }}"
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
                                        value="{{ $monthly_salary }}"
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
                                        value="{{ $monthly_expenses }}"
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

                                <button type="button" class="btn btn-primary" onclick="storeExpenses(event)">
                                    <i class="spinner-border spinner-border-sm" id="spinner"></i>
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

 <!-- Modal Accepted -->
      <div class="modal fade" id="score_approved" >
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="POST" action="{{ route('assessment') }}">
                    @csrf
                    <div class="modal-header">
                      <h4 class="modal-title">Solicitud Aprobada</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row mb-3">
                            <label for="amount" class="col-md-4 col-form-label text-md-end">Monto: </label>

                            <div class="col-md-6">
                                <input id="amount"
                                        type="text"
                                        class="form-control"
                                        name="amount"
                                        readonly
                                        required
                                >

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="payment" class="col-md-4 col-form-label text-md-end">Pago Mensual: </label>

                            <div class="col-md-6">
                                <input id="payment"
                                        type="text"
                                        class="form-control"
                                        name="payment"
                                        readonly
                                        required
                                >

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="term" class="col-md-4 col-form-label text-md-end">Plazo: </label>

                            <div class="col-md-6">
                                <input id="term"
                                        type="text"
                                        class="form-control"
                                        name="term"
                                        readonly
                                        required
                                >

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="rate" class="col-md-4 col-form-label text-md-end">Tasa Interes: </label>

                            <div class="col-md-6">
                                <input id="rate"
                                        type="text"
                                        class="form-control"
                                        name="rate"
                                        readonly
                                        required
                                >

                            </div>
                        </div>

                    </div>
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Rechazar</button>
                     </div>
               </form>
            </div>
         </div>
      </div>


 <!-- Modal Rejected -->
      <div class="modal fade" id="score_rejected" >
         <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Solicitud Rechazada</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
               </div>
               <div class="modal-body">
                    <div id="response"></div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
               </div>
            </div>
         </div>
      </div>

<script type="text/javascript">

    var spinner = document.getElementById("spinner");
    spinner.style.display = "none";

    function storeExpenses(event){

        var url = "{{url('expenses')}}";
        event.preventDefault();

        var rfc                 = document.getElementsByName("rfc")[0].value;
        var birthdate           = document.getElementsByName("birthdate")[0].value;
        var monthly_salary      = document.getElementsByName("monthly_salary")[0].value;
        var monthly_expenses    = document.getElementsByName("monthly_expenses")[0].value;
        var dependents          = document.getElementsByName("dependents")[0].value;

        let _data = {
            "rfc"               : rfc              ,
            "birthdate"         : birthdate        ,
            "monthly_salary"    : monthly_salary   ,
            "monthly_expenses"  : monthly_expenses ,
            "dependents"        : dependents
        }

        spinner.style.display = "block";
        fetch(url,{
            headers : {
                "X-Requested-With"  : "XMLHttpRequest",
                "Content-Type"      : "application/json",
                "X-CSRF-TOKEN"      : @json(csrf_token())
            },
            method: "POST",
            body: JSON.stringify(_data),
        })
        .then(data => { return data.json()})
        .then(response => {

            if(response.message !== undefined){
                var text = document.getElementById("response");
                text.innerHTML = '<h3>'+response.message+'</h3>';

                spinner.style.display = "none";
                return $('#score_rejected').modal('show');
            }

            document.getElementById('amount').value  = response.monto;
            document.getElementById('payment').value = response.pago_mensual;
            document.getElementById('term').value    = response.plazo;
            document.getElementById('rate').value    = response.tasa_interes;

            $("#score_approved").modal("show");
            spinner.style.display = "none";

        });


    }

</script>




@endsection

