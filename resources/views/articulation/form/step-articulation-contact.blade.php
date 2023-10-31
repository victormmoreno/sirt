<h3>Contacto</h3>
<section>
    <div class="wizard-content">
        <div class="section-articulation search-tabs-row search-tabs-header">
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        <label class="active" for="scope">Alcance de la articulación<span class="red-text">*</span></label>
                        <select  id="scope" name="scope" style="width: 100%" tabindex="-1">
                            <option value>Seleccione Alcance Articulación</option>
                                @forelse($scopes  as $id => $name)
                                    @if (isset($articulation))
                                        <option value="{{$id}}" {{ old('scope', $articulation->scope->id) == $id ? 'selected':'' }}>{{$name}}</option>
                                    @else
                                        <option value="{{$id}}" {{ old('scope') == $id ? 'selected':'' }}>{{$name}}</option>
                                    @endif
                                @empty
                                    <option>No se encontraron resultados</option>
                                @endforelse
                        </select>
                    </div>
                    <div class="input-field col s12 m12 l6">
                        <input  id="name_entity" type="text" name="name_entity" class="validate" value="{{isset($articulation) ? $articulation->entity : old('name_entity')}}">
                        <label for="name_entity">Entidad con la que se realiza la articulación<span class="red-text">*</span></label>
                        <small id="name_entity-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        <input id="name_contact" type="text" name="name_contact" class="validate" value="{{isset($articulation) ? $articulation->contact_name : old('name_contact')}}">
                        <label for="name_contact">Nombre de contacto<span class="red-text">*</span></label>
                        <small id="name_contact-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l6">
                        <input id="email_entity" name="email_entity" type="email" value="{{isset($articulation) ? $articulation->email_entity : old('email_entity')}}">
                        <label for="email_entity">Correo institucional de la entidad <span class="red-text">*</span></label>
                        <small id="email_entity-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        <input id="summon_name" name="summon_name" type="text" value="{{isset($articulation) ? $articulation->summon_name : old('summon_name')}}">
                        <label for="summon_name">Nombre de evento o actividad (si aplica)</label>
                        <small id="summon_name-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l6">
                        <input id="expected_date" name="expected_date" type="text" class="articulation_date-end" value="{{isset($articulation) ? $articulation->expected_end_date->format('Y-m-d') : old('expected_date')}}">
                        <label for="expected_date">Fecha esperada de finalización <span class="red-text">*</span></label>
                        <small id="expected_date-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        <textarea name="objective" class="materialize-textarea" length="3500" maxlength="3500" id="objective">{{isset($articulation) ? $articulation->objective : old('objective')}}</textarea>
                        <label for="objective">Objetivo<span class="red-text">*</span></label>
                        <small id="objective-error" class="error red-text"></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
