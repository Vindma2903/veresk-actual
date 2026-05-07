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
    <div class="container">
        @include('pages._landshaftnoe-proektirovanie_parts.services')
    </div>
@endsection
