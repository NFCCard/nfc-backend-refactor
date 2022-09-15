<?php

    namespace App\DTOs;

    use App\DTOs\Contracts\Dto;
    use Illuminate\Support\Collection;

    class MorphToDto extends Dto {

        protected function parse( array $data ): Collection {
            if ( ! isset( $data[ 'related' ] ) ) {
                return collect();
            }

            return collect( $data[ 'related' ][ 'entity' ] ?? [] );
        }
    }
