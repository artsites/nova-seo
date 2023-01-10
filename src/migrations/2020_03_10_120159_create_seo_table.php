<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 8);
            $table->nullableMorphs('model');
            $table->boolean('auto_title')->default(false);
            $table->string('title', 255)->nullable();
            $table->string('h1', 255)->nullable();
            $table->string('link', 750)->unique()->nullable();
            $table->boolean('is_noindex')->default(0);
            $table->boolean('is_nofollow')->default(0);
            $table->boolean('auto_description')->default(false);
            $table->text('description')->nullable();
            $table->json('content')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seo');
    }
};
