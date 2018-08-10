<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_endereco')->nullable();
            $table->unsignedInteger('id_ponto_apoio')->nullable();
            $table->string('nome', 200)->nullable(false);
            $table->string('cpf', 11)->nullable(false);
            $table->date('data_nascimento');
            $table->timestamps();
            $table->softDeletes();
        });
        
        if (Schema::hasTable('usuarios')) 
        {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->foreign('id_pessoa')->references('id')->on('pessoas')
                    ->onUpdate('CASCADE');
            });
        }
        if (Schema::hasTable('enderecos')) 
        {
            Schema::table('enderecos', function (Blueprint $table) {
                $table->foreign('id_endereco')->references('id')->on('enderecos')
                    ->onUpdate('CASCADE');
            });
        }
        if (Schema::hasTable('pontos_apoio')) 
        {
            Schema::table('pontos_apoio', function (Blueprint $table) {
                $table->foreign('id_ponto_apoio')->references('id')->on('pontos_apoio')
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
        Schema::dropIfExists('pessoas');
    }
}
