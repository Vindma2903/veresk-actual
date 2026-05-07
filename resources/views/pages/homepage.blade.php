@extends('base')

@section('main_before')
<x-page-headers.image-text-inside :img="asset('storage/theme_assets/img/header_homepage.webp')">
<div class="container">
    <div class="h-[480px] lg:h-[750px] flex flex-col justify-center">
        <h1 class="text-4xl lg:text-7xl mb-5 uppercase">
            <span class="font-medium">Ничего лишнего</span>
            <br>
            <span class="my-text-outline">только гармония</span>
        </h1>
        <div class="text-lg max-w-[400px]">
            Компания “Вереск” предлагает компекс работ по ландшафтному дизайне, от дизайна до благоустройства.
        </div>
    </div>
</div>
</x-page-headers.image-text-inside>
@endsection

@section('main')
<div class="container">
    @include('pages/_homepage_parts/services')
</div>

<div class="h-28"></div>
    <div id="js-service-slider"
         data-js-fade-scroll
         data-title="Что мы делаем"
         data-image="{{asset('storage/theme_assets/homepage/wedo.png')}}"></div>
<div class="h-28"></div>

<div class="container">
    @include('pages/_homepage_parts/process')
    <div class="h-28"></div>
    @include('pages/_homepage_parts/quote')
    <div class="h-28"></div>
    @include('pages/_homepage_parts/prices')
    <div class="h-28"></div>
    @include('pages/_homepage_parts/portfolio')
</div>
@endsection
