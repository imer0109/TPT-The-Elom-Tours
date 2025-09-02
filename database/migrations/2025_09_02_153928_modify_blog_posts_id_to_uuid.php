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
        // Créer une nouvelle table temporaire avec la structure correcte
        Schema::create('blog_posts_new', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->text('excerpt')->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
        });
        
        // Supprimer l'ancienne table
        Schema::dropIfExists('blog_posts');
        
        // Renommer la nouvelle table
        Schema::rename('blog_posts_new', 'blog_posts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recréer la table avec l'ancienne structure
        Schema::create('blog_posts_old', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->text('excerpt')->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
        });
        
        // Supprimer la nouvelle table
        Schema::dropIfExists('blog_posts');
        
        // Renommer l'ancienne table
        Schema::rename('blog_posts_old', 'blog_posts');
    }
};
