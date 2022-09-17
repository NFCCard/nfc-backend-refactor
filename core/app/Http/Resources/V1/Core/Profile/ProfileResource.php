<?php

    namespace App\Http\Resources\V1\Core\Profile;

    use App\Http\Resources\Traits\InteractsWithPivots;
    use App\Http\Resources\Traits\InteractsWithRelations;
    use App\Http\Resources\V1\Core\Resource\ResourcesResource;
    use App\Repositories\Contracts\Core\IProfileRepository;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class ProfileResource extends JsonResource {
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
                'id'          => $this->id,
                'user_id'     => $this->user_id,
                'phone'       => $this->phone,
                'email'       => $this->email,
                'socials'     => $this->socials,
                'first_name'  => $this->first_name,
                'last_name'   => $this->last_name,
                'description' => $this->description,
                'resource'    => ResourcesResource::make( app( IProfileRepository::class )->viewResource( $this->resource ) ),
            ];

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
                'type' => 'profiles',
            ];
        }
    }
