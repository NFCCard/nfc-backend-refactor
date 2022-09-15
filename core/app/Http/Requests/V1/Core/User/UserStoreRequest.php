<?php

    namespace App\Http\Requests\V1\Core\User;

    use App\Models\Core\User;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class UserStoreRequest extends FormRequest {
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
                'username' => [ 'required', 'string', 'min:5', Rule::unique( User::class, 'username' ) ],
                'password' => [ 'required', 'string', 'min:8', 'confirmed' ],
            ];
        }
    }
