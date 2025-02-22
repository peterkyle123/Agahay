<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name'); // Name of the package (e.g., Small Group, VIP, Large Group)
            $table->text('description'); // Description of the package
            $table->decimal('price', 10, 2)->nullable(); // Extra guest price, nullable
            $table->decimal('initial_payment', 10, 2)->nullable(); // Extra guest price, nullable
            $table->integer('number_of_guests');
            $table->integer('number_of_days');
            $table->string('image');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
