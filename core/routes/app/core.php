<?php

    use App\Http\Controllers\V1\Core\User\UserCrudController;

    Route::apiResource( 'users', UserCrudController::class );
