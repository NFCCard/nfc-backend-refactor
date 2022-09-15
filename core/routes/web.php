<?php

    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\Auth\ResetPasswordController;
    use App\Http\Controllers\Auth\VerificationController;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
    if ( env( 'SOCIALITE_STATUS', false ) ) {
        Route::prefix( 'auth' )->middleware( 'throttle:6,1' )->group( function() {
            Route::get( '/google/callback', [ LoginController::class, 'googleCallback' ] )
                 ->name( 'login.google.callback' );
        } );
    }

    if ( env( 'WEB_AUTH_STATUS', false ) ) {
        Route::group( [], __DIR__ . '/authentication/web.php' );
    }

    // email verification route
    Route::get( 'email/verify/{id}/{hash}', [ VerificationController::class, 'verify' ] )
         ->domain( env( 'SPA_APP_DOMAIN', 'spa' ) )
         ->name( 'verification.verify' );//->middleware( 'signed' );
    // password reset form
    Route::get( 'password/reset/{token}', [ ResetPasswordController::class, 'showResetForm' ] )
         ->domain( env( 'SPA_APP_DOMAIN', 'spa' ) )
         ->name( 'password.reset' );
