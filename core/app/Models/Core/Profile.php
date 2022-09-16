<?php

    namespace App\Models\Core;

    use App\Http\Resources\V1\Core\Profile\ProfileCollection;
    use App\Http\Resources\V1\Core\Profile\ProfileResource;
    use App\Http\Resources\V1\Core\User\UserResource;
    use App\Models\BaseModel;
    use App\Models\Contracts\Filtering\Filterable;
    use App\Models\Contracts\Filtering\Loadable;
    use App\Models\Contracts\ResourceCollectionable;
    use App\Models\Traits\Paginatable;
    use Hans\Alicia\Traits\AliciaRelationHandler;
    use Illuminate\Database\Eloquent\Casts\Attribute;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;

    class Profile extends BaseModel implements Filterable, Loadable, ResourceCollectionable {
        use HasFactory;
        use Paginatable;
        use AliciaRelationHandler;

        protected $table = 'core_profiles';
        protected $fillable = [
            'phone',
            'email',
            'socials',

            'first_name',
            'last_name',
            'description',
        ];
        protected $casts = [
            'socials' => 'array',

            'first_name'  => 'array',
            'last_name'   => 'array',
            'description' => 'array',
        ];

        public function getForeignKey() {
            return 'core_profile_id';
        }

        public function userId(): Attribute {
            return new Attribute( get: fn() => $this->{( new User )->getForeignKey()} );
        }

        public function user(): BelongsTo {
            return $this->belongsTo( User::class, ( new User )->getForeignKey() );
        }

        public function getFilterableAttributes(): array {
            return [
                'id',
                'phone',
                'email',
            ];
        }

        public function getLoadableRelations(): array {
            return [
                'user' => UserResource::class,
            ];
        }

        public static function getResource(): JsonResource {
            return ProfileResource::make( ...func_get_args() );
        }

        public function toResource(): JsonResource {
            return ProfileResource::make( $this, ...func_get_args() );
        }

        public static function getResourceCollection(): ResourceCollection {
            return ProfileCollection::make( ...func_get_args() );
        }
    }
