<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAutomotivesTableAddTitleSlugHeadlineExperience extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('automotives', function (Blueprint $table) {
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('headline')->nullable();
            $table->string('experience')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('automotives', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('slug');
            $table->dropColumn('headline');
            $table->dropColumn('experience');
        });
    }

}
