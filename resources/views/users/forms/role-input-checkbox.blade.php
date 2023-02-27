@forelse($roles as  $name)
    <p class="p-v-xs">
        @switch( \Session::get('login_role'))
            @case(App\User::IsAdministrador())
                @if(isset($user))
                    <input class="filled-in" type="checkbox" name="role[]" {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input class="filled-in" type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                @endif
                @break
            @case(App\User::IsActivador())
                @if(isset($user))
                    <input type="checkbox" name="role[]"  {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  {{$name == App\User::IsAdministrador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsActivador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDesarrollador() ? 'onclick=this.checked=!this.checked;' : '' ))}} value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" {{$name == App\User::IsAdministrador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsActivador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDesarrollador() ? 'onclick=this.checked=!this.checked;' : '' ))}} onchange="roles.getRoleSeleted(this)">
                @endif
                @break
            @case(App\User::IsDinamizador())
                @if(isset($user))
                    <input type="checkbox" name="role[]"  {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  {{$name == App\User::IsAdministrador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsActivador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDinamizador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDesarrollador() ? 'onclick=this.checked=!this.checked;' : '' )))}} value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" {{$name == App\User::IsAdministrador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsActivador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDinamizador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDesarrollador() ? 'onclick=this.checked=!this.checked;' : '' )))}} onchange="roles.getRoleSeleted(this)">
                @endif
                @break
            @case(App\User::IsExperto())
                @if(isset($user))
                    <input type="checkbox" name="role[]"  {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  {{$name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;': '' }} value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" {{$name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }} onchange="roles.getRoleSeleted(this)">
                @endif
            @case(App\User::IsArticulador())
                @if(isset($user))
                    <input type="checkbox" name="role[]"  {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  {{$name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;': '' }} value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" {{$name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }} onchange="roles.getRoleSeleted(this)">
                @endif
                @break
            @case(App\User::IsInfocenter())
                @if(isset($user))
                    <input type="checkbox" name="role[]"  {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  {{$name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;': '' }} value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" {{$name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }} onchange="roles.getRoleSeleted(this)">
                @endif
                @break
            @default
                @break
        @endswitch

        <label for="test-{{$name}}">{{$name}}</label>
    </p>
@empty
    <p class="p-v-xs">No tienes roles asignados</p>
@endforelse
@error('role')
<div class="center">
    <label class="red-text error">{{ $message }}</label>
</div>
@enderror
