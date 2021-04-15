<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_usuario');            
            $table->string('codigo',50);
            $table->string('nombre_usuario',50);            
            $table->string('correo',100)->unique();
            $table->char('id_planta');
            $table->longText('contrasenia');
            $table->rememberToken();
            $table->timestamps('created_at');
            $table->timestamps('updated_at');           
        });

    }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
