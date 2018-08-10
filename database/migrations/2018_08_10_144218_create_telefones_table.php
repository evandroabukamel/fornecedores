<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelefonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telefones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pessoa')->nullable();
            $table->unsignedInteger('id_fornecedor')->nullable();
            $table->unsignedInteger('id_ponto_apoio')->nullable();
            $table->string('ddd', 3)->nullable(false);
            $table->string('numero', 10)->nullable(false);
            $table->foreign('id_pessoa')->references('id')->on('pessoas')
                ->onUpdate('CASCADE');
            $table->foreign('id_fornecedor')->references('id')->on('pessoas')
                ->onUpdate('CASCADE');
            $table->foreign('id_ponto_apoio')->references('id')->on('pessoas')
                ->onUpdate('CASCADE');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telefones');
    }
}
