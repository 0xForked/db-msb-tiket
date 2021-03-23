<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passenger_id')
                ->nullable()
                ->constrained('passengers')
                ->onDelete('SET NULL');
            $table->foreignId('country_id')
                ->nullable()
                ->constrained('countries')
                ->onDelete('SET NULL');
                
            $table->date('date_issued')->nullable();    
            $table->date('date_expired')->nullable();

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
        Schema::dropIfExists('passports');
    }
}
