<?php

    namespace App\Exceptions\Core\User;

    use App\Exceptions\Contracts\ErrorCode;

    class UserErrorCode extends ErrorCode {
        protected static string $prefix = 'UECx';

        protected int $FAILED_TO_CREATE = 1;
        protected int $FAILED_TO_UPDATE = 2;
        protected int $FAILED_TO_DELETE = 3;
    }
