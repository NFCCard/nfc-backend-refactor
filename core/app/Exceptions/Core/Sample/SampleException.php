<?php

    namespace App\Exceptions\Core\Sample;

    use App\Exceptions\BaseException;
    use Symfony\Component\HttpFoundation\Response;

    class SampleException extends BaseException {
        public static function failed() {
            return self::make( 'Failed! please try again later.', SampleErrorCode::failed(),
                Response::HTTP_FORBIDDEN );
        }
    }
