<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteHasFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_has_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')
                ->nullable()
                ->constrained('routes')
                ->onDelete('SET NULL');
            $table->foreignId('facility_id')
                ->nullable()
                ->constrained('facilities')
                ->onDelete('SET NULL');
            $table->string('price');
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
        Schema::dropIfExists('route_has_facilities');
    }
}
