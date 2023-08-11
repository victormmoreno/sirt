<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Traits\ApiResponser;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->route('login');
        }
        if ($exception instanceof \League\Flysystem\FileNotFoundException) {
            return abort(404);
        }
        if ($request->fullUrlIs($request->root() . '/ideas')) {
            return redirect()->route('idea.create');
        }
        //Control excepciones api
        if(Str::contains($request->url(), $request->root().'/api/')){
            if($exception instanceof NotFoundHttpException){
                return $this->errorResponse('página no encontrada', 404);
            }
            if($exception instanceof MethodNotAllowedHttpException){
                return $this->errorResponse('El método especificado en la petición no es válido', 405);
            }
            if($exception instanceof HttpException){
                return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
            }
            if($exception instanceof HttpException){
                return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
            }

        }
        return parent::render($request, $exception);
    }
}
