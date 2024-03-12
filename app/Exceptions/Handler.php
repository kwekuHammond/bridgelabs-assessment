<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
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

    public function render($request, Throwable $exception): Response|JsonResponse|RedirectResponse|\Symfony\Component\HttpFoundation\Response
    {
        if ($exception instanceof ModelNotFoundException) {
            return errorJsonResponse(message: 'Model resource not found', statusCode: Response::HTTP_NOT_FOUND);
        }
        if ($exception instanceof PostTooLargeException) {
            return errorJsonResponse(message: 'The request entity is too large', statusCode: Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
        }
        return parent::render($request, $exception);
    }
}
