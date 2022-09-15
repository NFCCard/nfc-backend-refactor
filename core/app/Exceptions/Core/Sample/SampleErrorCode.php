<?php

    namespace App\Exceptions\Core\Sample;

    use App\Exceptions\Contracts\ErrorCode;

    class SampleErrorCode extends ErrorCode {
        protected static string $prefix = 'SECx';

        protected int $FAILED = 1;
    }
