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
        Schema::create('accommodation_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_type_id')
                ->constrained('accommodation_types')
                ->cascadeOnDelete();
            $table->string('unit_code');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->enum('status',['available','occupied','maintenance','inactive']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_units');
    }
};
