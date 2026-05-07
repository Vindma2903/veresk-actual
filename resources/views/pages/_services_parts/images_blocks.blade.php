@php
    $aboutPriceItems = [
        ['title' => 'Проектирование', 'img' => asset('storage/theme_assets/services/slide2.png'), 'isLeft' => false, 'link' => '/services/landshaftnoe-proektirovanie'],
        ['title' => 'Озеленение', 'link' => '/services/ozelenenie-uchastka'],
        ['title' => 'Уход за садом', 'link' => '/services/ukhod-za-sadom'],
        ['title' => 'Благоустройство', 'img' => asset('storage/theme_assets/services/slide3.png'), 'isLeft' => true, 'link' => '/services/blagoustrojstvo-dachnogo-uchastka'],
    ]
@endphp

<div class="border-y" data-js-fade-scroll>
    <div class="container">
        <div class="sm:flex min-w-[320px] sm:min-w-full mx-[-1rem] sm:mx-0">
            <div
                class="flex flex-wrap min-w-[320px] relative sm:border-x sm:min-w-full sm:pl-[130px] md:pl-[170px] lg:pl-[250px] xl:pl-[300px]">
                <a href="{{$aboutPriceItems[0]['link']}}"
                   class="hidden z-[-1] sm:block absolute left-0 top-0 bottom-0 bg-cover border-r bg-center w-[130px] md:w-[170px] lg:w-[250px] xl:w-[300px]"
                   style="background-image: url('{{asset('storage/theme_assets/services/slide1.png')}}')"></a>
                @foreach($aboutPriceItems as $item)
                    @php
                        /** @noinspection PhpUndefinedVariableInspection */
                        $n = $loop->iteration;
                        $isLeft = $item['isLeft'] ?? false;
                    @endphp
                    <div class="basis-1/2 relative odd:border-l">
                        @isset($item['img'])
                            <a href="{{$item['link']}}"
                               class="hidden z-[-1] sm:block absolute top-0 bottom-0 w-[80px] md:w-[100px] lg:w-[140px] xl:w-[170px] bg-cover bg-center {{ $isLeft ? "left-0 border-r" : "right-0 border-l" }}"
                               style="background-image: url('{{ $item['img'] }}')"></a>
                        @endisset
                        <div class="h-[120px] md:h-[200px] lg:h-[260px] flex flex-col justify-between p-2.5 border-b {{ (isset($item['img']) && $isLeft) ? "sm:pl-[90px] md:pl-[110px] lg:pl-[150px] xl:pl-[180px]" : "sm:pr-[90px] md:pr-[110px] lg:pr-[150px] xl:pr-[180px]" }}">
                            <div class="font-helvetica opacity-40 text-xl md:text-xl lg:text-2xl">{{ $n > 9 ? $n : '0' . $n }}</div>
                            <div class="md:text-xl lg:text-2xl">
                                <a class="underline decoration-2 text-[#adc1a4] hover:opacity-80" href="{{$item['link']}}">{{ $item['title'] }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
