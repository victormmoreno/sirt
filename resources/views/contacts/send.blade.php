@extends('layouts.app')
@section('meta-title', 'PQRS')
@section('content')
<main class="mn-inner inner-active-sidebar">

    <div class="orange darken-1 z-depth-2">
        <div class="container ">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card card-transparent no-m ">
                        <div class="card-content  white-text">
                            <div class="row">
                                <div class="col s12 m6 l6">
                                    <h4>Contactenos</h4>
                                    <address>
                                        Medellín, Antioquia<br>
                                        calle 56 # 11 - piso 7
                                    </address>
                                </div>
                                <div class="col s12 m6 l6 right-align hide-on-small-only">
                                    <i class="large material-icons">sms</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col s12 m10 l6 offset-l3 offset-m1 z-depth-3">
            <div class="card card-transparent mt-2 ">
                <div class="card-content ">
                    {{-- <span class="card-title">PQRS</span> --}}
                    <address>
                        <strong>{{config('app.name')}}</strong><br>
                        {{-- 795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br> --}}
                        {{-- <abbr title="Phone">P:</abbr> (123) 456-7890 --}}
                    </address>
                </div>
                <div class="card-content ">
                    <span class="card-title">MANTENGÁMONOS EN CONTACTO</span>
                    @include('contacts.form')
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

