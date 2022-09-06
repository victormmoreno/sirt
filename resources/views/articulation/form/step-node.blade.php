<h3>Nodo</h3>
<section>
    <div class="wizard-content">
        <div class="row search-tabs-row search-tabs-header">
            <div class="col m12">
                <small id="checkestado-error" class="error red-text"></small>
                <div class="row p-v-xs">
                    <address class=" p-v-xs left left-align">
                        <h5><b>Seleccione el nodo</b></h5>
                        <p>Selecciona los nodos donde se va a presentar este tipo de articulación</p>
                    </address>
                </div>
                <div class="row p-v-xs">
                    @foreach($nodos as $id => $name)
                        <div class="col s12 m4 l3">
                            <p class="p-h-xs p-v-xs">
                                @if(isset($typeArticulation))
                                    <input type="radio" value="{{$id}}" {{collect(old('node',$typeArticulation->nodos->pluck('id')))->contains($id) ? 'checked' : ''  }} name="checknode[]" class="filled-in filled-in-node" id="filled-in-{{$id}}">
                                @else
                                    <input type="radio" value="{{$id}}" name="node[]" class="filled-in filled-in-node" id="filled-in-{{$id}}" >
                                @endif
                                <label for="filled-in-{{$id}}">{{$name}}</label>
                            </p>
                        </div>
                    @endforeach
                    <small id="checknode-error" class="error red-text"></small>
                </div>
            </div>
        </div>
    </div>
</section>
