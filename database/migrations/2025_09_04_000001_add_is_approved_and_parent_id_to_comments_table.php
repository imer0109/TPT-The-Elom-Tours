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
        // D'abord, assurons-nous que la colonne id est bien définie comme clé primaire
        Schema::table('comments', function (Blueprint $table) {
            // Vérifier si la colonne id n'est pas déjà une clé primaire
            if (!Schema::hasColumn('comments', 'id')) {
                $table->uuid('id')->primary();
            } else {
                // Si la colonne existe mais n'est pas une clé primaire, on la modifie
                $table->primary('id');
            }
        });

        // Ensuite, ajoutons les nouvelles colonnes
        Schema::table('comments', function (Blueprint $table) {
            // Ajouter la colonne is_approved
            if (!Schema::hasColumn('comments', 'is_approved')) {
                $table->boolean('is_approved')->default(false)->after('blog_post_id');
            }
            
            // Ajouter les timestamps (created_at et updated_at) s'ils n'existent pas
            if (!Schema::hasColumn('comments', 'created_at')) {
                $table->timestamps();
            }
        });

        // Enfin, ajoutons la colonne parent_id avec la clé étrangère
        Schema::table('comments', function (Blueprint $table) {
            // Ajouter la colonne parent_id pour les réponses aux commentaires
            if (!Schema::hasColumn('comments', 'parent_id')) {
                $table->uuid('parent_id')->nullable()->after('is_approved');
                $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Supprimer la clé étrangère si elle existe
            if (Schema::hasColumn('comments', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }
            
            // Supprimer les autres colonnes si elles existent
            if (Schema::hasColumn('comments', 'is_approved')) {
                $table->dropColumn('is_approved');
            }
            
            if (Schema::hasColumn('comments', 'created_at')) {
                $table->dropColumn(['created_at', 'updated_at']);
            }
        });
    }
};