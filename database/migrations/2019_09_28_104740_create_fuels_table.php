<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuels', function (Blueprint $table) {
            $table->string('id', 255)->primary();
            $table->string("dispenser_id", 255);
            $table->foreign("dispenser_id")->references("id")->on("dispensers")->onDelete("cascade")->onUpdate("cascade");
            $table->string("client_id", 255)->nullable();
            $table->foreign("client_id")->references("id")->on("clients")->onDelete("cascade")->onUpdate("cascade");
            $table->decimal("liter", 8, 2);
            $table->decimal("price", 8, 2);
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
        Schema::dropIfExists('fuels');
    }
}
