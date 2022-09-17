<?php

    namespace App\Http\Requests\V1\Core\Profile;

    use App\Helpers\Enums\LanguagesEnum;
    use App\Helpers\Enums\SocialsEnum;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class ProfileUpdateRequest extends FormRequest {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize() {
            return auth()->check();
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array<string, mixed>
         */
        public function rules() {
            return [
                'phone' => [ 'string', 'max:11' ],
                'email' => [ 'string', 'email' ],

                'socials'          => [ 'array' ],
                'socials.*.social' => [ 'required', 'string', Rule::in( SocialsEnum::toArray() ) ],
                'socials.*.url'    => [ 'required', 'string', 'url' ],

                'first_name'                                  => [
                    'array:' . implode( ',', LanguagesEnum::toArray() )
                ],
                'first_name.' . LanguagesEnum::ENGLISH => [
                    'string',
                    'max:255'
                ],
                'first_name.' . LanguagesEnum::FARSI => [
                    'string',
                    'max:255'
                ],

                'last_name'                                  => [
                    'array:' . implode( ',', LanguagesEnum::toArray() )
                ],
                'last_name.' . LanguagesEnum::ENGLISH => [
                    'string',
                    'max:255'
                ],
                'last_name.' . LanguagesEnum::FARSI => [
                    'string',
                    'max:255'
                ],

                'description'                                  => [
                    'array:' . implode( ',', LanguagesEnum::toArray() )
                ],
                'description.' . LanguagesEnum::ENGLISH => [
                    'string',
                ],
                'description.' . LanguagesEnum::FARSI => [
                    'string',
                ],
            ];
        }
    }
