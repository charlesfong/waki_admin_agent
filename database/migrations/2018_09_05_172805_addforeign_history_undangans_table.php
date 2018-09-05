<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddforeignHistoryUndangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_undangans', function (Blueprint $table) {
            $table->integer('data_undangan_id')->unsigned();
            $table->foreign('data_undangan_id')->references('id')->on('data_undangans');
            $table->integer('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->integer('cso_id')->unsigned();
            $table->foreign('cso_id')->references('id')->on('csos');
            $table->integer('type_cust_id')->unsigned();
            $table->foreign('type_cust_id')->references('id')->on('type_custs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_undangans', function (Blueprint $table) {
            $table->dropForeign(['data_undangan_id']);
            $table->dropColumn('data_undangan_id');
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
            $table->dropForeign(['cso_id']);
            $table->dropColumn('cso_id');
            $table->dropForeign(['type_cust_id']);
            $table->dropColumn('type_cust_id');
        });
    }
}
