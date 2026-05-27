<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['hospital', 'police', 'fire', 'ngo', 'helpline']);
            $table->string('phone');
            $table->string('city');
            $table->string('state');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('disaster_type', ['flood', 'earthquake', 'cyclone', 'fire', 'landslide', 'pandemic']);
            $table->json('items'); // [{label, checked}, ...]
            $table->timestamps();
        });

        Schema::create('tips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('body');
            $table->enum('disaster_type', ['flood', 'earthquake', 'cyclone', 'fire', 'landslide', 'pandemic', 'general']);
            $table->string('region')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tips');
        Schema::dropIfExists('checklists');
        Schema::dropIfExists('contacts');
    }
};
