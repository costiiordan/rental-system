<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->dateTime('from_date')->index();
            $table->dateTime('to_date')->index();
            $table->string('note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::drop('item_bookings');
    }
};
