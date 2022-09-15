<?php

    namespace App\Exceptions\Core\Profile;

    use App\Exceptions\BaseException;
    use Symfony\Component\HttpFoundation\Response;

    class ProfileException extends BaseException {

        public static function failedToUpdate(): BaseException {
            return self::make( 'Failed to update the profile!', ProfileErrorCode::failedToUpdate(),
                Response::HTTP_INTERNAL_SERVER_ERROR );
        }

    }
