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
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
                $table->foreignId('user_id')->constrained()->unique();
                $table->string('Influencer_code')->unique()->nullable();
                $table->string('card_code')->unique()->nullable();
                $table->string('blog_name');
                $table->string('blog_category');
                $table->string('zip')->nullable();
                $table->string('street');
                $table->string('city');
                $table->string('province');
                $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('influencers');
    }
};
