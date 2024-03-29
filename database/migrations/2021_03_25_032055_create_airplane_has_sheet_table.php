<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirplaneHasSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airplane_has_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('airplane_id')
                ->nullable()
                ->constrained('airplanes')
                ->onDelete('SET NULL');
            $table->string('name');
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
        Schema::dropIfExists('airplane_has_sheets');
    }
}
