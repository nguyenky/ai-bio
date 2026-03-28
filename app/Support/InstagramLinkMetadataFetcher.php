<?php

namespace App\Support;

use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class InstagramLinkMetadataFetcher
{
    public function __construct(
        protected HttpFactory $http
    ) {
    }

    public function fetch(string $url): array
    {
        try {
            $response = $this->http
                ->accept('text/html')
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                    'Accept-Language' => 'en-US,en;q=0.9',
                ])
                ->timeout(15)
                ->get($url);
        } catch (\Throwable) {
            return $this->fallback($url);
        }

        if (! $response->successful()) {
            return $this->fallback($url);
        }

        $meta = $this->extractMetaTags($response->body());
        $description = $meta['og:description'] ?? $meta['description'] ?? null;
        $title = $meta['og:title'] ?? $this->titleFromDescription($description) ?? $this->fallbackTitle($url);

        return [
            'title' => $this->cleanText($title),
            'caption' => $this->cleanText($description),
            'image_url' => Arr::first([
                $meta['og:image'] ?? null,
                $meta['twitter:image'] ?? null,
            ]),
            'instagram_url' => $url,
        ];
    }

    protected function extractMetaTags(string $html): array
    {
        $tags = [];

        preg_match_all('/<meta\s+(?:property|name)=["\']([^"\']+)["\']\s+content=["\']([^"\']*)["\'][^>]*>/i', $html, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $tags[Str::lower($match[1])] = html_entity_decode($match[2], ENT_QUOTES | ENT_HTML5);
        }

        return $tags;
    }

    protected function titleFromDescription(?string $description): ?string
    {
        if (! $description) {
            return null;
        }

        $parts = preg_split('/[\.\n]/', $description);
        $candidate = trim((string) ($parts[0] ?? ''));

        return $candidate !== '' ? Str::limit($candidate, 80, '') : null;
    }

    protected function fallbackTitle(string $url): string
    {
        $segments = array_values(array_filter(explode('/', trim((string) parse_url($url, PHP_URL_PATH), '/'))));
        $type = $segments[0] ?? 'post';

        return match ($type) {
            'reel' => 'Instagram reel',
            'tv' => 'Instagram video',
            default => 'Instagram post',
        };
    }

    protected function cleanText(?string $text): ?string
    {
        if ($text === null) {
            return null;
        }

        $text = preg_replace('/\s+/', ' ', trim($text));

        return $text === '' ? null : Str::limit($text, 500);
    }

    protected function fallback(string $url): array
    {
        return [
            'title' => $this->fallbackTitle($url),
            'caption' => null,
            'image_url' => null,
            'instagram_url' => $url,
        ];
    }
}
