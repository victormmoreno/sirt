<?php

namespace App\Repositories\Repository\ProfileRepository;

use App\Models\Eps;
use App\Models\Ocupacion;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;

class ProfileRepository
{
    public function Update($request, $user)
    {
        $user->update([
            "tipodocumento_id"     => $request->input('txttipo_documento'),
            "gradoescolaridad_id"  => $request->input('txtgrado_escolaridad'),
            "gruposanguineo_id"    => $request->input('txtgruposanguineo'),
            "eps_id"               => $request->input('txteps'),
            "ciudad_id"            => $request->input('txtciudad'),
            "ciudad_expedicion_id" => $request->input('txtciudadexpedicion'),
            "nombres"              => $request->input('txtnombres'),
            "apellidos"            => $request->input('txtapellidos'),
            "documento"            => $request->input('txtdocumento'),
            "email"                => $request->input('txtemail'),
            "barrio"               => $request->input('txtbarrio'),
            "etnia_id"               => $request->input('txtetnias'),
            "grado_discapacidad"    => $request->input('txtgrado_discapacidad'),
            "descripcion_grado_discapacidad"    => $request->input('txtgrado_discapacidad') == 1 ? $request['txtdiscapacidad'] : null,
            "celular"              => $request->input('txtcelular'),
            "telefono"             => $request->input('txttelefono'),
            "fechanacimiento"      => $request->input('txtfecha_nacimiento'),
            "genero"               => $request->input('txtgenero'),
            "otra_eps"             => $request->input('txteps') == Eps::where('nombre', Eps::OTRA_EPS)->first()->id ? $request->input('txtotraeps') : null,
            "institucion"          => $request->input('txtinstitucion'),
            "titulo_obtenido"      => $request->get('txttitulo'),
            "fecha_terminacion"    => $request->get('txtfechaterminacion'),
            "estrato"              => $request->input('txtestrato'),
            "otra_ocupacion"       => collect($request->input('txtocupaciones'))->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id) ? $request->input('txtotra_ocupacion') : null,
        ]);
        $user->ocupaciones()->sync($request->get('txtocupaciones'));
        return $user;
    }

    public function updatePassword($request, User $user): User
    {
        $user->update([
            "password" => $request->input('newpassword'),
        ]);
        return $user;
    }

    public function downloadCertificated($user,  $extension = '.pdf', $orientacion = 'portrait'){
        try{
            $pdf = PDF::loadView('pdf.certificado-plataforma.certificado', compact('user'));
            $pdf->setPaper(strtolower('LETTER'),  $orientacion = 'landscape');
            $pdf->setEncryption($user->documento);
            return $pdf->download("certificado  " . config('app.name') . $extension);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
