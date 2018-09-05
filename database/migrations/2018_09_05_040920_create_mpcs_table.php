<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpcs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->date('registration_date');
            $table->string('ktp');
            $table->string('name');
            $table->string('gender');
            $table->string('address');
            $table->date('birth_date');
            $table->string('phone');
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
        Schema::dropIfExists('mpcs');
    }
}
