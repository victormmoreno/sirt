{!! csrf_field() !!}

<div class="row">
    <div class="input-field col s12 m6 l6">
        {{-- <i class="material-icons prefix">
            details
        </i> --}}

        <select class="js-states browser-default select2" id="txtcentro" name="txtcentro" style="width: 100%" tabindex="-1" >
            <option value="">Seleccione centro de formacion </option>
            @foreach($centros as $id => $nombre)
                @if(isset($nodo->gruposanguineo_id))
                <option value="{{$id}}" {{old('txtcentro',$nodo->gruposanguineo_id) ==  $id ? 'selected':''}}>{{$nombre}}</option> 
                @else
                    <option value="{{$id}}" {{old('txtcentro') == $id  ? 'selected':''}}>{{$nombre}}</option> 
                @endif
            @endforeach
        </select>
       <label for="txtcentro" class="active">Centro de Formación <span class="red-text">*</span></label>
        @error('txtcentro')
            <label id="txtcentro-error" class="error" for="txtcentro">{{ $message }}</label>
        @enderror 
    </div>    
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            account_circle
        </i>
        <input class="validate" id="txtnombre" name="txtnombre" type="text"  value="{{ isset($nodo->nombres) ? $nodo->nombres : old('txtnombre')}}">
        <label for="txtnombre">Nombre Nodo <span class="red-text">*</span></label>
        @error('txtnombre')
            <label id="txtnombre-error" class="error" for="txtnombre">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            account_circle
        </i>
        <input class="validate" id="txtdireccion" name="txtdireccion" type="text"  value="{{ isset($nodo->nombres) ? $nodo->nombres : old('txtdireccion')}}">
        <label for="txtdireccion">Dirección <span class="red-text">*</span></label>
        @error('txtdireccion')
            <label id="txtdireccion-error" class="error" for="txtdireccion">{{ $message }}</label>
        @enderror
    </div>
</div>
{{-- <div class="row">
<div class="input-field col s10 m10 l10">
  <select class="" id="txtlinea" name="txtlinea" onchange="nodo.addLinea()">
    <option value="0">Seleccione una Idea de Proyecto</option>
    @foreach ($lineas as $id => $nombre)
      <option value="{{$id}}">{{$nombre}}</option>
    @endforeach
  </select>
  <label>Idea de Proyecto <span class="red-text">*</span></label>
</div>
</div> --}}
{{-- <div class="row">
<div class="col s10 m9 l9">
  <div class="card blue-grey lighten-5">
    <div class="card-content">
      <table class="highlight centered responsive-table">
        <thead>
          <tr>
            <th style="width: 20%">Idea de Proyecto</th>
            <th style="width: 20%">Nombres del Contacto</th>
            <th style="width: 10%">¿Confirmación?</th>
            <th style="width: 10%">¿Canvas?</th>
            <th style="width: 10%">¿Asistió a la Primera Sesion?</th>
            <th style="width: 10%">¿Asistió a la Segunda Sesion?</th>
            <th style="width: 10%">¿Convocado a CSIBT?</th>
            <th style="width: 10%">Eliminar</th>
          </tr>
        </thead>
        <tbody id="tblIdeasEntrenamientoCreate">

        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="col s2 m3 l3">
  <blockquote>
    <ul class="collection">
      <li class="collection-item">Para agregar una idea de proyecto al entrenamiento solo debe buscarla y seleccionarla.</li>
    </ul>
  </blockquote>
</div>
</div> --}}
<div class="col s12 m6 l6 offset-l3 m3">
            <ul class="collection with-header">
                <li class="collection-header center">
                	<h5><b>Lineas</b></h5>
                	<p class="center">Seleccione lineas</p>
                </li>
               
                @forelse($lineas as $id => $nombre)
                    <li class="collection-item">
                        <p class="p-v-xs">
                            <input {{collect(old('txtlineas'))->contains($id) ? 'checked' : ''  }}  type="checkbox" id="txtlineas-{{$nombre}}" name="txtlineas[]"  value="{{$id}}">
                            <label for="txtlineas-{{$nombre}}">{{$nombre}}</label>
                        </p>
                    </li>
                @empty
                <p>No hay Lineas</p>
                @endforelse
            </ul>
        </div>
<div class="divider mailbox-divider"></div>
<br>
<center>
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>{{isset($btnText) ? $btnText : 'Guardar'}}</button> 
    <a class="waves-effect red lighten-2 btn center-aling" href="">
        <i class="material-icons right">
            backspace
        </i>
        Cancelar
    </a>
</center>