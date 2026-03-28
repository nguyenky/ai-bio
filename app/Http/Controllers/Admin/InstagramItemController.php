<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertInstagramItemRequest;
use App\Models\InstagramItem;
use App\Support\InstagramLinkMetadataFetcher;
use App\Support\StoresImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InstagramItemController extends Controller
{
    public function __construct(
        protected InstagramLinkMetadataFetcher $metadataFetcher
    ) {
    }

    public function index(): View
    {
        return view('admin.instagram-items.index', [
            'items' => InstagramItem::query()
                ->orderBy('sort_order')
                ->latest('updated_at')
                ->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.instagram-items.create', [
            'item' => new InstagramItem(),
        ]);
    }

    public function import(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'links' => ['required', 'string'],
        ]);

        $urls = collect(preg_split('/\r\n|\r|\n/', $validated['links']))
            ->map(fn (?string $url) => $this->normalizeInstagramUrl($url))
            ->filter()
            ->values();

        if ($urls->isEmpty()) {
            return back()->withErrors([
                'links' => 'Paste at least one Instagram post, reel, or TV link.',
            ]);
        }

        $invalidUrls = $urls->reject(fn (string $url) => $this->isImportableInstagramUrl($url));

        if ($invalidUrls->isNotEmpty()) {
            return back()->withErrors([
                'links' => 'Only Instagram post, reel, or TV links are supported in bulk import.',
            ]);
        }

        $sortOrder = (int) InstagramItem::max('sort_order');
        $created = 0;
        $skipped = 0;

        foreach ($urls->unique() as $url) {
            if (InstagramItem::query()->where('instagram_url', $url)->exists()) {
                $skipped++;
                continue;
            }

            $metadata = $this->metadataFetcher->fetch($url);

            InstagramItem::create([
                'title' => $metadata['title'],
                'caption' => $metadata['caption'],
                'image_url' => $metadata['image_url'],
                'instagram_url' => $metadata['instagram_url'],
                'sort_order' => ++$sortOrder,
                'is_visible' => true,
            ]);

            $created++;
        }

        $message = "{$created} Instagram item(s) created from pasted links.";

        if ($skipped > 0) {
            $message .= " {$skipped} duplicate link(s) were skipped.";
        }

        return redirect()->route('admin.instagram-items.index')
            ->with('status', $message);
    }

    public function store(UpsertInstagramItemRequest $request): RedirectResponse
    {
        $item = new InstagramItem();
        $this->persistItem($request, $item);

        return redirect()->route('admin.instagram-items.index')
            ->with('status', 'Instagram item created successfully.');
    }

    public function edit(InstagramItem $instagramItem): View
    {
        return view('admin.instagram-items.edit', [
            'item' => $instagramItem,
        ]);
    }

    public function update(UpsertInstagramItemRequest $request, InstagramItem $instagramItem): RedirectResponse
    {
        $this->persistItem($request, $instagramItem);

        return redirect()->route('admin.instagram-items.index')
            ->with('status', 'Instagram item updated successfully.');
    }

    public function destroy(InstagramItem $instagramItem): RedirectResponse
    {
        if ($instagramItem->image_path) {
            StoresImageUploads::sync(request(), 'image_upload', $instagramItem->image_path, 'instagram', true);
        }

        $instagramItem->delete();

        return redirect()->route('admin.instagram-items.index')
            ->with('status', 'Instagram item deleted successfully.');
    }

    protected function persistItem(UpsertInstagramItemRequest $request, InstagramItem $item): void
    {
        $validated = $request->validated();

        $item->fill([
            'title' => $validated['title'] ?: null,
            'caption' => $validated['caption'] ?: null,
            'image_url' => $validated['image_url'] ?: null,
            'instagram_url' => $validated['instagram_url'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_visible' => $request->boolean('is_visible'),
        ]);

        $item->image_path = StoresImageUploads::sync(
            $request,
            'image_upload',
            $item->image_path,
            'instagram',
            $request->boolean('remove_image')
        );

        $item->save();
    }

    protected function normalizeInstagramUrl(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }

        $parts = parse_url($url);

        if (! $parts || empty($parts['host']) || empty($parts['path'])) {
            return $url;
        }

        $path = rtrim($parts['path'], '/');

        return 'https://'.Str::lower($parts['host']).$path;
    }

    protected function isImportableInstagramUrl(string $url): bool
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $host = Str::lower((string) parse_url($url, PHP_URL_HOST));
        $path = trim((string) parse_url($url, PHP_URL_PATH), '/');
        $segments = array_values(array_filter(explode('/', $path)));

        if (! Str::contains($host, 'instagram.com') || count($segments) < 2) {
            return false;
        }

        return in_array($segments[0], ['p', 'reel', 'tv'], true);
    }
}
