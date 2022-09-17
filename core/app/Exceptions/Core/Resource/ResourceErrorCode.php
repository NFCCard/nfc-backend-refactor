<?php

    namespace App\Exceptions\Core\Resource;

    use App\Exceptions\Contracts\ErrorCode;

    class ResourceErrorCode extends ErrorCode {
        protected static string $prefix = 'RECx';

        protected int $FAILED_TO_DELETE = 1;
    }
