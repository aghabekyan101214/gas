<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_stations', function (Blueprint $table) {
            $table->string('id', 255)->primary();
            $table->string("user_id", 255);
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->string("station_id", 255);
            $table->foreign("station_id")->references("id")->on("stations")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedSmallInteger("sync")->default(0);
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
        Schema::dropIfExists('admins_stations');
    }
}
