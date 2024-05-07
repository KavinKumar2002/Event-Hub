<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventdetail', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cost')->nullable();
            $table->string('fest')->nullable();
            $table->string('event_id')->nullable();
            $table->text('rules')->nullable();
            $table->text('details')->nullable();
            $table->string('department')->nullable();
            $table->string('type')->nullable();
            $table->string('image')->nullable();
            $table->string('eventtype')->nullable();
            $table->string('payment')->nullable();
            $table->integer('teamsize')->nullable();
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
        Schema::dropIfExists('eventdetail');
    }
};
