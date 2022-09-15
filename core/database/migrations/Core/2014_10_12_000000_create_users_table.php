<?php

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
            Schema::create( ( new User )->getTable(), function( Blueprint $table ) {
                $table->id();
                $table->string( 'name' );
                $table->string( 'username' )->unique();
                $table->string( 'password' );
                $table->unsignedInteger( 'version' )->default( 1 );
                $table->timestamps();
            } );
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists( ( new User )->getTable() );
        }
    };
