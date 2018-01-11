<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_obra', function (Blueprint $table) {

            $table->increments('id');
            $table->string('n_inv')->unique();;
            $table->integer('id_artista')->unsigned();
            $table->string('titulo', 200);
            $table->string('tecnica', 200)->nullable();
            $table->string('dimension', 100)->nullable();
            $table->string('ano', 150)->nullable();
            $table->string('edicion', 200)->nullable();
            $table->string('procedencia',200)->nullable();
            $table->string('catalogo', 600)->nullable();
            $table->string('certificacion', 100)->nullable();
            $table->string('valoracion', 150)->nullable();
            $table->integer('id_ubica')->unsigned();
            $table->string('file1', 200)->nullable();
            $table->string('file2', 200)->nullable();
            $table->text('obs')->nullable();
            $table->timestamps();
        });

        Schema::table('sys_obra', function($table) {
            $table->foreign('id_ubica')->references('id')->on('sys_ubicaciones');
        });

        Schema::table('sys_obra', function($table) {
            $table->foreign('id_artista')->references('id')->on('sys_artista');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_obra');
    }
}
