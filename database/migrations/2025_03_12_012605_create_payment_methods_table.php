<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Payment Method Name (e.g., GCASH, PayPal)
            $table->string('account_number'); // Account Number
            $table->string('account_name'); // Account Holder Name
            $table->boolean('display')->default(true); // Toggle Display Status
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('payment_methods');
    }
};
