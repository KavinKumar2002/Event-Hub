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
        Schema::create('fest', function (Blueprint $table) {
            $table->id();
            $table->string('fest_name')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('collegecode')->nullable();
            $table->string('image')->nullable();
            $table->text('details')->nullable();
            $table->decimal('pricesilver', 10, 2)->nullable();
            $table->integer('siindlimit')->nullable();
            $table->integer('sigrplimit')->nullable();
            $table->decimal('pricebronze', 10, 2)->nullable();
            $table->integer('brindlimit')->nullable();
            $table->integer('brgrplimit')->nullable();
            $table->decimal('pricegold', 10, 2)->nullable();
            $table->integer('goindlimit')->nullable();
            $table->integer('gogrplimit')->nullable();
            $table->string('upi')->nullable();
            $table->string('qrcode')->nullable();
            $table->tinyInteger('completed')->default(0);
            $table->integer('maxteamsize')->nullable();
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
        Schema::dropIfExists('fest');
    }
};
