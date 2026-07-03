<?php

use App\Http\Middleware\EnsurePanelAccess;
use App\Http\Middleware\EnsurePanelPermission;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'panel' => EnsurePanelAccess::class,
            'panel.permission' => EnsurePanelPermission::class,
        ]);

        $middleware->redirectGuestsTo(fn () => route('panel.login'));
        $middleware->redirectUsersTo(fn () => route('panel.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
