<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQrCodeImageToPaymentMethodsTable extends Migration
{
    public function up()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            // Add a nullable string column for the QR code image, placed after the account_name column.
            $table->string('qr_code_image')->nullable()->after('account_name');
        });
    }

    public function down()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('qr_code_image');
        });
    }
}
