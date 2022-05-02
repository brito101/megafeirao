<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutomotiveImagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
       Schema::create('automotive_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('automotive');
            $table->string('path');
            $table->boolean('cover')->nullable();
            $table->timestamps();

            $table->foreign('automotive')->references('id')->on('automotives')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('automotive_images');
    }

}
