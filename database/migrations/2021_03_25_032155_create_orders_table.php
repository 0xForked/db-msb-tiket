<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('SET NULL');
            $table->foreignId('schedule_id')
                ->nullable()
                ->constrained('schedules')
                ->onDelete('SET NULL');
            $table->foreignId('covid_clinic_id')
                ->nullable()
                ->constrained('covid_clinics')
                ->onDelete('SET NULL');
            $table->date('date');
            $table->integer("delay")
                ->default(0);
            $table->integer("full_protection")
                ->default(0);
            $table->integer("free_protection")
                ->default(0);
            $table->integer("covid_insurance")
                ->default(0);
            $table->integer("baggage_insurance")
                ->default(0);
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
        Schema::dropIfExists('orders');
    }
}
