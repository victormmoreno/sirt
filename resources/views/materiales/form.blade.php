<div class="col s12 m10 l10 offset-l1 offset-m1">
    {!! csrf_field() !!}
    @if ($errors->any())
    <div class="card red lighten-3">
        <div class="row">
            <div class="col s12 m12">
                <div class="card-content white-text">
                    <p>
                        <i class="material-icons left">
                            info_outline
                        </i>
                        @if(collect($errors->all())->count() > 1)
                        Tienes {{collect($errors->all())->count()}} errores
                        @else
                            Tienes {{collect($errors->all())->count()}} error
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

	@can('showInputsForAdmin', App\Models\Material::class)
        @include('materiales.form_components.nodo')
    @elsecan('showInputsForDinamizador', App\Models\Material::class)
        @include('materiales.form_components.linea')
    @endcan
	@include('materiales.form_components.general')
	<div class="divider"></div>
	<div class="center">
	  	<button type="submit" class="waves-effect bg-secondary btn center-aling"><i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'send' : '' }}</i>{{isset($btnText) ? $btnText : 'error'}}</button>
	  	<a href="{{route('material.index')}}" class="waves-effect bg-danger btn center-aling"><i class="material-icons left">backspace</i>Cancelar</a>
	</div>
</div>
