@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <h5>
                        <a class="footer-text left-align" href="{{ route('csibt.detalle', $comite->id) }}">
                            <i class="material-icons arrow-l left">arrow_back</i>
                        </a> CSIBT
                    </h5>
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="divider"></div>
                                <br />
                                <form action="{{ route('csibt.update.gestor', [$idea, $comite]) }}" method="POST"
                                    name="frmUpdateGestorIdea">
                                    {!! method_field('PUT') !!}
                                    @csrf
                                    <div class="row">
                                        <h5 class="center">Cambiar el experto de la idea: <b>{{ $idea->codigo_idea }} -
                                                {{ $idea->nombre_proyecto }}</b></h5>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6 offset-m3 offset-l3">
                                            <select id="txtgestor_id" class="js-states" name="txtgestor_id"
                                                style="width: 100%;">
                                                <option value="">Seleccione el experto</option>
                                                @forelse ($gestores as $id => $gestor)
                                                    <option value="{{ $gestor->gestor->id }}"
                                                        {{ $gestor->gestor->id == $idea->gestor_id ? 'selected' : '' }}
                                                        {{ old('txtgestor_id') == $gestor->gestor->id ? 'selected' : '' }}>
                                                        {{ $gestor->nombre }}</option>
                                                @empty
                                                    <option value="">No hay información disponible</option>
                                                @endforelse
                                            </select>
                                            <label for="txtgestor_id">Expertos <span class="red-text">*</span></label>
                                            @error('txtgestor_id')
                                                <label id="txtgestor_id-error" class="error"
                                                    for="txtgestor_id">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="center">
                                        <button type="submit" value="send"
                                            class="waves-effect waves-light btn bg-secondary center-align">
                                            <i class="material-icons right">send</i>
                                            Cambiar experto.
                                        </button>
                                        <a href="{{ route('csibt.detalle', $comite->id) }}"
                                            class="waves-effect bg-danger btn center-align">
                                            <i class="material-icons left">backspace</i>Cancelar
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
