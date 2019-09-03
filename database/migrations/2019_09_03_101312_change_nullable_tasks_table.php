<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('code')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->string('description')->nullable()->change();
            $table->integer('status')->nullable()->change();
            $table->integer('created_by')->nullable()->change();
            $table->integer('updated_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('code')->change();
            $table->string('name')->change();
            $table->string('description')->change();
            $table->integer('status')->change();
            $table->integer('created_by')->change();
            $table->integer('updated_by')->change();
        });
    }
}
