<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference')->unique();
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('room_slug');
            $table->string('room_name');
            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedTinyInteger('guests')->default(1);
            $table->unsignedSmallInteger('nights')->default(1);
            $table->unsignedInteger('stay_total')->default(0);
            $table->unsignedInteger('resort_fee')->default(0);
            $table->unsignedInteger('taxes')->default(0);
            $table->unsignedInteger('grand_total')->default(0);
            $table->string('payment_method')->default('card');
            $table->string('status')->default('processing');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
