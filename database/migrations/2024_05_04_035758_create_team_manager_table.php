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
        Schema::create('team_manager', function (Blueprint $table) {
            $table->id();
            $table->string('team_name')->nullable();
            $table->string('fest')->nullable();
            $table->string('event')->nullable();
            $table->json('team_members')->nullable();
            $table->string('userreg')->nullable();
            $table->string('type')->nullable();
            $table->string('team_leader_name')->nullable();
            $table->string('team_leader_regno')->nullable();
            $table->string('team_leader_email')->nullable();
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
        Schema::dropIfExists('team_manager');
    }
};
