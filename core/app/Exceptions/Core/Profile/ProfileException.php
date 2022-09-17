<?php

    namespace App\Exceptions\Core\Profile;

    use App\Exceptions\BaseException;
    use Symfony\Component\HttpFoundation\Response;

    class ProfileException extends BaseException {

        public static function failedToUpdate(): BaseException {
            return self::make( 'Failed to update the profile!', ProfileErrorCode::failedToUpdate(),
                Response::HTTP_INTERNAL_SERVER_ERROR );
        }

        public static function doesntHaveUser(): BaseException {
            return self::make( "The profile doesn't have any user!",
                ProfileErrorCode::doesntHaveUser(), Response::HTTP_NOT_FOUND );
        }

        public static function doesntHaveResource(): BaseException {
            return self::make( "The profile doesn't have any resource!",
                ProfileErrorCode::doesntHaveResource(), Response::HTTP_NOT_FOUND );
        }

        public static function failedToUpdateResource(): BaseException {
            return self::make( "Failed to update profile's resource!",
                ProfileErrorCode::failedToUpdateResource(), Response::HTTP_INTERNAL_SERVER_ERROR );
        }

    }
