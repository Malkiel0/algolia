<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Une liste des types d'exceptions qui ne sont pas signalées.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        // Ajoute ici les exceptions à ignorer
    ];

    /**
     * Une liste des entrées qui ne sont jamais flashées pour la validation.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Enregistre les callbacks pour la gestion des exceptions.
     */
    public function register(): void
    {
        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            // Gestion propre de la 404 : affiche la page custom Digit All
            return response()->view('errors.404', [], 404);
        });
    }
}
