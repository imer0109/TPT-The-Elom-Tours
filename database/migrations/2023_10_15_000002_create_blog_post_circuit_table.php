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
        Schema::create('blog_post_circuit', function (Blueprint $table) {
            $table->uuid('blog_post_id');
            $table->uuid('circuit_id');
            $table->primary(['blog_post_id', 'circuit_id']);
            
            $table->foreign('blog_post_id')
                ->references('id')
                ->on('blog_posts')
                ->onDelete('cascade');
                
            $table->foreign('circuit_id')
                ->references('id')
                ->on('circuits')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post_circuit');
    }
};