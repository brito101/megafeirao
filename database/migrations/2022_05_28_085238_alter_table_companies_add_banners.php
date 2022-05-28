<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCompaniesAddBanners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('main_banner')->nullable();
            $table->string('banner1')->nullable();
            $table->string('banner2')->nullable();
            $table->string('banner3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('main_banner');
            $table->dropColumn('banner1');
            $table->dropColumn('banner2');
            $table->dropColumn('banner3');
        });
    }
}
