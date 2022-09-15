<?php

    use App\Http\Controllers\Auth\LoginController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */

    if ( env( 'SOCIALITE_STATUS', false ) ) {
        Route::get( '/login/using/google', [ LoginController::class, 'google' ] )->name( 'login.google' );
    }

    Route::group( [], __DIR__ . '/authentication/api.php' );

