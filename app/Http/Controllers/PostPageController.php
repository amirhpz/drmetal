<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostPageController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Post::query()
            ->active()
            ->published()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $selectedCategory = $request->string('category')->toString();
        $search = $request->string('q')->toString();

        $featuredPost = Post::query()
            ->active()
            ->published()
            ->featured()
            ->ordered()
            ->first();

        if (! $featuredPost) {
            $featuredPost = Post::query()
                ->active()
                ->published()
                ->ordered()
                ->first();
        }

        $posts = Post::query()
            ->active()
            ->published()
            ->when($selectedCategory !== '', fn ($query) => $query->where('category', $selectedCategory))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('title', 'like', '%'.$search.'%')
                        ->orWhere('excerpt', 'like', '%'.$search.'%')
                        ->orWhere('body', 'like', '%'.$search.'%');
                });
            })
            ->ordered()
            ->paginate(9);

        return view('pages.posts.index', [
            'categories' => $categories,
            'featuredPost' => $featuredPost,
            'posts' => $posts,
            'selectedCategory' => $selectedCategory,
            'search' => $search,
            'metaTitle' => 'مقالات و دانشنامه دکتر متال',
            'metaDescription' => 'مطالب تخصصی، راهنماها و تحلیل‌های کاربردی درباره آلومینیوم، بیلت، شمش، استانداردها و کاربردهای صنعتی.',
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

        if ($relatedPosts->count() < 3) {
            $fallbackPosts = Post::query()
                ->active()
                ->published()
                ->whereKeyNot($post->getKey())
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->ordered()
                ->take(3 - $relatedPosts->count())
                ->get();

            $relatedPosts = $relatedPosts->merge($fallbackPosts);
        }

        $readingMinutes = max(1, (int) ceil(mb_strlen(trim(strip_tags(($post->body ?: '').' '.$post->excerpt))) / 900));
        $articleHtml = null;
        $articleBlocks = [];
        $tocItems = collect();

        if ($this->containsHtml($post->body ?: '')) {
            [$articleHtml, $tocItems] = $this->preparedArticleHtml($post->body ?: '');
        } else {
            $articleBlocks = $this->articleBlocks($post->body ?: $post->excerpt ?: '');
            $tocItems = collect($articleBlocks)
                ->filter(fn (array $block): bool => in_array($block['type'], ['h2', 'h3'], true))
                ->values();
        }

        return view('pages.posts.show', [
            'post' => $post,
            'articleHtml' => $articleHtml,
            'articleBlocks' => $articleBlocks,
            'relatedPosts' => $relatedPosts,
            'readingMinutes' => $readingMinutes,
            'tocItems' => $tocItems,
            'metaTitle' => $post->meta_title ?: $post->title,
            'metaDescription' => $post->meta_description ?: $post->excerpt,
        ]);
    }

    /**
     * @return array<int, array{type: string, text: string, id: string|null}>
     */
    private function articleBlocks(string $content): array
    {
        $chunks = preg_split('/\R{2,}/u', trim($content)) ?: [];

        return collect($chunks)
            ->map(function (string $chunk, int $index): array {
                $text = trim($chunk);
                $type = 'p';

                if (str_starts_with($text, '### ')) {
                    $type = 'h3';
                    $text = trim(mb_substr($text, 4));
                } elseif (str_starts_with($text, '## ')) {
                    $type = 'h2';
                    $text = trim(mb_substr($text, 3));
                }

                return [
                    'type' => $type,
                    'text' => $text,
                    'id' => in_array($type, ['h2', 'h3'], true) ? 'article-heading-'.$index : null,
                ];
            })
            ->filter(fn (array $block): bool => $block['text'] !== '')
            ->values()
            ->all();
    }

    private function containsHtml(string $content): bool
    {
        return $content !== strip_tags($content);
    }

    /**
     * @return array{0: string, 1: \Illuminate\Support\Collection<int, array{text: string, id: string}>}
     */
    private function preparedArticleHtml(string $content): array
    {
        $tocItems = collect();
        $index = 0;
        $content = $this->cleanArticleHtml($content);

        $html = preg_replace_callback('/<h([23])([^>]*)>(.*?)<\/h\1>/isu', function (array $matches) use (&$tocItems, &$index): string {
            $text = trim(strip_tags($matches[3]));
            $id = 'article-heading-'.$index;
            $index++;

            if ($text !== '') {
                $tocItems->push([
                    'text' => $text,
                    'id' => $id,
                ]);
            }

            return '<h'.$matches[1].' id="'.$id.'">'.$matches[3].'</h'.$matches[1].'>';
        }, $content) ?? $content;

        return [$html, $tocItems];
    }

    private function cleanArticleHtml(string $content): string
    {
        $allowedTags = '<p><br><strong><b><em><i><u><h2><h3><ul><ol><li><blockquote><a>';
        $content = strip_tags($content, $allowedTags);
        $content = preg_replace('/\s+on[a-z]+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/iu', '', $content) ?? $content;
        $content = preg_replace('/\s(href)\s*=\s*([\'"])\s*(?!https?:|mailto:|tel:|\/|#).*?\2/iu', '', $content) ?? $content;

        return trim($content);
    }
}
