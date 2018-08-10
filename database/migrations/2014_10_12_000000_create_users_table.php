<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pessoa')->nullable();
            $table->string('email', 254)->nullable(false)->unique();
            $table->string('celular', 11)->default('');
            $table->string('senha', 128)->nullable(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        if (Schema::hasTable('pessoas')) 
        {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->foreign('id_pessoa')->references('id')->on('pessoas')
                ->onUpdate('CASCADE');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
