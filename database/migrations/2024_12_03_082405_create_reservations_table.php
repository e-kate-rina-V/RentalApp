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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->date('arrival_date');
            $table->date('depart_date');
            $table->integer('nights_num');
            $table->integer('guestAdultCount');
            $table->integer('guestChildrenCount')->default(0);
            $table->integer('guestBabyCount')->default(0);
            $table->integer('guestPets')->default(0);
            $table->decimal('total_cost', 10, 2);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
