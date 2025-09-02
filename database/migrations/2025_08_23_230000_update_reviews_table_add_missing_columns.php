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
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'circuit_id')) {
                $table->foreignUuid('circuit_id')->constrained()->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('reviews', 'name')) {
                $table->string('name');
            }
            
            if (!Schema::hasColumn('reviews', 'email')) {
                $table->string('email');
            }
            
            if (!Schema::hasColumn('reviews', 'rating')) {
                $table->integer('rating');
            }
            
            if (!Schema::hasColumn('reviews', 'comment')) {
                $table->text('comment');
            }
            
            if (!Schema::hasColumn('reviews', 'is_approved')) {
                $table->boolean('is_approved')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'circuit_id',
                'name',
                'email',
                'rating',
                'comment',
                'is_approved'
            ]);
        });
    }
};