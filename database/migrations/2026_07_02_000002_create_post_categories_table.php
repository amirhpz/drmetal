<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table): void {
            $table
                ->foreignId('post_category_id')
                ->nullable()
                ->after('category')
                ->constrained('post_categories')
                ->nullOnDelete();
        });

        DB::table('posts')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->each(function (string $title, int $index): void {
                $slug = Str::slug($title) ?: 'post-category-'.($index + 1);
                $baseSlug = $slug;
                $counter = 1;

                while (DB::table('post_categories')->where('slug', $slug)->exists()) {
                    $slug = $baseSlug.'-'.$counter;
                    $counter++;
                }

                $categoryId = DB::table('post_categories')->insertGetId([
                    'title' => $title,
                    'slug' => $slug,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('posts')
                    ->where('category', $title)
                    ->update(['post_category_id' => $categoryId]);
            });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('post_category_id');
        });

        Schema::dropIfExists('post_categories');
    }
};
