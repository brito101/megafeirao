<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCompaniesAddPhone extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('telephone')->nullable();
            $table->string('cell')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('companies', function (Blueprint $table) {
                $table->removeColumn('telephone');
                $table->removeColumn('cell');
        });
    }

}
