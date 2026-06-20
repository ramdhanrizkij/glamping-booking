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
        Schema::create('accomodation_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->integer('capacity');
            $table->integer('max_capacity');
            $table->string('bed_info')->nullable();
            $table->string('size_info')->nullable();
            $table->decimal('base_price',8,2);
            $table->decimal('extra_guest_price',8,2)->nullable()->default(0);
            $table->string('main_image')->nullable();
            $table->integer('sort_order')->default(0)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_types');
    }
};
