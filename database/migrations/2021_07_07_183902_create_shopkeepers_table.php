<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopkeepersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopkeeper', function (Blueprint $table) {
            //Incluir colunas nome, email_unico, cnpj_unico e senha
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('id_document')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopkeeper');
    }
}
