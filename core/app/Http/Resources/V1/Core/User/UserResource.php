<?php

    namespace App\Http\Resources\V1\Core\User;

    use App\Http\Resources\Traits\InteractsWithPivots;
    use App\Http\Resources\Traits\InteractsWithRelations;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserResource extends JsonResource {
        use InteractsWithRelations, InteractsWithPivots;

        /**
         * Transform the resource into an array.
         *
         * @param Request $request
         *
         * @return array
         */
        public function toArray( $request ) {
            $data = [
                'id'       => $this->id,
                'username' => $this->username,
            ];

            $data = $this->loadedRelations( $data );
            $data = $this->loadedPivots( $data );

            return $data;
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
