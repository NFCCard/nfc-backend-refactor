<?php

    use App\Http\Controllers\V1\Core\Profile\ProfileCrudController;
    use App\Http\Controllers\V1\Core\User\UserCrudController;

    Route::apiResource( 'users', UserCrudController::class );

    Route::apiResource( 'profiles', ProfileCrudController::class )->except( [ 'store', 'destroy' ] );
