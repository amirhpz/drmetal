<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostPageController extends Controller
{
    public function index(): View
    {
        $featuredPosts = Post::query()
            ->active()
            ->published()
            ->featured()
            ->ordered()
            ->take(3)
            ->get();

        $posts = Post::query()
            ->active()
            ->published()
            ->ordered()
            ->paginate(9);

        return view('pages.posts.index', [
            'featuredPosts' => $featuredPosts,
            'posts' => $posts,
            'metaTitle' => 'مقالات و اخبار دکتر متال',
            'metaDescription' => 'مطالب تخصصی، اخبار و یادداشت‌های دکتر متال درباره آلومینیوم، فلزات رنگین و صنعت متالورژی.',
        ]);
    }

    public function show(Post $post): View
    {
        abort_unless($post->is_active && $post->published_at && $post->published_at->lte(now()), 404);

        $relatedPosts = Post::query()
            ->active()
            ->published()
            ->whereKeyNot($post->getKey())
            ->when($post->category, fn ($query) => $query->where('category', $post->category))
            ->ordered()
            ->take(3)
            ->get();

        return view('pages.posts.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'metaTitle' => $post->meta_title ?: $post->title,
            'metaDescription' => $post->meta_description ?: $post->excerpt,
        ]);
    }
}
