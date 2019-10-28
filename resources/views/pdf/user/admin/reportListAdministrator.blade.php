@extends('pdf.illustrated-layout')
@section('title-file', 'Administradores '. config('app.name'))
@section('content-pdf')
<table class="striped centered">
    <thead>
        <tr>
            <th>
                Tipo Documento
            </th>
            <th>
                documento
            </th>
            <th>
                Nombre Completo
            </th>
            <th>
                Correo
            </th>
            <th>
                Telefono
            </th>
            <th>
                celular
            </th>
            <th>
                ocupacion
            </th>
            <th>
                fecha nacimiento
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Cedula
            </td>
            <td>
                1027890334
            </td>
            <td>
                julian Londoño
            </td>
            <td>
                jlondono433@gmail.com
            </td>
            <td>
                52455322
            </td>
            <td>
                6566346
            </td>
            <td>
                gtwdasd
            </td>
            <td>
                12/42/342
            </td>
        </tr>
    </tbody>
</table>
@endsection
