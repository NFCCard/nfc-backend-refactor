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

    }
