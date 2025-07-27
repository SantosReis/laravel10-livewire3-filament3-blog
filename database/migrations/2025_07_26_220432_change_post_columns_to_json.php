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

        // DB::statement("UPDATE posts SET slug = JSON_OBJECT() WHERE slug IS NULL OR slug = '' OR JSON_VALID(slug) = 0");
        // DB::statement("UPDATE posts SET title = JSON_OBJECT() WHERE title IS NULL OR title = '' OR JSON_VALID(title) = 0");
        // DB::statement("UPDATE posts SET body = JSON_OBJECT() WHERE body IS NULL OR body = '' OR JSON_VALID(body) = 0");

        Schema::table('posts', function (Blueprint $table) {
            // $table->dropUnique(['slug']); // Drop unique index first
            // $table->dropUnique(['posts_slug_unique']);
            // $table->dropUnique('posts_slug_unique');
            // $table->dropUnique('slug');
            // $table->dropUnique('posts_slug_unique');
        });

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

        // Convert JSON back to plain strings (e.g., 'en' field only)
        // DB::statement("UPDATE posts SET title = JSON_UNQUOTE(JSON_EXTRACT(title, '$.en')) WHERE JSON_VALID(title)");
        // DB::statement("UPDATE posts SET slug = JSON_UNQUOTE(JSON_EXTRACT(slug, '$.en')) WHERE JSON_VALID(slug)");
        // DB::statement("UPDATE posts SET body = JSON_UNQUOTE(JSON_EXTRACT(body, '$.en')) WHERE JSON_VALID(body)");

        Schema::table('posts', function (Blueprint $table) {
            $table->string('title', 255)->change();
            $table->string('slug', 255)->change();
            $table->text('body')->change();
        });

        // Schema::table('posts', function (Blueprint $table) {
        //     $table->string('slug')->unique();
        // });
    }
};
