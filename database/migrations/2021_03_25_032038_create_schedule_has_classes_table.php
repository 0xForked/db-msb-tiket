<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleHasClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_has_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('airline_id')
                ->nullable()
                ->constrained('airlines')
                ->onDelete('SET NULL');
            $table->foreignId('class_id')
                ->nullable()
                ->constrained('classes')
                ->onDelete('SET NULL');
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
        Schema::dropIfExists('schedule_has_classes');
    }
}
