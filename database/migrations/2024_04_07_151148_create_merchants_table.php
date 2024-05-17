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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->unique();
            // $table->foreignId('enterprise_id')->constrained()->unique();
            $table->string('business_code')->unique()->nullable();
            $table->string('card_code')->unique()->nullable();
            $table->string('dti')->nullable();
            $table->string('business_name');
            $table->string('business_category');
            $table->string('business_sub_category');
            $table->string('discount')->nullable();
            $table->integer('stars_points')->default(0);
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
        Schema::dropIfExists('merchants');
    }
};
