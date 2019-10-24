<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->string('id', 255)->primary();
            $table->string("name", 70);
            $table->string("surname", 100);
            $table->unsignedInteger("birthday")->nullable();
            $table->string("car")->nullable();
            $table->string("license_plate", 50)->nullable();
            $table->unsignedSmallInteger("sync")->default(0);
            $table->float("bonus")->default(0);
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
        Schema::dropIfExists('clients');
    }
}
