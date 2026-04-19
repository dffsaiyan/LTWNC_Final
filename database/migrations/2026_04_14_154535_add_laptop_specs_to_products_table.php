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
        Schema::table('products', function (Blueprint $table) {
            $table->string('cpu')->nullable()->after('panel');
            $table->string('gpu')->nullable()->after('cpu');
            $table->string('ram')->nullable()->after('gpu');
            $table->string('ssd')->nullable()->after('ram');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['cpu', 'gpu', 'ram', 'ssd']);
        });
    }
};
