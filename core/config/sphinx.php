<?php
    return [
        'private_key'        => env( 'SPHINX_PRIVATE_KEY', 'mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=' ),
        // TODO: adjust the token and refresh token expiration time
        'expired_at'        => '+12 hour',
        'refreshExpired_at' => '+24 hour',

        'model' => \App\Models\Core\User::class
    ];
