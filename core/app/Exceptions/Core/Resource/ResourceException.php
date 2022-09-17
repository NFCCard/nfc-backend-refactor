<?php

    namespace App\Exceptions\Core\Resource;

    use App\Exceptions\BaseException;
    use App\Exceptions\Core\Resource\ResourceErrorCode;
    use Symfony\Component\HttpFoundation\Response;

    class ResourceException extends BaseException {
        public static function failedToDelete(): BaseException {
            return self::make( 'Failed to delete the resource!', ResourceErrorCode::failedToDelete(),
                Response::HTTP_INTERNAL_SERVER_ERROR );
        }

    }
