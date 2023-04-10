<?php

namespace App\Http\Controllers\Help;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\Help\HelpRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\User;

class HelpController extends Controller
{
	public $helpRepostory;

    public function __construct(HelpRepository $helpRepostory)
    {
        $this->middleware('auth');
        $this->helpRepostory = $helpRepostory;
    }

    public function getCiudad($departamento = '1')
    {

        return response()->json([
            'ciudades' => $this->helpRepostory->getAllCiudadDepartamento($departamento),
        ]);
    }


    public function getCentrosRegional($regional = '1')
    {

        return response()->json([
            'centros' => $this->helpRepostory->getAllCentrosRegional($regional),
        ]);
    }

    public function downloadHandbook()
    {
        if (app()->environment() == 'production') {
            $path =   public_path(). "/documents/handbooks/". $this->base_sesion();
        }else{
            $path =   public_path(). "\documents\handbooks\\". $this->base_sesion();
        }
        if(!$this->downloadFile($path)){
            return redirect()->back();
        }
    }

    protected function downloadFile($src)
    {
        if(File::isFile($src)){
            $finfo =  finfo_open(FILEINFO_MIME_TYPE);
            $content_type = finfo_file($finfo, $src);
            finfo_close($finfo);
            $file_name = File::basename($src) . PHP_EOL;
            $size = File::size($src);
            header("Content-Type: $content_type");
            header("Content-Disposition: attachment; filename=$file_name");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: $size");
            readfile($src);
            return true;
        }
        return false;
    }

    protected function base_sesion()
    {
        switch (Session::get('login_role')) {
            case User::IsAdministrador():
                return "Manual_Usuario_Administrador.pdf";
                break;
            case User::IsActivador():
                return "Manual_Usuario_Administrador.pdf";
                break;
            case User::IsApoyoTecnico():
                return "Manual_Usuario_Apoyo_tecnico.pdf";
                break;
            case User::IsArticulador():
                return "Manual_Usuario_Articulador.pdf";
                break;
            case User::IsDinamizador():
                return "Manual_Usuario_Dinamizador.pdf";
                break;
            case User::IsExperto():
                return "Manual_Usuario_Experto.pdf";
                break;
            case User::IsInfocenter():
                return "Manual_Usuario_Infocenter.pdf";
                break;
            case User::IsTalento():
                return "Manual_Usuario_Talento.pdf";
                break;
            default:
                return "";
                break;
        }
    }
}
