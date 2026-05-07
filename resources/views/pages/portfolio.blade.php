@extends('base')

@section('main_before')
    <div class="my-28">
        <x-page-headers.title-with-description title="Портфолио">
            <!--suppress XmlUnboundNsPrefix -->
            <x-slot:description>
                <p class="text-xl sm:text-2xl lg:w-[450px] xl:w-[520px]">
                    Как и в любой мастерской мы вкладываем душу в свои работы, поэтому каждый сад создается индивидуально для каждого заказчика. Любой объект для нас это маленькая история, новые эмоции и новый опыт. Каждый кто обращается к нам получает именно свой уникальный сад.
                </p>
            </x-slot:description>
        </x-page-headers.title-with-description>
    </div>
@endsection

@section('content')
    @include('pages._portfolio_parts.one_image', [
        'img' => asset('storage/theme_assets/portfolio/1.png'),
        'title' => 'Лунное озеро',
        'description' => "Июнь'21",
        'slug' => 'moon-lake',
    ])

    <div class="h-28"></div>

    @include('pages._portfolio_parts.two_heiden_images', [
        'imgBig' => asset('storage/theme_assets/portfolio/3.png'),
        'imgSmall' => asset('storage/theme_assets/portfolio/2.png'),
        'title' => 'Визуализации',
        'description' => "Март'22",
        'isDown' => true,
        'slug' => 'visualizations',
    ])

    <div class="h-28"></div>

    @include('pages._portfolio_parts.one_image', [
       'img' => asset('storage/theme_assets/portfolio/4.png'),
       'title' => 'Бельведер',
       'description' => "Август'21",
       'slug' => 'belveder'
   ])

    <div class="h-28"></div>

    @include('pages._portfolio_parts.two_weiden_images', [
        'imgBig' => asset('storage/theme_assets/portfolio/6.png'),
        'imgSmall' => asset('storage/theme_assets/portfolio/5.png'),
        'title' => 'Суходолье',
        'description' => "Октябрь'21",
        'slug' => 'sukhodole',
    ])

    <div class="h-28"></div>

    @include('pages._portfolio_parts.two_heiden_images', [
        'imgBig' => asset('storage/theme_assets/portfolio/7.png'),
        'imgSmall' => asset('storage/theme_assets/portfolio/8.png'),
        'title' => 'Водный мир',
        'description' => "Июль'21",
        'slug' => 'vodnyi-mir',
    ])

    <div class="h-28"></div>
@endsection
