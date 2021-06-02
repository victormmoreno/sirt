<div class="row">
    <div class="input-field col s12 m4 l4">
        <select class="js-states browser-default select2" tabindex="-1" style="width: 100%" name="txttype_search" id="txttype_search" onchange="userSearch.changetextLabel()">
            <option value="1">Número de documento</option>
            <option value="2">Correo Electrónico</option>
        </select>
    </div>
    <div class="input-field col s12 m8 l8">
        <input type="text" id="txtsearch_user" name="txtsearch_user" class="autocomplete">
        <label for="txtsearch_user">Número de documento</label>
        <small id="txtsearch_user-error" class="error red-text"></small>
    </div>
</div>