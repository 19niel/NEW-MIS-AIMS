<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('asset_tag');
            $table->string('action_type');
            $table->text('description');
            $table->text('previous_value')->nullable();
            $table->text('new_value')->nullable();
            $table->foreignId('performed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_histories');
    }
};
