<?php


    use App\Helpers\Enums\CacheEnum;
    use App\Models\Contracts\ResourceCollectionable;
    use App\Models\Core\Preference;
    use App\Models\Core\User;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Support\Optional;

    if ( ! function_exists( 'user' ) ) {
        function user(): User|Optional {
            return Auth::check() ? Auth::user() : optional();
        }
    }

    if ( ! function_exists( 'get_preference' ) ) {
        function get_preference( string $key, bool $fresh = false ) {
            if ( $fresh ) {
                try {
                    Cache::forever( CacheEnum::PREFIX->value . $key,
                        $value = Preference::firstWhere( 'key', $key )->value );

                    return $value;
                } catch ( Throwable $e ) {

                    return null;
                }
            }

            if ( $value = Cache::get( CacheEnum::PREFIX->value . $key ) ) {
                return $value;
            } else {
                try {
                    Cache::forever( CacheEnum::PREFIX->value . $key,
                        $value = Preference::firstWhere( 'key', $key )->value );

                    return $value;
                } catch ( Throwable $e ) {
                    return null;
                }
            }
        }
    }

    if ( ! function_exists( 'set_preference' ) ) {
        function set_preference( string $key, $value ): bool {
            try {
                $value = Preference::updateOrCreate( [ 'key' => $key ], [ 'value' => $value ] )->value;
                Cache::forever( CacheEnum::PREFIX->value . $key, $value );
            } catch ( Throwable $e ) {
                return false;
            }

            return true;
        }
    }

    if ( ! function_exists( 'set_batch_preferences' ) ) {
        function set_batch_preferences( array $preferences ): bool {
            try {
                foreach ( $preferences as $key => $value ) {
                    set_preference( $key, $value );
                }
            } catch ( Throwable $e ) {
                return false;
            }

            return true;
        }
    }

    if ( ! function_exists( 'generate_order' ) ) {
        // generates random order for factories
        function generate_order(): float {
            return rand( 111111, 999999 ) / 1000;
        }
    }

    if ( ! function_exists( 'resolveRelatedIdToModel' ) ) {
        function resolveRelatedIdToModel( int $related, string $entity, array $allowedEntities = null ): Model|false {
            if ( ! is_null( $allowedEntities ) and in_array( $entity, array_keys( $allowedEntities ) ) ) {
                return ( new $allowedEntities[ $entity ] )->findOrFail( $related );
            } elseif ( is_null( $allowedEntities ) and class_exists( $entity ) ) {
                return ( new $entity )->findOrFail( $related );
            }

            return false;
        }
    }

    if ( ! function_exists( 'resolveMorphableToResource' ) ) {
        function resolveMorphableToResource( Model $morphable ): JsonResource {
            if ( $morphable instanceof ResourceCollectionable ) {
                return $morphable->toResource();
            }

            return JsonResource::make( $morphable );
        }
    }

    if ( ! function_exists( 'slugify' ) ) {
        function slugify( $string, $separator = '-' ) {

            $_transliteration = [
                "/ö|œ/" => "e",

                "/ü/" => "e",

                "/Ä/" => "e",

                "/Ü/" => "e",

                "/Ö/" => "e",

                "/À|Á|Â|Ã|Å|Ǻ|Ā|Ă|Ą|Ǎ/" => "",

                "/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/" => "",

                "/Ç|Ć|Ĉ|Ċ|Č/" => "",

                "/ç|ć|ĉ|ċ|č/" => "",

                "/Ð|Ď|Đ/" => "",

                "/ð|ď|đ/" => "",

                "/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/" => "",

                "/è|é|ê|ë|ē|ĕ|ė|ę|ě/" => "",

                "/Ĝ|Ğ|Ġ|Ģ/" => "",

                "/ĝ|ğ|ġ|ģ/" => "",

                "/Ĥ|Ħ/" => "",

                "/ĥ|ħ/" => "",

                "/Ì|Í|Î|Ï|Ĩ|Ī| Ĭ|Ǐ|Į|İ/" => "",

                "/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/" => "",

                "/Ĵ/" => "",

                "/ĵ/" => "",

                "/Ķ/" => "",

                "/ķ/" => "",

                "/Ĺ|Ļ|Ľ|Ŀ|Ł/" => "",

                "/ĺ|ļ|ľ|ŀ|ł/" => "",

                "/Ñ|Ń|Ņ|Ň/" => "",

                "/ñ|ń|ņ|ň|ŉ/" => "",

                "/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/" => "",

                "/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/" => "",

                "/Ŕ|Ŗ|Ř/" => "",

                "/ŕ|ŗ|ř/" => "",

                "/Ś|Ŝ|Ş|Ș|Š/" => "",

                "/ś|ŝ|ş|ș|š|ſ/" => "",

                "/Ţ|Ț|Ť|Ŧ/" => "",

                "/ţ|ț|ť|ŧ/" => "",

                "/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/" => "",

                "/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/" => "",

                "/Ý|Ÿ|Ŷ/" => "",

                "/ý|ÿ|ŷ/" => "",

                "/Ŵ/" => "",

                "/ŵ/" => "",

                "/Ź|Ż|Ž/" => "",

                "/ź|ż|ž/" => "",

                "/Æ|Ǽ/" => "E",

                "/ß/" => "s",

                "/Ĳ/" => "J",

                "/ĳ/" => "j",

                "/Œ/" => "E",

                "/ƒ/" => ""
            ];

            $quotedReplacement = preg_quote( $separator, '/' );

            $merge = [

                '/[^\s\p{Zs}\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',

                '/[\s\p{Zs}]+/mu' => $separator,

                sprintf( '/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement ) => '',

            ];

            $map = $_transliteration + $merge;

            unset( $_transliteration );

            return preg_replace( array_keys( $map ), array_values( $map ), $string );

        }
    }

    if ( ! function_exists( 'logg' ) ) {
        function logg( string $location, Throwable $e, array $context = [] ) {
            Log::channel( 'starter' )->debug( $location . ' => ' . 'message: ' . $e->getMessage(), $context );
        }
    }
