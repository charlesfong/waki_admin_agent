<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataOutsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_outsites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->date('registration_date');
            $table->string('name');
            $table->string('phone');
            $table->string('province')->nullable();
            $table->string('district')->nullable();
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
        Schema::dropIfExists('data_outsites');
    }
}
