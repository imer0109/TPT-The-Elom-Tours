<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Les tables qui utilisent le soft delete
     */
    private array $tables = [
        'circuits',
        'destinations',
        'blog_posts',
        'reservations',
        'clients',
        'comments',
        'reviews',
        'categories',
        'paiements',
        'settings',
        'users'
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'deleted_by')) {
                    $table->uuid('deleted_by')->nullable();
                    $table->foreign('deleted_by')
                          ->references('id')
                          ->on('users')
                          ->onDelete('set null');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'deleted_by')) {
                    $table->dropForeign(['deleted_by']);
                    $table->dropColumn('deleted_by');
                }
            });
        }
    }
};