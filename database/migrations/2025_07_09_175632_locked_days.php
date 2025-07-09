<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locked_days', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locked_days');
    }
};
