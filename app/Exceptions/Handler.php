<?php

namespace App\Exceptions;

use App\Models\ErrorLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception): void
    {
        if ($this->shouldReport($exception)) {
            $code = strtoupper(substr(md5(microtime()),rand(0,26),6));
            $userId = NULL;
            if(Auth::check()){
                $userId = Auth::user()->id;
            }

            // Simpan detail error ke database
            ErrorLog::create([
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'code' => $code,
                'user_id' => $userId,
            ]);

            $exception->errorCode = $code;
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return redirect()->guest(route('login.read'));
        }

        if ($exception instanceof AuthorizationException) {
            return redirect()->view('errors.401', [], 401);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        $code = $exception->errorCode ?? null;
        if (!$code) {
            return parent::render($request, $exception);
        }

        $data = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'code' => $code,
        ];

        return response()->view('errors.500', $data, 500);
    }
}
