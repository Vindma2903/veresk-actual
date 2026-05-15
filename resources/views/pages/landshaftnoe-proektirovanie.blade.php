@extends('base')

@php
    $contentEntry = $pageEntry ?? null;
    $blocks = is_array($contentEntry?->blocks_json ?? null) ? $contentEntry->blocks_json : [];
    $blockVisibility = array_fill(1, 10, true);
    $blockBodies = array_fill(1, 10, null);

    foreach ($blocks as $index => $block) {
        $position = $index + 1;
        if ($position < 1 || $position > 10 || !is_array($block)) {
            continue;
        }

        $blockVisibility[$position] = (bool) ($block['is_active'] ?? true);
        $body = $block['body'] ?? null;
        $blockBodies[$position] = is_string($body) && trim($body) !== '' ? $body : null;
    }

    $isBlockVisible = function (int $position) use ($blockVisibility): bool {
        return $blockVisibility[$position] ?? true;
    };

    $getBlockBody = function (int $position) use ($blockBodies): ?string {
        return $blockBodies[$position] ?? null;
    };

    $applyVideoToBlock8 = function (int $position, ?string $body) use ($blocks): ?string {
        if ($position !== 8 || !is_string($body) || trim($body) === '') {
            return $body;
        }

        $block = $blocks[7] ?? null;
        if (!is_array($block)) {
            return $body;
        }

        $video = trim((string)($block['video'] ?? ''));
        if ($video === '') {
            return $body;
        }

        $src = str_starts_with($video, 'http://') || str_starts_with($video, 'https://') || str_starts_with($video, '/')
            ? $video
            : '/storage/' . ltrim($video, '/');

        $videoOverlay =
            '<div class="absolute inset-0 bg-gradient-to-br from-[#1D271F] via-[#111111] to-[#3E5A41]">' .
            '<video controls playsinline preload="metadata" class="w-full h-full object-cover" style="pointer-events:auto;">' .
            '<source src="' . e($src) . '" type="video/mp4">' .
            '</video>' .
            '</div>';

        $pattern = '/<div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-\\[#1D271F\\] via-\\[#111111\\] to-\\[#3E5A41\\]">.*?<\\/div>/s';

        return preg_replace($pattern, $videoOverlay, $body, 1) ?? $body;
    };
@endphp

@section('main_before')
    @if($isBlockVisible(1))
        @if($getBlockBody(1))
            {!! $getBlockBody(1) !!}
        @else
            @include('pages._landshaftnoe-proektirovanie_parts.intro')
        @endif
    @endif
@endsection

@section('main')
    <div class="container space-y-8 sm:space-y-10 lg:space-y-12">
        @for ($position = 2; $position <= 10; $position++)
            @if($isBlockVisible($position) && $getBlockBody($position))
                @if($position === 8)
                    <div class="mb-8 sm:mb-10">
                        {!! $applyVideoToBlock8($position, $getBlockBody($position)) !!}
                    </div>
                @else
                    {!! $applyVideoToBlock8($position, $getBlockBody($position)) !!}
                @endif
            @endif
        @endfor
    </div>
@endsection
