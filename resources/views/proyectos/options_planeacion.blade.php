@if (\Session::get('login_role') == App\User::IsGestor())
    <a href="{{route('proyecto.form.planeacion', $proyecto->id)}}" class="collection-item">
        <i class="material-icons left">library_books</i>
        Adjuntar entregables de la fase de planeación.
    </a>
@endif