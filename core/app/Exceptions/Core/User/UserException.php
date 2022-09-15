<?php

    namespace App\Exceptions\Core\User;

    use App\Exceptions\BaseException;
    use Symfony\Component\HttpFoundation\Response;

    class UserException extends BaseException {
        public static function failedToCreate(): BaseException {
            return self::make( 'Failed to create the user!', UserErrorCode::failedToCreate(),
                Response::HTTP_INTERNAL_SERVER_ERROR );
        }

        public static function failedToUpdate(): BaseException {
            return self::make( 'Failed to update the user!', UserErrorCode::failedToUpdate(),
                Response::HTTP_INTERNAL_SERVER_ERROR );
        }

        public static function failedToBatchUpdate(): BaseException {
            return self::make( 'Failed to batch update the user!',
                UserErrorCode::failedToBatchUpdate(),
                Response::HTTP_INTERNAL_SERVER_ERROR );
        }

        public static function failedToDelete(): BaseException {
            return self::make( 'Failed to delete the user!', UserErrorCode::failedToDelete(),
                Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
