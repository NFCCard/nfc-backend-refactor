<?php

    use App\Http\Controllers\V1\Core\Profile\ProfileCrudController;
    use App\Http\Controllers\V1\Core\Profile\ProfileRelationsController;
    use App\Http\Controllers\V1\Core\Resource\ResourceController;
    use App\Http\Controllers\V1\Core\User\UserActionsController;
    use App\Http\Controllers\V1\Core\User\UserCrudController;
    use App\Http\Controllers\V1\Core\User\UserRelationsController;

    Route::apiResource( 'users', UserCrudController::class );
    Route::prefix( 'users' )->group( function() {
        Route::hasOne( 'profile', UserRelationsController::class, [ 'except' => [ 'update' ] ] );
        Route::prefix( '-actions' )->middleware( 'auth' )->group( function() {
            Route::post( '/{user}/create-vcf-file', [ UserActionsController::class, 'createVcfFile' ] );
        } );
    } );

    Route::apiResource( 'profiles', ProfileCrudController::class )->except( [ 'store', 'destroy' ] );
    Route::prefix( 'profiles' )->group( function() {
        Route::belongsTo( 'user', ProfileRelationsController::class, [ 'except' => [ 'update' ] ] );
        Route::belongsTo( 'resource', ProfileRelationsController::class );
    } );

    Route::post( 'upload/resource', [ ResourceController::class, 'store' ] )->middleware( 'auth' );
    Route::delete( 'upload/resource/{resource}', [ ResourceController::class, 'destroy' ] )->middleware( 'auth' );
