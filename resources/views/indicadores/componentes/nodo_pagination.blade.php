<table id="{{$idTable}}">
    <thead>
        <tr>
            <th>
                <p style="padding: 0px">
                    <input type="checkbox" id="{{$checkName}}" name="{{$checkName}}" value="1" onclick="selectAll(this, 'nodos_list_select')">
                    <label for="{{$checkName}}" class="black-text">Seleccionar todos</label>
                </p>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($nodos as $nodo)
            <tr>
                <td style="padding: 5px">
                    <p style="padding: 0px">
                        <input type="checkbox" id="{{$listName}}{{$nodo->id}}" name="{{$listName}}[]" value="{{$nodo->id}}" class="nodos_list_select" onclick="verificarChecks(this, '{{$checkName}}')">
                        <label for="{{$listName}}{{$nodo->id}}" class="black-text">{{$nodo->nodos}}</label>
                    </p>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<br>
<div class="col-md-12 center text-center">
    <ul class="pagination pager" id="{{$idPager}}"></ul>
</div>
