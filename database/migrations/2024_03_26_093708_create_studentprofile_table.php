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
        Schema::create('studentprofile', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('regno')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('collegecode')->nullable();
            $table->string('department')->nullable();
            $table->string('password');
            $table->string('year');
            $table->string('image');
            $table->string('website')->nullable();
            $table->string('github')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('address')->nullable();
            $table->string('registeredfest')->nullable();
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
        Schema::dropIfExists('studentprofile');
    }
};
