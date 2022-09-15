<?php

    namespace App\Helpers\Traits;

    use ReflectionClass;

    trait EnumHelper {
        public static function toArray(): array {
            $vars = collect();
            foreach ( ( new ReflectionClass( static::class ) )->getConstants() as $name => $value ):
                $vars->put( $name, $value->value );
            endforeach;

            return $vars->toArray();
        }

        public static function toArrayKeys(): array {
            $vars = collect();
            foreach ( ( new ReflectionClass( static::class ) )->getConstants() as $name => $value ):
                $vars->push( $name );
            endforeach;

            return $vars->toArray();
        }

        public static function all(): array {
            $vars = collect();
            foreach ( ( new ReflectionClass( static::class ) )->getConstants() as $name => $value ):
                $vars->put( $name, $value );
            endforeach;

            return $vars->toArray();
        }

        public static function IndexedAll(): array {
            $vars = collect();
            foreach ( ( new ReflectionClass( static::class ) )->getConstants() as $name => $value ):
                $vars->push( $value );
            endforeach;

            return $vars->toArray();
        }

        public static function tryFromKey( string $key, $default = null ) {
            if ( ( $position = array_search( strtoupper( $key ),
                    static::toArrayKeys() ) ) !== false ) {
                return static::IndexedAll()[ $position ];
            }

            return $default;
        }
    }
