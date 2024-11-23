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
        Schema::create('conveniences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('ad_id');
            $table->index('ad_id', 'convenience_ad_idx');
            $table->foreign('ad_id', 'convenience_ad_fk')->on('ads')->references('id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conveniences');
    }
};
