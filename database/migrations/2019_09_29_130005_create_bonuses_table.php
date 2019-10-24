<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonuses', function (Blueprint $table) {
            $table->string('id', 255)->primary();
            $table->float("bonus");
            $table->string("fuel_id", 255);
            $table->foreign("fuel_id")->references("id")->on("fuels")->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('bonuses');
    }
}
