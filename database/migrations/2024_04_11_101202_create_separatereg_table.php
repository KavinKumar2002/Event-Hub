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
        Schema::create('separatereg', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('fest')->nullable();
            $table->string('event')->nullable();
            $table->string('regno')->nullable();
            $table->integer('mark')->nullable();
            $table->string('certificates')->nullable();
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
        Schema::dropIfExists('separatereg');
    }
};
