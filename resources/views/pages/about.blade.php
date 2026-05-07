@extends('base')

@section('main_before')
<x-page-headers.image-text-outside :img="asset('storage/theme_assets/img/header_about.webp')">
<div class="container my-9 lg:my-12">
    <h1 class="text-4xl lg:text-7xl mb-5 uppercase font-helvetica">
        <span class="font-medium">Ландшафтный дизайн</span>
        <br>
        <span class="my-text-outline lg:text-right lg:block">от мастерской вереск</span>
    </h1>
    <div class="text-lg max-w-[400px] lg:ml-[35%] xl:ml-[50%]">
        “Вереск” - мастерская ландшафтов по проектированию и обустройству дачных участков
    </div>
</div>
</x-page-headers.image-text-outside>
@endsection

@section('content')
<div class="h-28"></div>

{{--@include('pages._about_parts.employee', ['name' => 'Максим<br/>Никитин', 'about' => 'Генеральный директор<br/>Соучредитель', 'img' => asset('storage/theme_assets/about/max.png'), 'isRight' => true])--}}
{{--<div class="h-28"></div>--}}
@include('pages._about_parts.employee', ['name' => 'Максим<br/>Никитин', 'about' => 'Генеральный директор<br/>Соучредитель', 'img' => asset('storage/theme_assets/about/max.png')])
<div class="h-28"></div>
<x-title-with-text>
    <!--suppress XmlUnboundNsPrefix -->
    <x-slot:title>Наша миссия</x-slot:title>
    <!--suppress XmlUnboundNsPrefix -->
    <x-slot:description>Когда к нам приходит человек с желанием создать красивый сад, мы обсуждаем проект до тех пор, пока не поймем значение слова «красивый» лично для него.</x-slot:description>
</x-title-with-text>
<div class="h-28"></div>
@include('pages._about_parts.quote')
<div class="h-28"></div>
@include('_parts.three_images', ['img1' => asset('storage/theme_assets/about/img3.png'), 'img2' => asset('storage/theme_assets/about/img1.png'), 'img3' => asset('storage/theme_assets/about/img2.png')])
<div class="h-28"></div>
<x-title-with-text>
    <!--suppress XmlUnboundNsPrefix -->
    <x-slot:title>Наши партнеры</x-slot:title>
    <!--suppress XmlUnboundNsPrefix -->
    <x-slot:description>Чтобы строительный материал обходился дешевле, мы налаживаем партнерские отношения с поставщиками строительных и посадочных материалов. Поэтому заказчик тратит меньше.</x-slot:description>
    <!--suppress XmlUnboundNsPrefix -->
    <x-slot:afterDescription>
        @include('pages._about_parts.partners_logos')
    </x-slot:afterDescription>
</x-title-with-text>
@endsection
