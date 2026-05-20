<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicates = DB::table('cart_items')
            ->select('cart_id', 'product_id', DB::raw('MIN(id) as keep_id'), DB::raw('SUM(quantity) as total_qty'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('cart_id', 'product_id')
            ->having('cnt', '>', 1)
            ->get();

        foreach ($duplicates as $row) {
            DB::table('cart_items')
                ->where('cart_id', $row->cart_id)
                ->where('product_id', $row->product_id)
                ->where('id', '!=', $row->keep_id)
                ->delete();

            DB::table('cart_items')
                ->where('id', $row->keep_id)
                ->update(['quantity' => $row->total_qty]);
        }

        Schema::table('cart_items', function (Blueprint $table) {
            $table->unique(['cart_id', 'product_id']);
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique(['cart_id', 'product_id']);
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
        });
    }
};
