<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Redirect;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using:function() {
            Route::prefix('admin')
            ->as('admin.')
            ->middleware('web')
            // ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));

            Route::prefix('owner')
            ->as('owner.')
            ->middleware('web')
            // ->namespace($this->namespace)
            ->group(base_path('routes/owner.php'));

            Route::prefix('/')
            ->as('user.')
            ->middleware('web')
            // ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'Constant' => App\Constants\Common::class,
        ]);
        $middleware->redirectGuestsTo(function(Request $request) {
            if(!$request->expectsJson() ){
                if(Route::is('owner.*')) {
                    return route('owner.login');
                }elseif(Route::is('admin.*')) {
                    return route('admin.login');
                }else{
                    return route('user.login');
                }
            };
        });
        // $middleware->append(Redirect::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
