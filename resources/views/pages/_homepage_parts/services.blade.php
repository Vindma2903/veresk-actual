@php
    $serviceItems = [
        ['title' => 'Ландшафтное проектирование', 'img' => asset('storage/theme_assets/homepage/1.png'), 'url' => '/services/landshaftnoe-proektirovanie'],
        ['title' => 'Озеленение', 'img' => asset('storage/theme_assets/homepage/2.png'), 'url' => '/services/ozelenenie-uchastka'],
        ['title' => 'Благоустройство', 'img' => 'https://placehold.it/400x250', 'url' => '/services/blagoustrojstvo-dachnogo-uchastka'],
        ['title' => 'Уход за садом', 'img' => 'https://placehold.it/400x250', 'url' => '/services/ukhod-za-sadom'],
    ]
@endphp

<div class="flex flex-col xl:flex-row xl:justify-between" data-js-fade-scroll>
    <h3 class="opacity-40 uppercase mb-9 xl:mb-0 xl:mr-[130px] whitespace-nowrap">Наши услуги</h3>
    <div class="flex overflow-x-scroll my-scrollbar-width-none gap-x-8 lg:justify-between lg:w-full" data-js-horizontal-scroll-wheel>
        @foreach($serviceItems as $serviceItem)
            @php
                $code = $loop->iteration;
            @endphp
            <a class="basis-[200px] sm:basis-[400px] grow-0 shrink-0 block" href="{{$serviceItem['url']}}">
                <div class="opacity-40 font-helvetica text-xl sm:text-2xl">{{ $code > 9 ? $code : '0' . $code }}</div>
                <img src="{{$serviceItem['img']}}" class="my-2.5" alt="">
                <div class="text-xl sm:text-2xl">{{ $serviceItem['title'] }}</div>
            </a>
        @endforeach
    </div>
</div>
