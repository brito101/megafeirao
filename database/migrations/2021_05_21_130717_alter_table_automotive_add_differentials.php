<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAutomotiveAddDifferentials extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('automotives', function (Blueprint $table) {
            /** structure */
            $table->boolean('airbag')->nullable();
            $table->boolean('armored')->nullable();
            $table->boolean('electric_steering')->nullable();
            $table->boolean('hydraulic_steering')->nullable();
            $table->boolean('abs_brakes')->nullable();
            $table->boolean('electric_rear_view')->nullable();
            $table->boolean('rain_sensor')->nullable();
            $table->boolean('parking_sensor')->nullable();
            $table->boolean('headlight_sensor')->nullable();
            $table->boolean('sunroof')->nullable();
            $table->boolean('traction')->nullable();
            $table->boolean('electric_trio')->nullable();
            $table->boolean('electric_front')->nullable();
            $table->boolean('steering_wheel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('automotives', function (Blueprint $table) {
              /** structure */
            $table->dropColumn('airbag');
            $table->dropColumn('armored');
            $table->dropColumn('electric_steering');
            $table->dropColumn('hydraulic_steering');
            $table->dropColumn('abs_brakes');
            $table->dropColumn('electric_rear_view');
            $table->dropColumn('rain_sensor');
            $table->dropColumn('parking_sensor');
            $table->dropColumn('headlight_sensor');
            $table->dropColumn('sunroof');
            $table->dropColumn('traction');
            $table->dropColumn('electric_trio');
            $table->dropColumn('electric_front');
            $table->dropColumn('steering_wheel');
        });
    }

}
