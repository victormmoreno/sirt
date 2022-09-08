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
	@endcan
	@include('materiales.form_components.general')
	<div class="divider"></div>
	<center>
	  	<button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>{{isset($btnText) ? $btnText : 'error'}}</button>
	  	<a href="{{route('material.index')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
	</center>
</div>
