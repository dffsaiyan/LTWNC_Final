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
        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('min_order_value', 15, 2)->default(0)->after('value');
            $table->integer('max_uses')->nullable()->after('min_order_value');
            $table->integer('used_count')->default(0)->after('max_uses');
            $table->foreignId('category_id')->nullable()->after('used_count')->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            //
        });
    }
};
