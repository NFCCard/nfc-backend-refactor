<?php

    namespace App\Models\Core;

    use App\Http\Resources\V1\Core\Profile\ProfileResource;
    use App\Http\Resources\V1\Core\User\UserCollection;
    use App\Http\Resources\V1\Core\User\UserResource;
    use App\Mail\ResetPasswordEmail;
    use App\Models\Contracts\Filtering\Filterable;
    use App\Models\Contracts\Filtering\Loadable;
    use App\Models\Contracts\ResourceCollectionable;
    use App\Models\Traits\Paginatable;
    use Hans\Alicia\Traits\AliciaRelationHandler;
    use Hans\Horus\HasRoles;
    use Hans\Horus\Models\Traits\HasRelations;
    use Hans\Sphinx\Traits\SphinxTrait;
    use Illuminate\Auth\Notifications\VerifyEmail;
    use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\HasOne;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;
    use Illuminate\Notifications\Notifiable;

    /**
     * @mixin IdeHelperUser
     */
    class User extends Authenticatable implements MustVerifyEmail, AuthenticatableContract, Filterable, Loadable, ResourceCollectionable {
        use HasFactory, Notifiable;
        use AliciaRelationHandler, HasRoles, HasRelations;

        use SphinxTrait, SphinxTrait {
            SphinxTrait::booted as private handleCaching;
        }
        use Paginatable;

        protected $table = 'core_users';
        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'username',
            'password',
            'version',
        ];

        /**
         * The attributes that should be hidden for serialization.
         *
         * @var array<int, string>
         */
        protected $hidden = [
            'password',
        ];

        /**
         * The attributes that should be cast.
         *
         * @var array<string, string>
         */
        protected $casts = [
            'version' => 'integer'
        ];

        public function getForeignKey() {
            return 'core_user_id';
        }


        protected static function booted() {
            self::handleCaching();
            self::created( fn( self $model ) => $model->profile()->create() );
        }

        public function profile(): HasOne {
            return $this->hasOne( Profile::class );
        }

        /**
         * Send the password reset notification.
         *
         * @param string $token
         *
         * @return void
         */
        public function sendPasswordResetNotification( $token ) {
            $this->notify( new ResetPasswordEmail( $token ) );
        }

        /**
         * Send the email verification notification.
         *
         * @return void
         */
        public function sendEmailVerificationNotification() {
            $this->notify( new VerifyEmail );
        }

        /**
         * count of logged-in users at a same time in one account
         *
         * @return int
         */
        public function getDeviceLimit(): int {
            return 2;
        }

        public function extract(): array {
            return [
                'name'     => $this->name,
                'username' => $this->username,
            ];
        }

        public static function username(): string {
            return 'username';
        }

        public function getFilterableAttributes(): array {
            return [
                'id',
                'name',
                'username',
            ];
        }

        public function getLoadableRelations(): array {
            return [
                'profile' => ProfileResource::class,
            ];
        }

        public static function getResource(): JsonResource {
            return UserResource::make( ...func_get_args() );
        }

        public function toResource(): JsonResource {
            return UserResource::make( $this, ... func_get_args() );
        }

        public static function getResourceCollection(): ResourceCollection {
            return UserCollection::make( ...func_get_args() );
        }
    }
