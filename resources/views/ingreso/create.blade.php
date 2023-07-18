@extends('layouts.app')
@section('meta-title', 'Ingresos de Tecnoparque')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <h5>
                        <a class="footer-text left-align" href="{{ route('ingreso') }}">
                            <i class="material-icons arrow-l left">arrow_back</i>
                        </a> Ingresos
                    </h5>
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <center>
                                    <span class="card-title center-align">Nuevo ingreso Tecnoparque</span>
                                </center>
                                <div class="divider"></div>
                                <br />
                                <form id="formIngresoVisitanteCreate" action="{{ route('ingreso.store') }}" method="POST"
                                    onsubmit="return checkSubmit()">
                                    {!! csrf_field() !!}
                                    @include('ingreso.form', [
                                        'btnText' => 'Registrar',
                                    ])
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('script')
    <script>
        divRegistrarVisitante = $('#divRegistrarVisitante');
        divVisitanteRegistrado = $('#divVisitanteRegistrado');
        divRegistrarVisitante.hide();
        divVisitanteRegistrado.hide();

        //Enviar formulario
        $(document).on('submit', 'form#formIngresoVisitanteCreate', function(event) {
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            $.ajax({
                type: form.attr('method'),
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('button[type="submit"]').removeAttr('disabled');
                    $('.error').hide();
                    if (data.fail) {
                        Swal.fire({
                            title: 'Registro Erróneo',
                            text: "Estas ingresando mal los datos!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        })
                        for (control in data.errors) {
                            $('#' + control + '-error').html(data.errors[control]);
                            $('#' + control + '-error').show();
                        }
                    }
                    if (data.fail == false && data.redirect_url == false) {
                        Swal.fire({
                            title: 'El ingreso no se ha registrado, por favor inténtalo de nuevo',
                            // text: "You won't be able to revert this!",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        })
                    }
                    if (data.fail == false && data.redirect_url != false) {
                        Swal.fire({
                            title: 'Registro Exitoso',
                            text: "El ingreso ha sido creado satisfactoriamente",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                        setTimeout(function() {
                            window.location.replace("{{ route('ingreso.create') }}");
                        }, 1000);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        });
    </script>
@endpush
