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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('rate');
            $table->unsignedBigInteger('ad_id');
            $table->unsignedBigInteger('user_id');
            $table->index('ad_id', 'review_ad_idx');
            $table->foreign('ad_id', 'review_ad_fk')->on('ads')->references('id');
            $table->index('user_id', 'review_user_idx');
            $table->foreign('user_id', 'review_user_fk')->on('users')->references('id');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
