<?php

    namespace App\Http\Resources\Core\Resource;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\ResourceCollection;

    class ResourcesCollection extends ResourceCollection {
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
    }
