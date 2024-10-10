<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('card_code_id')->constrained();
            $table->string('store_code')->unique()->nullable();
            $table->foreignId('user_id')->constrained();
            $table->string('customer_card_num')->unique();
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('contact');
            $table->date('bdate')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('zip')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('status');
            $table->date('validity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
