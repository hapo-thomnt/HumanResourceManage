<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('firstname', 255)->nullable()->change();
            $table->string('lastname', 255)->nullable()->change();
            $table->integer('phone')->nullable()->change();
            $table->date('birthday')->nullable()->change();
            $table->string('avatar', 255)->nullable()->change();
            $table->string('address', 511)->nullable()->change();

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
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname', 255)->change();
            $table->string('lastname', 255)->change();
            $table->integer('phone')->change();
            $table->date('birthday')->change();
            $table->string('avatar', 255)->change();
            $table->string('address', 511)->change();

            $table->integer('created_by')->change();
            $table->integer('updated_by')->change();
        });
    }
}
