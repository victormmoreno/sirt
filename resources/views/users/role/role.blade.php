<div class="col s12 m12 l12">
    <ul class="collection with-header">
        <li class="collection-header center"><h6><b>Roles</b></h6></li>
        @forelse($roles as  $name)
            <li class="collection-item">
                <p class="p-v-xs">
                    @switch( \Session::get('login_role'))
                        @case(App\User::IsActivador())
                            @if(isset($user))
                                <input type="checkbox" name="role[]" {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)" {{  $name == App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }}>
                            @else
                                <input type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                            @endif
                        @break
                        @case(App\User::IsDinamizador())
                            @if(isset($user))
                                <input type="checkbox" name="role[]"  {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  {{$name == App\User::IsActivador() ? 'onclick=this.checked=!this.checked;' : $name == App\User::IsDinamizador() ? 'onclick=this.checked=!this.checked;' :  $name == App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }} value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                            @else
                                <input type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" {{$name == App\User::IsActivador() ? 'onclick=this.checked=!this.checked;' : $name == App\User::IsDinamizador() ? 'onclick=this.checked=!this.checked;' : '' }} onchange="roles.getRoleSeleted(this)">
                            @endif
                        @break
                        @case(App\User::IsGestor())
                            @if(isset($user))
                                <input type="checkbox" name="role[]"  {{$name == App\User::IsTalento() ? 'checked' : ''  }}  {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  {{$name !== App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : ''}} {{$name === App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : ''}} value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                            @else
                                <input type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" {{$name === App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : ''}} {{\Session::get('login_role') == App\User::IsGestor() ? 'checked' : '' }}  onchange="roles.getRoleSeleted(this)">
                            @endif
                        @break
                        @default
                        @break
                    @endswitch

                    <label for="test-{{$name}}">{{$name}}</label>
                </p>
            </li>
        @empty
        <p>No tienes roles asignados</p>
        @endforelse
    </ul>
    @error('role')
        <div class="center">
            <label class="red-text error">{{ $message }}</label>
        </div>
    @enderror
    <small id="role-error" class="error red-text"></small>
</div>
