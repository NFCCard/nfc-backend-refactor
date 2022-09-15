<?php

    namespace App\Models\Contracts;

    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;

    interface ResourceCollectionable {
        public static function getResource(): JsonResource;

        public function toResource(): JsonResource;

        public static function getResourceCollection(): ResourceCollection;
    }
