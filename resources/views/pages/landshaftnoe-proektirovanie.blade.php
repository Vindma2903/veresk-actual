@extends('base')

@section('main_before')
    @php
        $blocks = is_array($entry->blocks_json ?? null) ? $entry->blocks_json : [];
        $firstActiveIndex = null;
        $firstActiveBlock = null;
        $replaceBlockImage = function (array $block): string {
            $body = (string)($block['body'] ?? '');
            $images = [];
            for ($i = 1; $i <= 6; $i++) {
                $slot = $block['image_' . $i] ?? null;
                if (is_string($slot) && trim($slot) !== '') {
                    $images[] = $slot;
                }
            }

            if (count($images) === 0) {
                $multi = $block['images'] ?? null;
                if (is_array($multi)) {
                    $images = array_values(array_filter($multi, fn ($v) => is_string($v) && trim($v) !== ''));
                }
            }

            if (count($images) === 0 && !empty($block['image']) && is_string($block['image'])) {
                $images = [$block['image']];
            }

            if (count($images) === 0) {
                return $body;
            }

            $sources = array_map(function (string $image): string {
                return str_starts_with($image, 'http://') || str_starts_with($image, 'https://') || str_starts_with($image, '/')
                    ? $image
                    : '/storage/' . ltrim($image, '/');
            }, $images);

            $index = 0;
            $replaceNext = function () use (&$index, $sources): ?string {
                if (!isset($sources[$index])) {
                    return null;
                }
                return $sources[$index++];
            };

            $body = preg_replace_callback(
                '/background-image\\s*:\\s*url\\((["\\\']?)[^)\\\"\\\']+\\1\\)/i',
                function (array $m) use (&$replaceNext): string {
                    $next = $replaceNext();
                    if ($next === null) {
                        return $m[0];
                    }
                    return "background-image: url('" . $next . "')";
                },
                $body
            ) ?? $body;

            $body = preg_replace_callback(
                '/(<img[^>]*src=["\\\'])[^"\\\']+(["\\\'])/i',
                function (array $m) use (&$replaceNext): string {
                    $next = $replaceNext();
                    if ($next === null) {
                        return $m[0];
                    }
                    return $m[1] . $next . $m[2];
                },
                $body
            ) ?? $body;

            return $body;
        };

        $applyBlockVideo = function (array $block, string $body): string {
            $video = trim((string)($block['video'] ?? ''));

            if ($video === '') {
                return $body;
            }

            $src = str_starts_with($video, 'http://') || str_starts_with($video, 'https://') || str_starts_with($video, '/')
                ? $video
                : '/storage/' . ltrim($video, '/');

            $videoHtml =
                '<div class="absolute inset-0 bg-black">' .
                '<video controls playsinline preload="metadata" class="w-full h-full object-cover">' .
                '<source src="' . e($src) . '" type="video/mp4">' .
                '</video>' .
                '</div>';

            $pattern = '/<div class=\"absolute inset-0 flex items-center justify-center bg-gradient-to-br from-\\[#1D271F\\] via-\\[#111111\\] to-\\[#3E5A41\\]\">.*?<\\/div>/s';
            if (preg_match($pattern, $body)) {
                return preg_replace($pattern, $videoHtml, $body, 1) ?? $body;
            }

            return $body . '<div class="container mt-6"><video controls class="w-full max-w-4xl"><source src="' . e($src) . '" type="video/mp4"></video></div>';
        };

        $applyBlock9Hotspots = function (array $block, string $body): string {
            if (trim((string)($block['name'] ?? '')) !== 'Блок 9') {
                return $body;
            }

            $overrides = [];
            for ($i = 1; $i <= 4; $i++) {
                $img = $block['hotspot_image_' . $i] ?? null;
                $caption = $block['hotspot_caption_' . $i] ?? null;

                $imgValue = is_string($img) ? trim($img) : '';
                $captionValue = is_string($caption) ? trim($caption) : '';

                $overrides[] = [
                    'image' => $imgValue,
                    'caption' => $captionValue,
                ];
            }

            $hasOverrides = false;
            foreach ($overrides as $item) {
                if ($item['image'] !== '' || $item['caption'] !== '') {
                    $hasOverrides = true;
                    break;
                }
            }
            if (!$hasOverrides) {
                return $body;
            }

            $idx = 0;
            return preg_replace_callback(
                '/data-hotspot-button[^>]*data-image=["\\\']([^"\\\']*)["\\\'][^>]*data-caption=["\\\']([^"\\\']*)["\\\']/i',
                function (array $m) use (&$idx, $overrides): string {
                    $current = $m[0];
                    $override = $overrides[$idx] ?? null;
                    $idx++;

                    if (!$override) {
                        return $current;
                    }

                    if ($override['image'] !== '') {
                        $src = str_starts_with($override['image'], 'http://') || str_starts_with($override['image'], 'https://') || str_starts_with($override['image'], '/')
                            ? $override['image']
                            : '/storage/' . ltrim($override['image'], '/');
                        $current = preg_replace('/data-image=["\\\'][^"\\\']*["\\\']/', 'data-image="' . e($src) . '"', $current) ?? $current;
                    }

                    if ($override['caption'] !== '') {
                        $current = preg_replace('/data-caption=["\\\'][^"\\\']*["\\\']/', 'data-caption="' . e($override['caption']) . '"', $current) ?? $current;
                    }

                    return $current;
                },
                $body
            ) ?? $body;
        };

        foreach ($blocks as $idx => $block) {
            if (($block['is_active'] ?? true) === true && !empty($block['body'])) {
                $firstActiveIndex = $idx;
                $firstActiveBlock = $block;
                break;
            }
        }
    @endphp

    @if (!empty($firstActiveBlock['body']))
        {!! $applyBlock9Hotspots($firstActiveBlock, $applyBlockVideo($firstActiveBlock, $replaceBlockImage($firstActiveBlock))) !!}
    @endif
@endsection

@section('main')
    @if (count($blocks) > 0)
        @foreach ($blocks as $idx => $block)
            @if ($firstActiveIndex !== null && $idx === $firstActiveIndex)
                @continue
            @endif
            @if (($block['is_active'] ?? true) !== true)
                @continue
            @endif
            @if (!empty($block['body']))
                {!! $applyBlock9Hotspots($block, $applyBlockVideo($block, $replaceBlockImage($block))) !!}
            @endif
        @endforeach
    @else
        <div class="container">
            @if (!empty($entry->body))
                <div class="entry-content js-modal-images mb-12">
                    {!! $entry->body !!}
                </div>
            @else
                @include('pages._landshaftnoe-proektirovanie_parts.services')
            @endif
        </div>
    @endif
@endsection
