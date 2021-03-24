<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->onDelete('SET NULL');
            $table->foreignId('passenger_id')
                ->nullable()
                ->constrained('passengers')
                ->onDelete('SET NULL');
            $table->foreignId('sheet_id')
                ->nullable()
                ->constrained('airplane_has_sheets')
                ->onDelete('SET NULL');
            $table->string('booking_code');
            $table->string('ticket_code');
            $table->string('price');
            $table->string('total');
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
        Schema::dropIfExists('order_items');
    }
}
