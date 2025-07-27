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

        info('⚠️ Dropping unique index on "slug" column.');
        echo "\n⚠️ Dropping unique index on 'slug' column...\n";

        Schema::table('posts', function (Blueprint $table) {
            $table->dropUnique('posts_slug_unique');

        });

        info('🔁 Changing title, slug, and body to JSON type.');
        echo "🔁 Changing title, slug, and body columns to JSON type...\n";

        Schema::table('posts', function (Blueprint $table) {

            $table->json('title')->change();
            $table->json('slug')->change();
            $table->json('body')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        echo "\n⏪ Reverting JSON columns and re-adding slug column...\n";

         Schema::table('posts', function (Blueprint $table) {
            $table->string('title', 255)->change();
            $table->text('body')->change();
            $table->dropColumn('slug');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
        });

    }
};
