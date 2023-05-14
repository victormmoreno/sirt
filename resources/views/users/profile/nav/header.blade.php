<div class="left">
    <div class="left">
        {!!$user->present()->userProfileUserImage()!!}
    </div>
    <div class="left">
        <span class="mailbox-title secondary-text">
            {{$user->nombres.' '.$user->apellidos}}
        </span>
        <span class="mailbox-author">
            {{$user->getRoleNames()->implode(', ')}}
            <br>
                Miembro desde {{isset($user->created_at) ? $user->created_at->isoFormat('LL') : ': No Registra'}}
                <br>
            @if(isset($user->fechanacimiento))
            {{$user->fechanacimiento->age}} años
            @endif
        </span>
    </div>
</div>
