<?php

    use App\Http\Controllers\Auth\ForgotPasswordController;
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\Auth\RegisterController;
    use App\Http\Controllers\Auth\ResetPasswordController;
    use App\Http\Controllers\Auth\VerificationController;

    // guest routes
    Route::middleware( 'guest' )->group( function() {
        // Login Routes...
        Route::get( 'login', [ LoginController::class, 'showLoginForm' ] )->name( 'login' );
        Route::post( 'login', [ LoginController::class, 'login' ] );

        // Registration Routes...
        Route::get( 'register', [ RegisterController::class, 'showRegistrationForm' ] )->name( 'register' );
        Route::post( 'register', [ RegisterController::class, 'register' ] );

        // Password Reset Routes...
        Route::get( 'password/reset', [ ForgotPasswordController::class, 'showLinkRequestForm' ] )
             ->name( 'password.request' );
        Route::post( 'password/email', [ ForgotPasswordController::class, 'sendResetLinkEmail' ] )
             ->name( 'password.email' );
        Route::post( 'password/reset', [ ResetPasswordController::class, 'reset' ] )->name( 'password.update' );
    } );

    // Logout Routes...
    Route::post( 'logout', [ LoginController::class, 'logout' ] )->name( 'logout' );

    // authenticated routes
    Route::middleware( 'auth:web' )->group( function() {
        // Email Verification Routes...
        Route::middleware( 'throttle:6,1' )->group( function() {
            Route::get( 'email/verify', [ VerificationController::class, 'show' ] )->name( 'verification.notice' );
            Route::post( 'email/resend', [ VerificationController::class, 'resend' ] )->name( 'verification.resend' );
        } );
    } );
