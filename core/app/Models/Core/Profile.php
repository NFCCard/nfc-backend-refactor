<?php

    namespace App\Models\Core;

    use Illuminate\Database\Eloquent\Casts\Attribute;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Profile extends Model {
        use HasFactory;

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

    }
