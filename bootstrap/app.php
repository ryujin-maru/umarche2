<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using:function() {
            Route::prefix('admin')
            ->as('admin.')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('route/admin.php'));

            Route::prefix('owner')
            ->as('owner.')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('route/owner.php'));

            Route::prefix('/')
            ->as('user.')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('route/owner.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function(Request $request) {
            if(!$request->expectsJson() ){
                if(Route::is('owner.*')) {
                    return route('owner.login');
                }elseif(Route::is('admin.*')) {
                    return route('owner.login');
                }else{
                    return route('user.login');
                }
            };

            if(Auth::guard('user')->check() && $request->routeIs('user.*')) {
                return redirect('/dashboard');
            }

            if(Auth::guard('owner')->check() && $request->routeIs('owner.*')) {
                return redirect('/owner/dashboard');
            }

            if(Auth::guard('admin')->check() && $request->routeIs('admin.*')) {
                return redirect('/admin/dashboard');
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
