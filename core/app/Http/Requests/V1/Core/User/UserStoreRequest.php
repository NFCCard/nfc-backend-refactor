<?php

    namespace App\Http\Requests\V1\Core\User;

    use App\Models\Core\User;
    use Hans\Horus\Models\Role;
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
                'role_id'  => [ 'numeric', Rule::exists( Role::class, 'id' ) ],
                'password' => [ 'required', 'string', 'min:8', 'confirmed' ],
            ];
        }
    }
