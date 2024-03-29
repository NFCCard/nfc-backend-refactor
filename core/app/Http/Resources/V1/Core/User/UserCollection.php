<?php

    namespace App\Http\Resources\V1\Core\User;

    use App\Http\Resources\Traits\InteractsWithPivots;
    use App\Http\Resources\Traits\InteractsWithRelations;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\ResourceCollection;

    class UserCollection extends ResourceCollection {
        use InteractsWithRelations, InteractsWithPivots;

        /**
         * Transform the resource collection into an array.
         *
         * @param Request $request
         *
         * @return array
         */
        public function toArray( $request ) {
            return parent::toArray( $request );
        }

        /**
         * Get any additional data that should be returned with the resource array.
         *
         * @param Request $request
         *
         * @return array
         */
        public function with( $request ) {
            return [
                'type' => 'users',
            ];
        }

    }
