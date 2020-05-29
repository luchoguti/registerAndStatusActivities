<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployyesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id_employees');
            $table->text ('first_name');
            $table->text ('second_name');
            $table->enum ('type_identification',['cedula ciudadania', 'Pasaporte', 'Tarjeta de identidad']);
            $table->integer ('number_identification');
            $table->integer('id_job_area')->unsigned();
            $table->foreign ('id_job_area')->references ('id_job_area')->on('jobs_area');
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
        Schema::dropIfExists('employees');
    }
}
