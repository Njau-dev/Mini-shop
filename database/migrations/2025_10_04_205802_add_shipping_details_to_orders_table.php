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
        Schema::table('orders', function (Blueprint $table) {
            // Add new columns for shipping information
            $table->string('shipping_name')->after('total')->nullable();
            $table->text('shipping_address')->after('shipping_name')->nullable();
            $table->string('shipping_city')->after('shipping_address')->nullable();
            $table->string('shipping_phone')->after('shipping_city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_name',
                'shipping_address',
                'shipping_city',
                'shipping_phone',
            ]);
        });
    }
};
