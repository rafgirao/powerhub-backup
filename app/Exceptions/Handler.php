<?php

namespace App\Exceptions;

use App\Services\Helper;
use Illuminate\Support\Facades\Log;
use Throwable;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
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
        (new Helper())->getAccountInfo();

        if ($this->shouldReport($exception)) {
            Log::debug('========BEGIN========')."\n".
            Log::debug(request()->fullUrl())."\n".
            Log::debug(session()->get('account') ?? "Usuário não logado")."\n".
//            Log::debug(implode(',',$_REQUEST))."\n".
            Log::debug($exception->getMessage())."\n".
            Log::debug('=========END=========');
        }

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
//        if ($this->isHttpException($exception)){
//            if ($exception->getStatusCode() == 404) {
//                return response()->view('error.404', [],'404');
//            }
//            if ($exception->getStatusCode() == 403) {
//                return response()->view('error.403', [],'403');
//            }
//            if ($exception->getStatusCode() == 401) {
//                return response()->view('error.401', [],'401');
//            }
//        }
//        if ($exception->getStatusCode() == 500) {
//            return response()->view('error.500', [],'500');
//        }
        return parent::render($request, $exception);
    }

//    public function register()
//    {
//        $this->renderable(function (Exception $e, $request) {
//            return response()->view('error.500', [],'500');
//        });
//    }
}
