<?php

    namespace Database\Factories\Core;

    use Illuminate\Database\Eloquent\Factories\Factory;
    use Illuminate\Support\Str;

    /**
     * @extends Factory
     */
    class UserFactory extends Factory {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition() {
            return [
                'username'             => $this->faker->unique()->userName(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'version'           => 1
            ];
        }

    }
