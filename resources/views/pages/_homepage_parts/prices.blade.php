@php
    $priceItems = [
        ['title' => 'Базовый', 'description' => 'От 400 тысяч', 'code' => '01', 'list' => [
            'планировка участка',
            'устройство дренажа',
            'мощение',
            'установка детской площадки/беседки',
            'посевной газон',
]],
        ['title' => 'Основной', 'description' => 'От 500 тысяч', 'code' => '02', 'list' => [
            'планировка участка',
            'устройство дренажа',
            'установка освещения',
            'создание подпорных стенок',
            'мощение',
            'создание водоема',
            'установка детской площадки/беседки',
            'посадки',
            'создание огорода / альпийской горки / цветников',
            'рулонный газон',
]],
        ['title' => 'Уникальный', 'description' => 'От 600 тысяч', 'code' => '03', 'is_max' => true, 'list' => [
            'создание водопадов и ручьев',
            'крупные водоемы и бассейны',
            'кованные элементы',
            'каменистые сады и альпинарии',
            'постройка летних кухонь и беседок',
            'посадка крупномеров и топиарных растений',
            'садовые скульптуры',
]],
        ['title' => 'Связаться с нами', 'description' => 'Наш менеджер свяжется с Вами и рассчитает смету', 'code' => ''],
    ];
@endphp

<div class="flex flex-col xl:flex-row xl:justify-between" data-js-fade-scroll>
    <h3 class="opacity-40 uppercase mb-9 xl:mb-0 xl:mr-[130px] whitespace-nowrap">Пакеты услуг</h3>
    <div class="flex overflow-x-scroll my-scrollbar-width-none gap-x-10 lg:justify-between lg:overflow-x-visible lg:w-full">
        @foreach($priceItems as $priceItem)
            <div class="basis-[240px] grow-0 shrink-0">
                <div class="border-b border-gray-500 mb-5 sm:mb-10 h-[120px] sm:h-[140px]">
                    <div class="text-2xl mb-2.5">{{ $priceItem['title'] }}</div>
                    <div class="opacity-60 text-sm">{{ $priceItem['description'] }}</div>
                    @if (!empty($priceItem['code']))
                        <div class="opacity-40 font-helvetica mt-2.5">{{ $priceItem['code'] }}</div>
                    @endif
                </div>
                @if (isset($priceItem['list']))
                    <ul>
                        @foreach($priceItem['list'] as $text)
                            <li class="mb-1">
                                <span class="text-xs mr-1"><i class="las la-angle-right"></i></span>
                                <span class="text-sm text-neutral-300">{{$text}}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </div>
</div>
