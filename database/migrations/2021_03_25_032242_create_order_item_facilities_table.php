<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')
                ->nullable()
                ->constrained('order_items')
                ->onDelete('SET NULL');
            $table->foreignId('facility_id')
                ->nullable()
                ->constrained('route_has_facilities')
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
        Schema::dropIfExists('order_item_facilities');
    }
}
