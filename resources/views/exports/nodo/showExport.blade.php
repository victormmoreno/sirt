<table>
    <thead>
        <tr>
            <th>Nodo</th>
            <th>Rol</th>
            <th>Linea</th>
            <th>Número de documento</th>
            <th>Funcionario</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Celular</th>
            <th>Tipo Vinculación</th>
            <th>Número de contrato</th>
            <th>Fecha inicio contrato</th>
            <th>Fecha finalización contrato</th>
            <th>Valor contrato</th>
            <th>Honorarios mensuales</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->nodo }}</td>
                <td>{{ $user->roles }}</td>
                <td>{{ !is_null($user->linea) ? $user->linea : 'No Aplica' }}</td>
                <td>{{ $user->documento }}</td>
                <td>{{ $user->nombres }} {{ $user->apellidos }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->telefono }}</td>
                <td>{{ $user->celular }}</td>
                <td>{{ $user->vinculacion }}</td>
                <td>{{
                    (isset($user->dinamizadorContratoLatest) ? $user->dinamizadorContratoLatest->codigo :
                        (isset($user->expertoContratoLatest) ? $user->expertoContratoLatest->codigo :
                            (isset($user->articuladorContratoLatest) ? $user->articuladorContratoLatest->codigo :
                                (isset($user->infocenterContratoLatest) ? $user->infocenterContratoLatest->codigo :
                                    (isset($user->apoyoTecnicoContratoLatest) ? $user->apoyoTecnicoContratoLatest->codigo :
                                        (isset($user->ingresoContratoLatest) ? $user->ingresoContratoLatest->codigo :'No registra')
                                    )
                                )
                            )
                        )
                    )
                }}</td>
                <td>{{
                    (isset($user->dinamizadorContratoLatest) ? $user->dinamizadorContratoLatest->fecha_inicio :
                        (isset($user->expertoContratoLatest) ? $user->expertoContratoLatest->fecha_inicio :
                            (isset($user->articuladorContratoLatest) ? $user->articuladorContratoLatest->fecha_inicio :
                                (isset($user->infocenterContratoLatest) ? $user->infocenterContratoLatest->fecha_inicio :
                                    (isset($user->apoyoTecnicoContratoLatest) ? $user->apoyoTecnicoContratoLatest->fecha_inicio :
                                        (isset($user->ingresoContratoLatest) ? $user->ingresoContratoLatest->fecha_inicio :'No registra')
                                    )
                                )
                            )
                        )
                    )
                }}</td>
                <td>{{
                    (isset($user->dinamizadorContratoLatest) ? $user->dinamizadorContratoLatest->fecha_finalizacion :
                        (isset($user->expertoContratoLatest) ? $user->expertoContratoLatest->fecha_finalizacion :
                            (isset($user->articuladorContratoLatest) ? $user->articuladorContratoLatest->fecha_finalizacion :
                                (isset($user->infocenterContratoLatest) ? $user->infocenterContratoLatest->fecha_finalizacion :
                                    (isset($user->apoyoTecnicoContratoLatest) ? $user->apoyoTecnicoContratoLatest->fecha_finalizacion :
                                        (isset($user->ingresoContratoLatest) ? $user->ingresoContratoLatest->fecha_finalizacion :'No registra')
                                    )
                                )
                            )
                        )
                    )
                }}</td>
                <td>{{
                    (isset($user->dinamizadorContratoLatest) ? number_format($user->dinamizadorContratoLatest->valor_contrato, 2) :
                        (isset($user->expertoContratoLatest) ? number_format($user->expertoContratoLatest->valor_contrato, 2) :
                            (isset($user->articuladorContratoLatest) ? number_format($user->articuladorContratoLatest->valor_contrato, 2) :
                                (isset($user->infocenterContratoLatest) ? number_format($user->infocenterContratoLatest->valor_contrato, 2) :
                                    (isset($user->apoyoTecnicoContratoLatest) ? number_format($user->apoyoTecnicoContratoLatest->valor_contrato, 2) :
                                        (isset($user->ingresoContratoLatest) ? number_format($user->ingresoContratoLatest->valor_contrato, 2) :'No registra')
                                    )
                                )
                            )
                        )
                    )
                }}</td>
                <td>{{ number_format($user->honorarios,2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


