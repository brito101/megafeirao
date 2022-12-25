<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableBannersAddCovers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('cover5')->nullable();
            $table->string('link5')->nullable();
            $table->string('cover6')->nullable();
            $table->string('link6')->nullable();
            $table->string('cover7')->nullable();
            $table->string('link7')->nullable();
            $table->string('cover8')->nullable();
            $table->string('link8')->nullable();
            $table->string('cover9')->nullable();
            $table->string('link9')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['cover5', 'link5', 'cover6', 'link6', 'cover7', 'link7', 'cover8', 'link8', 'cover9', 'link9']);
        });
    }
}
