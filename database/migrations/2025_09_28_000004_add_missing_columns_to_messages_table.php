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
        Schema::table('messages', function (Blueprint $table) {
            if (!Schema::hasColumn('messages', 'name')) {
                $table->string('name');
            }
            if (!Schema::hasColumn('messages', 'email')) {
                $table->string('email');
            }
            if (!Schema::hasColumn('messages', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('messages', 'subject')) {
                $table->string('subject');
            }
            if (!Schema::hasColumn('messages', 'message')) {
                $table->text('message');
            }
            if (!Schema::hasColumn('messages', 'is_read')) {
                $table->boolean('is_read')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'email',
                'phone',
                'subject',
                'message',
                'is_read'
            ]);
        });
    }
};