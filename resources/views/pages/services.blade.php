@extends('base')

@section('main_before')
    <x-page-headers.image-text-inside :img="asset('storage/theme_assets/img/header_services.webp')">
        <div class="absolute md:hidden top-0 bottom-0 left-0 right-0 bg-gradient-to-b from-transparent to-black opacity-90"></div>
        <div class="container relative">
            <div class="h-[600px] sm:h-[640px] lg:h-[750px] flex flex-col justify-center">
                <h1 class="text-4xl lg:text-7xl uppercase mb-24">
                    <span class="font-medium">Ландшафтный</span>
                    <br>
                    <span class="font-medium">дизайн</span>
                    <br>
                    <span class="my-text-outline block text-right sm:text-left sm:ml-[15%]">под ключ</span>
                </h1>
                <div class="flex flex-col gap-5 sm:flex-row sm:gap-10 sm:justify-center">
                    <p class="sm:basis-[300px]">
                        Это один из важнейших шагов после покупки или строительства загородного дома. Это настоящее ремесло по созданию плавного перехода от искусственных объектов к живой природе.
                    </p>
                    <p class="sm:basis-[300px]">
                        Именно в единстве противоположностей создается гармония. И для этой цели в Санкт-Петербурге и ЛО трудятся специалисты компании «Вереск».
                    </p>
                </div>
            </div>
        </div>
    </x-page-headers.image-text-inside>
@endsection

@section('main')
    <div class="container">
        @include('pages._services_parts.price_about')
    </div>

    <div class="h-14"></div>
    @include('pages._services_parts.images_blocks')
    <div class="h-28"></div>

    <div class="container">
        @include('pages._services_parts.what_is_it')
    </div>

    <div class="h-28"></div>
    @include('pages._services_parts.cooperation')
    <div class="h-28"></div>

    <div class="container">
        @include('_parts.three_images_inline', ['images' => [asset('storage/theme_assets/services/img1.png'), asset('storage/theme_assets/services/img2.png'), asset('storage/theme_assets/services/img3.png')]])

        <div class="h-28"></div>
        @include('pages._services_parts.why_us')
    </div>
@endsection
