@php
    $partnerItems = [
        ['title' => 'Дабл Ю', 'img' => asset('storage/theme_assets/about/logo8.png')],
        ['title' => 'Вимос', 'img' => asset('storage/theme_assets/about/logo1.png')],
        ['title' => 'Окамень', 'img' => asset('storage/theme_assets/about/logo2.png')],
        ['title' => 'СПР', 'img' => asset('storage/theme_assets/about/logo7.png')],
        ['title' => 'Хорошая рассада', 'img' => asset('storage/theme_assets/about/logo6.png')],
        ['title' => 'Геопластборд', 'img' => asset('storage/theme_assets/about/logo3.png')],
        ['title' => 'Алексеевская дубрава', 'img' => asset('storage/theme_assets/about/logo4.png')],
        ['title' => 'Камоника', 'img' => asset('storage/theme_assets/about/logo5.png')],
    ]
@endphp

<ul class="mt-10 sm:mt-20 sm:columns-2">
    @foreach($partnerItems as $p)
        <li class="flex gap-x-3 sm:gap-7 items-center mb-3">
            <img src="{{ $p['img'] }}" class="rounded-full" width="30" height="30" alt="">
            <span class="text-2xl opacity-60 font-medium">{{ $p['title'] }}</span>
        </li>
    @endforeach
</ul>
