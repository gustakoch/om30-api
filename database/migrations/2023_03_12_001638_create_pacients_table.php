<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacients', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('full_name');
            $table->string('mother_full_name');
            $table->date('birth_day');
            $table->string('cpf');
            $table->string('cns');
            $table->unsignedBigInteger('id_address');
            $table->timestamps();
        });

        Schema::table('pacients', function(Blueprint $table) {
            $table->foreign('id_address')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacients');
    }
}
