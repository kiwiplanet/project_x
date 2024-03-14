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
        Schema::table('items', function (Blueprint $table) {
            $table->string('img_path');
            $table->string('buyer', 411)->index();
            $table->decimal('unit_price', 10, 2);
            $table->integer('regular_stock');
            $table->integer('total_stock');
            $table->integer('kitchen_stock')->nullable();
            $table->integer('second_stock')->nullable();
            $table->integer('smach_stock')->nullable();

            $table->dropColumn('type');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('img_path');
            $table->dropColumn('buyer');
            $table->dropColumn('unit_price');
            $table->dropColumn('regular_stock');
            $table->dropColumn('total_stock');
            $table->dropColumn('kitchen_stock');
            $table->dropColumn('second_stock');
            $table->dropColumn('smach_stock');

            $table->string('type', 100)->nullable();
        });
    }
};
