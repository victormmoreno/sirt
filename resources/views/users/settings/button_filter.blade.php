<div class="row">
    <div class="center input-field col s12 m4 l4">
        <a class="btn btn-outline-danger" href="{{$url}}">
            {{$message}}
         </a>
    </div>
    {{-- <div class="center input-field col s12 m2 l2">
        <a onclick="{{$event}}" class="btn"><i class="material-icons">file_download</i></a>
   </div> --}}
   <div class="right mailbox-buttons">
    <span class="mailbox-title">
        <p class="center">
            <div class="right">
                <a class="waves-effect waves-light btn m-t-xs dropdown-button " data-activates="dropdown" href="#">
                    <i class="material-icons right">
                        more_vert
                    </i>
                    Descargar
                </a>
                <!-- Dropdown Structure -->
                <ul class="dropdown-content" id="dropdown">
                    <li>
                        <a onclick="{{$event}}" >Por nodo</a>
                    </li>
                    <li>
                        <a onclick="{{$eventAll}}">Todos</a>
                    </li>
                </ul>
            </div>
        </p>
    </span>
</div>
</div>



