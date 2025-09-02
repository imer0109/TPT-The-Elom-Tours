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
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'title')) {
                $table->string('title');
            }
            if (!Schema::hasColumn('galleries', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('galleries', 'category')) {
                $table->string('category')->nullable();
            }
            if (!Schema::hasColumn('galleries', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!Schema::hasColumn('galleries', 'order')) {
                $table->integer('order')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'description',
                'category',
                'is_active',
                'order'
            ]);
        });
    }
};