<?php

namespace App\Support;

class SafeHtml
{
    private const ALLOWED_TAGS = '<p><br><strong><b><em><i><u><h2><h3><ul><ol><li><blockquote><a>';

    public static function cleanArticle(?string $html): ?string
    {
        if (blank($html)) {
            return null;
        }

        $html = strip_tags((string) $html, self::ALLOWED_TAGS);
        $html = self::cleanLinks($html);
        $html = self::stripAttributesExceptLinks($html);

        return trim($html);
    }

    private static function cleanLinks(string $html): string
    {
        return preg_replace_callback('/<a\b([^>]*)>/iu', function (array $matches): string {
            $attributes = $matches[1] ?? '';
            $href = self::extractHref($attributes);

            if ($href === null || ! self::isSafeUrl($href)) {
                return '<a>';
            }

            return '<a href="'.e($href).'">';
        }, $html) ?? $html;
    }

    private static function stripAttributesExceptLinks(string $html): string
    {
        return preg_replace_callback('/<(\/?)(p|br|strong|b|em|i|u|h2|h3|ul|ol|li|blockquote)\b[^>]*>/iu', function (array $matches): string {
            return '<'.$matches[1].strtolower($matches[2]).'>';
        }, $html) ?? $html;
    }

    private static function extractHref(string $attributes): ?string
    {
        if (preg_match('/\bhref\s*=\s*("([^"]*)"|\'([^\']*)\'|([^\s>]+))/iu', $attributes, $matches) !== 1) {
            return null;
        }

        return html_entity_decode($matches[2] ?: $matches[3] ?: $matches[4], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private static function isSafeUrl(string $url): bool
    {
        $url = trim($url);

        return $url !== '' && preg_match('/^(https?:|mailto:|tel:|\/|#)/iu', $url) === 1;
    }
}
