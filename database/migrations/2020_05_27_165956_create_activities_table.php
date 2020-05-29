<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id_activities');
            $table->text ('name');
            $table->enum ('status',['realizado', 'pediente']);
            $table->dateTime ('date_execute',0);
            $table->integer('id_employees')->unsigned();
            $table->foreign ('id_employees')->references ('id_employees')->on ('employees');
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
        Schema::dropIfExists('activities');
    }
}
