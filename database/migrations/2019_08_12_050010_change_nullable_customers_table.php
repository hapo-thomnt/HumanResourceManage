<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('company_id')->nullable()->change();
            $table->string('firstname')->nullable()->change();
            $table->string('lastname')->nullable()->change();
            $table->integer('phone')->nullable()->change();
            $table->date('birthday')->nullable()->change();
            $table->string('avatar')->nullable()->change();
            $table->string('address')->nullable()->change();
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
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('company_id')->change();
            $table->string('firstname')->change();
            $table->string('lastname')->change();
            $table->integer('phone')->change();
            $table->date('birthday')->change();
            $table->string('avatar')->change();
            $table->string('address')->change();
            $table->integer('created_by')->change();
            $table->integer('updated_by')->change();
        });
    }
}
