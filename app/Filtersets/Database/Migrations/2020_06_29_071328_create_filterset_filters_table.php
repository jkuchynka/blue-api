<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltersetFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filterset_filters', function (Blueprint $table) {
            $table->id();
            $table->string('field');
            $table->string('operator');
            $table->string('value')->nullable();
            $table->bigInteger('filterset_id')->unsigned();
            $table->timestamps();

            $table->foreign('filterset_id')
                  ->references('id')
                  ->on('filtersets')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filterset_filters');
    }
}
