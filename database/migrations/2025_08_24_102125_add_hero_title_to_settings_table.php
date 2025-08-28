<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up()
{
    Schema::table('settings', function (Blueprint $table) {
        $table->string('hero_title')->nullable();
        $table->string('hero_subtitle')->nullable();
    });
}

public function down()
{
    Schema::table('settings', function (Blueprint $table) {
        $table->dropColumn(['hero_title', 'hero_subtitle']);
    });
}

};
