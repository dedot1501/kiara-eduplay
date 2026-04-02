<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // Tambahkan ini agar Laravel tidak error saat menangani request di Vercel
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->booting(function () {
        // Trik Sakti: Paksa folder cache dan logs ke folder /tmp milik Vercel
        $paths = [
            'bootstrap.cache' => '/tmp/storage/bootstrap/cache',
            'framework.sessions' => '/tmp/storage/framework/sessions',
            'framework.views' => '/tmp/storage/framework/views',
            'framework.cache' => '/tmp/storage/framework/cache',
            'logs' => '/tmp/storage/logs',
        ];

        foreach ($paths as $key => $path) {
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            config()->set("cache.stores.file.path", $path);
        }

        // Paksa log ke stderr agar muncul di dashboard Vercel
        config()->set('logging.default', 'stderr');
    })
    ->create();