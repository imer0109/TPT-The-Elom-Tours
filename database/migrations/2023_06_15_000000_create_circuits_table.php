<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circuits', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('slug')->unique();
            $table->text('description');
            $table->integer('duree'); // en jours
            $table->decimal('prix', 10, 2);
            $table->string('image')->nullable();
            $table->string('destination');
            $table->enum('difficulte', ['facile', 'modere', 'difficile'])->default('modere');
            $table->integer('taille_groupe')->default(10);
            $table->json('langues')->nullable(); // ['français', 'anglais', etc.]
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('circuits');
    }
};