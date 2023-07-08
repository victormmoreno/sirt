@forelse($roles as  $name)
    <p class="p-v-xs">
        @switch(\Session::get('login_role'))
            @case(App\User::IsAdministrador())
                @if (isset($user))
                    <input class="filled-in" type="checkbox" name="role[]"
                        {{ collect(old('role', $user->roles->pluck('name')))->contains($name) ? 'checked' : '' }}
                        value="{{ $name }}" id="test-{{ $name }}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input class="filled-in" type="checkbox" name="role[]"
                        {{ collect(old('role'))->contains($name) ? 'checked' : '' }} value="{{ $name }}"
                        id="test-{{ $name }}" onchange="roles.getRoleSeleted(this)">
                @endif
            @break

            @case(App\User::IsActivador())
                @if (isset($user))
                    <input type="checkbox" name="role[]"
                        {{ collect(old('role', $user->roles->pluck('name')))->contains($name) ? 'checked' : '' }}
                        {{ $name == App\User::IsAdministrador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsActivador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDesarrollador() ? 'onclick=this.checked=!this.checked;' : '')) }}
                        value="{{ $name }}" id="test-{{ $name }}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input type="checkbox" name="role[]" {{ collect(old('role'))->contains($name) ? 'checked' : '' }}
                        value="{{ $name }}" id="test-{{ $name }}"
                        {{ $name == App\User::IsAdministrador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsActivador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDesarrollador() ? 'onclick=this.checked=!this.checked;' : '')) }}
                        onchange="roles.getRoleSeleted(this)">
                @endif
            @break

            @case(App\User::IsDinamizador())
                @if (isset($user))
                    <input type="checkbox" name="role[]"
                        {{ collect(old('role', $user->roles->pluck('name')))->contains($name) ? 'checked' : '' }}
                        {{ $name == App\User::IsAdministrador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsActivador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDinamizador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDesarrollador() ? 'onclick=this.checked=!this.checked;' :
                        (isset($user->experto->nodo->id) && isset(auth()->user()->dinamizador->nodo_id) && $user->experto->nodo->id != auth()->user()->dinamizador->nodo_id && collect($user->roles)->contains('name', App\User::IsExperto()) && $name == App\User::IsExperto() ? 'onclick=this.checked=!this.checked;':
                            (isset($user->articulador->nodo_id) && isset(auth()->user()->dinamizador->nodo_id) && $user->articulador->nodo_id != auth()->user()->dinamizador->nodo_id && collect($user->roles)->contains('name', App\User::IsArticulador()) && $name == App\User::IsArticulador() ? 'onclick=this.checked=!this.checked;':
                                (isset($user->infocenter->nodo_id) && isset(auth()->user()->dinamizador->nodo_id) && $user->infocenter->nodo_id != auth()->user()->dinamizador->nodo_id && collect($user->roles)->contains('name', App\User::IsInfocenter()) && $name == App\User::IsInfocenter() ? 'onclick=this.checked=!this.checked;':
                                    (isset($user->apoyotecnico->nodo_id) && isset(auth()->user()->dinamizador->nodo_id) && $user->apoyotecnico->nodo_id != auth()->user()->dinamizador->nodo_id && collect($user->roles)->contains('name', App\User::IsApoyoTecnico()) && $name == App\User::IsApoyoTecnico() ? 'onclick=this.checked=!this.checked;':
                                        (isset($user->ingreso->nodo_id) && isset(auth()->user()->dinamizador->nodo_id) && $user->ingreso->nodo_id != auth()->user()->dinamizador->nodo_id && collect($user->roles)->contains('name', App\User::IsIngreso()) && $name == App\User::IsIngreso() ? 'onclick=this.checked=!this.checked;': '')
                                    )
                                )
                            )
                        )))) }}
                        value="{{ $name }}" id="test-{{ $name }}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input type="checkbox" name="role[]" {{ collect(old('role'))->contains($name) ? 'checked' : '' }}
                        value="{{ $name }}" id="test-{{ $name }}"
                        {{ $name == App\User::IsAdministrador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsActivador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDinamizador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDesarrollador() ? 'onclick=this.checked=!this.checked;' : ''))) }}
                        onchange="roles.getRoleSeleted(this)">
                @endif
            @break

            @case(App\User::IsExperto())
                @if (isset($user))
                    <input type="checkbox" name="role[]"
                        {{ collect(old('role', $user->roles->pluck('name')))->contains($name) ? 'checked' : '' }}
                        {{ $name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }}
                        value="{{ $name }}" id="test-{{ $name }}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input type="checkbox" name="role[]" {{ collect(old('role'))->contains($name) ? 'checked' : '' }}
                        value="{{ $name }}" id="test-{{ $name }}"
                        {{ $name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }}
                        onchange="roles.getRoleSeleted(this)">
                @endif
            @case(App\User::IsArticulador())
                @if (isset($user))
                    <input type="checkbox" name="role[]"
                        {{ collect(old('role', $user->roles->pluck('name')))->contains($name) ? 'checked' : '' }}
                        {{ $name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }}
                        value="{{ $name }}" id="test-{{ $name }}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input type="checkbox" name="role[]" {{ collect(old('role'))->contains($name) ? 'checked' : '' }}
                        value="{{ $name }}" id="test-{{ $name }}"
                        {{ $name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }}
                        onchange="roles.getRoleSeleted(this)">
                @endif
            @break

            @case(App\User::IsInfocenter())
                @if (isset($user))
                    <input type="checkbox" name="role[]"
                        {{ collect(old('role', $user->roles->pluck('name')))->contains($name) ? 'checked' : '' }}
                        {{ $name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }}
                        value="{{ $name }}" id="test-{{ $name }}" onchange="roles.getRoleSeleted(this)">
                @else
                    <input type="checkbox" name="role[]" {{ collect(old('role'))->contains($name) ? 'checked' : '' }}
                        value="{{ $name }}" id="test-{{ $name }}"
                        {{ $name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }}
                        onchange="roles.getRoleSeleted(this)">
                @endif
            @break

            @default
            @break
        @endswitch
        <label for="test-{{ $name }}">{{ $name }}</label>
    </p>
@empty
    <p class="p-v-xs">No tienes roles asignados</p>
@endforelse
@error('role')
    <div class="center">
        <label class="red-text error">{{ $message }}</label>
    </div>
@enderror
<small id="role-error" class="error red-text"></small>
