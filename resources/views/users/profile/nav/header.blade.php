<div class="left">
    <div class="left">
        @if($user->genero == App\User::IsMasculino())
            <img alt="{{$user->nombres}}" class="circle mailbox-profile-image z-depth-1" src="{{ asset('img/profile-image-masculine.png') }}"></img>
        @elseif($user->genero == App\User::IsFemenino())
            <img alt="{{$user->nombres}}" class="circle mailbox-profile-image z-depth-1" src="{{ asset('img/profile-image-female.png') }}"></img> 
        @else
            <img alt="{{$user->nombres}}" class="circle mailbox-profile-image z-depth-1" src="{{ asset('img/profile-image-default.png') }}"></img> 
        @endif
    </div>
    <div class="left">
        <span class="mailbox-title">
            {{auth()->check() ? auth()->user()->nombres.' '.auth()->user()->apellidos : ''}}
        </span>
        <span class="mailbox-author">
            {{$user->getRoleNames()->implode(', ')}}
            <br>
                Miembro desde {{$user->created_at->isoFormat('LL')}}
                <br>
                    {{$user->fechanacimiento->age}} años
                </br>
            </br>
        </span>
    </div>
</div>