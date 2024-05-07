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
        Schema::create('regevent', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('dept')->nullable();
            $table->string('eventdept')->nullable();
            $table->string('registered_event')->nullable();
            $table->string('regno')->nullable();
            $table->string('fest');
            $table->integer('mark')->nullable();
            $table->string('email')->nullable();
            $table->string('eventtype')->nullable();
            $table->string('payment')->nullable();
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
        Schema::dropIfExists('regevent');
    }
};
