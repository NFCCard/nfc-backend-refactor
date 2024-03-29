<?php

    namespace App\Http\Requests\V1\Core\User;

    use Illuminate\Foundation\Http\FormRequest;

    class UserUpdateRequest extends FormRequest {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize() {
            return user()->can( 'core-user-*' );
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array<string, mixed>
         */
        public function rules() {
            return [
                'password' => [ 'string', 'min:8', 'confirmed' ],
            ];
        }
    }
