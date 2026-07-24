<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag')->unique();
            $table->foreignId('asset_category_id')->constrained('asset_categories')->onDelete('restrict');
            $table->foreignId('assigned_to')->nullable()->constrained('employees')->onDelete('set null');
            $table->string('serial_number')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('arrival_date')->nullable();
            $table->date('deployment_date')->nullable();
            $table->string('condition')->default('Available'); // Available, Active, Under Repair, Disposed
            $table->string('status')->default('Available'); // To track lifecycle
            $table->json('specifications')->nullable(); // For dynamic fields
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
