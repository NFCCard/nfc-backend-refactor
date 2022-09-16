<?php

    namespace App\Http\Controllers\V1\Core\User;

    use App\Http\Controllers\Controller;
    use Carbon\Carbon;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
    use League\Flysystem\FilesystemException;

    class UserActionsController extends Controller {
        //

        /**
         * @throws FilesystemException
         */
        public function createVcfFile() {
            user()->loadMissing( 'profile' );

            $phone = user()->profile->phone;
            if ( Str::startsWith( $phone, '0' ) ) {
                $phone = Str::after( $phone, '0' );
            }
            // vcf file content
            $vcf = sprintf(
                "BEGIN:VCARD
VERSION:3.0
N:;%s;;;
FN:%s
item1.TEL;waid=98%s:+98 %s
item1.X-ABLabel:Mobile
X-WA-BIZ-NAME:%s
END:VCARD",
                user()->username,
                Arr::get( Arr::wrap( user()->profile->first_name ), 'fa',
                    user()->profile->first_name[ 'en' ] ?? 'set a name for your profile.' ),
                $phone,
                $phone,
                user()->username
            );

            // store the file in temporary folder
            $storage = Storage::disk( 'local' );
            $file    = user()->username . '-' . Carbon::now()->format( 'y-m-d-h-i' ) . '.vcf';
            $storage->write( $path = 'temporary/' . $file, $vcf );

            return response()->download( $storage->path( $path ) )->deleteFileAfterSend( true );
        }
    }
