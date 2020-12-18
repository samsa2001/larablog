<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponse;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        //dd($exception);
        //si estamos en entorno local queremos que muestre el error
        if(env('APP_ENV') == 'local'){
            return parent::render($request, $exception);
        }
        // si estamos en producción mostramos página personalizada para el error
        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse("Página no encontrada",404,"Página no encontrada");
        }
        if ($exception instanceof ModelNotFoundException) {
            return $this->errorResponse("Recurso no encontrado",401,"Recurso no encontrado");
        }
        // si el error no corresponde a ninguno de los listados muestra el error
        return parent::render($request, $exception);
    }
}
