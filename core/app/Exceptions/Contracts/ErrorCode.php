<?php

    namespace App\Exceptions\Contracts;

    use Illuminate\Support\Str;

    abstract class ErrorCode {
        protected static string $prefix = 'ECx';

        public function __get( string $name ) {
            return $this->{$name};
        }

        public static function __callStatic( string $name, array $arguments ) {
            $property = Str::upper( Str::snake( $name ) );
            if ( property_exists( static::class, $property ) ) {
                return static::$prefix . ( new static )->{$property};
            }

            return static::$prefix;
        }
    }
