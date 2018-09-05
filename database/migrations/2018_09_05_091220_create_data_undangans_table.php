<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataUndangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_undangans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->date('registration_date');
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->date('birth_date');
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
        Schema::dropIfExists('data_undangans');
    }
}
