<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('prem_type');
            $table->string('accom_type');
            $table->integer('guest_count');
            $table->string('description');
            $table->float('price');
            $table->unsignedBigInteger('user_id');
            $table->index('user_id', 'ad_user_idx');
            $table->foreign('user_id', 'ad_user_fk')->on('users')->references('id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
