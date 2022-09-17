<?php

    namespace App\Exceptions\Core\Profile;

    use App\Exceptions\Contracts\ErrorCode;

    class ProfileErrorCode extends ErrorCode {
        protected static string $prefix = 'PECx';

        protected int $FAILED_TO_UPDATE = 1;
        protected int $DOESNT_HAVE_USER = 2;
    }
