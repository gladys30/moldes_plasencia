<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuscarRemision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP procedure if exists `mostrar_remisiones_enviadas`');
    
        DB::unprepared('

        CREATE PROCEDURE `buscar_remision`(
            IN `pa_fecha_inicio` DATE, 
            IN `pa_fecha_fin` DATE
        )
  
        BEGIN
        select *
          from remisiones
         where remisiones.fecha between pa_fecha_inicio AND pa_fecha_fin;
        END
        
        '); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
