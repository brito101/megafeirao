<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutomotivesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('automotives', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('sale')->nullable()->default(1);
            $table->boolean('rent')->nullable();
            $table->string('category');
            $table->string('type')->nullable();
            $table->unsignedInteger('user');
            $table->boolean('status')->nullable();

            /** pricing and values */
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('rent_price', 10, 2)->nullable();
            $table->decimal('tribute', 10, 2)->nullable();

            /** description */
            $table->text('description')->nullable();
            $table->text('model')->nullable();
            $table->text('brand')->nullable();
            $table->text('year')->nullable();
            $table->text('mileage')->nullable();
            $table->text('gear')->nullable();
            $table->text('fuel')->nullable();
            $table->text('power')->nullable();
            $table->text('doors')->nullable();
            $table->text('direction')->nullable();
            $table->text('color')->nullable();

            /** address */
            $table->string('zipcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            /** structure */
            $table->boolean('air_conditioning')->nullable();
            $table->boolean('electric_glass')->nullable();
            $table->boolean('eletric_lock')->nullable();
            $table->boolean('sound')->nullable();

            $table->timestamps();

            $table->foreign('user')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('automotives');
    }

}
