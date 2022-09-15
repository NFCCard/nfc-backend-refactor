<?php

    namespace App\Rules;

    use Illuminate\Contracts\Validation\ImplicitRule;
    use Illuminate\Contracts\Validation\Rule;
    use Illuminate\Support\Arr;
    use Illuminate\Validation\Validator;

    class Order implements Rule, ImplicitRule {
        private bool $required;
        private Validator $validator;

        /**
         * Create a new rule instance.
         *
         * @return void
         */
        public function __construct( bool $required = true ) {
            $this->required = $required;
        }

        /**
         * Determine if the validation rule passes.
         *
         * @param string $attribute
         * @param mixed  $value
         *
         * @return bool
         */
        public function passes( $attribute, $value ) {
            if ( ! $this->required and is_null( $value ) ) {
                return true;
            }
            if ( request()->method() == 'DELETE' ) {
                return true;
            }
            $this->validator = app( Validator::class,
                [
                    'data'  => Arr::undot( [ $attribute => $value ] ),
                    'rules' => [
                        $attribute => [
                            'bail',
                            'required',
                            'numeric',
                            'max:999.999'
                        ]
                    ]
                ] );

            return $this->validator->passes();
        }

        /**
         * Get the validation error message.
         *
         * @return string
         */
        public function message() {
            return $this->validator->errors()->first();
        }
    }
