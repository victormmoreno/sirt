<?php

namespace App\Http\Controllers;

use App\Models\ArchivoModel;
use Illuminate\Http\Request;
use Illuminate\Support\{Str, Facades\Session, Facades\Validator};
use App\Models\Nodo;
use App\Models\RutaModel;
use DOMDocument;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class MigracionController extends Controller
{
    private $errors = null;

    public function __construct()
    {
        $this->middleware(['auth', 'disablepreventback', 'role_session:Desarrollador']);
        $this->errors = null;
    }

    public function index()
    {
        return view('migrations.index', [
            'nodos' => Nodo::SelectNodo()->get()
        ]);
    }

    public function proyectos() {
        return view('migrations.proyectos', [
            'nodos' => Nodo::SelectNodo()->get()
        ]);
    }

    public function caracterizacion_proyectos() {
        return view('migrations.caracterizacion');
    }

    public function migrate_files() {
        return view('migrations.xml_files');
    }

    public function generate_xml_file(Request $request) {
        // 2024-03-14
        $xml = $this->getEncabezado();
        $files = $this->getFilesToXml($request);
        $xml = $this->getFileElement($request, $xml, $files);
        $xml .= $this->getPie();
        try {
            $dom = new DOMDocument;
            $dom->preserveWhiteSpace = false;
            $dom->loadXML($xml);
            $dom->formatOutput = true;
            Header('Content-disposition: attachment; filename="data.xml"');
            if ($this->errors != null) {
                Alert::error('Error!', $this->errors)->toHtml()->showConfirmButton('Ok', '#3085d6');
                return back();
            }
            return $dom->saveXML();
        } catch (\Throwable $th) {
            alert('Error', $th->getMessage(), 'error');
            throw $th;
            return back();
        }
    }

    /**
     * Retorna una colección con todos los archivos que se descargarán en el xml
     *
     * @param Request $request
     * @param ArchivoModel $archivo_model
     * @param RutaModel $ruta_model
     * @return Collection
     * @author dum
     **/
    public function getFilesToXml($request)
    {
        $archivo_model = ArchivoModel::whereBetween('created_at', [$request->txtarchivos_desde, $request->txtarchivos_hasta])->get();
        $ruta_model = RutaModel::whereNotNull('filesize')->whereBetween('created_at', [$request->txtarchivos_desde, $request->txtarchivos_hasta])->get();
        return $archivo_model->merge($ruta_model);
    }

    /**
     * Retorna los elementos de file con los archivos
     *
     * @param string $xml
     * @param $query Collecion con los archivos
     * @return string
     * @author dum
     **/
    private function getFileElement($request, $xml, $query)
    {
        $server_path = config('app.ftp.server_path');
        foreach ($query as $file_model) {
            $file = $this->getFileName($file_model);
            $dir = str_replace('storage', 'public', dirname($file_model->ruta));
            $size = $file_model->filesize;
            $local_file = $request->txtruta_guardado . $dir . '/' . $file['name'];
            $path = explode('/', $dir);
            array_shift($path);
            $remote_path = $server_path . $this->getRemotePath($path);
            $xml .= "<File>
            <LocalFile>$local_file</LocalFile>
            <RemoteFile>$file[name]</RemoteFile>
            <RemotePath>$remote_path</RemotePath>
            <Flags>32784</Flags>
            <Size>$size</Size>
            <Error>$file[msg]</Error>
            </File>";
        }
        return $xml;
    }

    /**
     * Retorna el nombre del archivo
     *
     * @param $file_model
     * @return array
     * @author dum
     **/
    private function getFileName($file_model)
    {
        $name = basename(url($file_model->ruta));
        if (Str::contains($name, ['&', ';'])) {
            $this->errors .= "El archivo {$file_model->id} de {$file_model->model_type} {$file_model->model_id} un error en el nombre (un carácter especial) <br>";
            return ['state' => false, 'msg' => "El archivo {$file_model->id} de {$file_model->model_type} {$file_model->model_id} un error en el nombre (un carácter especial)", 'name' => "Error"];
        } 
        return ['state' => true, 'msg' => "Ok", 'name' => $name];
    }
    
    /**
     * Retorna el path desde donde se descargará el archivo
     *
     * @param array $path
     * @return string
     * @author dum
     **/
    private function getRemotePath($path)
    {
        $p = '';
        foreach ($path as $value) {
            $p .= ' '. Str::length($value) .' '. $value;
        }
        return $p;
    }

    /**
     * Retorna el encabezado del archivo xml
     *
     * @return string
     * @author dum
     **/
    private function getEncabezado()
    {
        return "<?xml version='1.0' encoding='UTF-8'?>
        <FileZilla3 version='3.66.5' platform='windows'>
        <Queue>
        <Server>
        <Host>".config('app.ftp.host')."</Host>
        <Port>".config('app.ftp.port')."</Port>
        <Protocol>0</Protocol>
        <Type>0</Type>
        <User>".config('app.ftp.user')."</User>
        <Pass encoding='base64'>".config('app.ftp.password')."</Pass>
        <Logontype>1</Logontype>
        <PasvMode>MODE_DEFAULT</PasvMode>
        <EncodingType>Auto</EncodingType>
        <BypassProxy>0</BypassProxy>";
    }

    /**
     * Retorna el final del archivo xml
     *
     * @return string
     * @author dum
     **/
    private function getPie()
    {
        return "</Server>
        </Queue>
        </FileZilla3>";
    }

    public function import(Request $request)
    {
        abort('404');
    }
}
