<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->date('registration_date');
            $table->date('unregistration_date')->nullable();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('komisi')->default("0");
            $table->string('no_rekening')->default("-");
            $table->string('province');
            $table->string('district');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('csos');
    }
}
