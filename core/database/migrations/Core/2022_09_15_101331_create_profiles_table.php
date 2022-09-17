<?php

    use App\Models\Core\Profile;
    use App\Models\Core\User;
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create( ( new Profile )->getTable(), function( Blueprint $table ) {
                $table->id();
                $table->foreignIdFor( User::class )->constrained()->cascadeOnDelete();

                $table->string( 'phone' )->nullable();
                $table->string( 'email' )->nullable();
                $table->string( 'socials', 1024 )->nullable();

                // multi-languages columns
                $table->text( 'first_name' )->nullable();
                $table->text( 'last_name' )->nullable();
                $table->text( 'description' )->nullable();

                $table->timestamps();
            } );
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists( ( new Profile )->getTable() );
        }
    };
