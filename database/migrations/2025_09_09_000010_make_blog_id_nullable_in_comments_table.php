<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('comments') && Schema::hasColumn('comments', 'blog_id')) {
            // Détecter et supprimer la contrainte de clé étrangère si elle existe
            $fk = DB::selectOne("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'comments' AND COLUMN_NAME = 'blog_id' AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1");
            if ($fk && isset($fk->CONSTRAINT_NAME)) {
                try {
                    DB::statement('ALTER TABLE `comments` DROP FOREIGN KEY `'.str_replace('`','',$fk->CONSTRAINT_NAME).'`');
                } catch (\Throwable $e) {
                    // ignorer si non supprimable
                }
            }

            // Rendre blog_id NULL
            try {
                DB::statement('ALTER TABLE `comments` MODIFY `blog_id` char(36) NULL');
            } catch (\Throwable $e) {
                try {
                    DB::statement('ALTER TABLE `comments` MODIFY `blog_id` binary(16) NULL');
                } catch (\Throwable $e2) {
                    try {
                        DB::statement('ALTER TABLE `comments` MODIFY `blog_id` bigint unsigned NULL');
                    } catch (\Throwable $e3) {
                        // laisser tel quel
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // noop
    }
};


