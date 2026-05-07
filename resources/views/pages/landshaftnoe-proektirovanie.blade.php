@extends('base')

@php
    $contentEntry = $pageEntry ?? null;
    $blocks = is_array($contentEntry?->blocks_json ?? null) ? $contentEntry->blocks_json : [];
    $blockVisibility = [];

    foreach ($blocks as $block) {
        if (!is_array($block)) {
            continue;
        }

        $name = trim((string) ($block['name'] ?? ''));
        if ($name === '') {
            continue;
        }

        $blockVisibility[$name] = (bool) ($block['is_active'] ?? true);
    }

    $isBlockVisible = function (string $name) use ($blockVisibility): bool {
        return $blockVisibility[$name] ?? true;
    };
@endphp

@section('main_before')
    @if($isBlockVisible('Блок 1'))
        @include('pages._landshaftnoe-proektirovanie_parts.intro')
    @endif
@endsection

@section('main')
    <div class="container">
        @include('pages._landshaftnoe-proektirovanie_parts.services')
    </div>
@endsection
