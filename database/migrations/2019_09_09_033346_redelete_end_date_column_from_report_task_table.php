<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedeleteEndDateColumnFromReportTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_task', function (Blueprint $table) {
            if (  Schema::hasColumn('report_task', 'end_date')){
                $table->dropColumn('end_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_task', function (Blueprint $table) {
            Schema::table('report_task', function (Blueprint $table) {
                $table->string('end_date');
            });
        });
    }
}
