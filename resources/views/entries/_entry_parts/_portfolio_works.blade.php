{{--<div class="xl:flex xl:justify-between xl:items-center mt-24 lg:mt-32">--}}
{{--    <div class="text-4xl lg:text-6xl mb-5 xl:mb-0 uppercase">Наши проекты</div>--}}
{{--    <div>--}}
{{--        <div class="uppercase opacity-60 mb-4 xl:mb-2">Больше проектов в наших социальных сетях @veresklandscape</div>--}}
{{--        <a href="https://vk.com/veresk_landshaft" target="_blank" rel="nofollow" class="border border-white px-5 py-0.5 inline-block text-sm hover:opacity-80">Увидеть больше</a>--}}
{{--    </div>--}}
{{--</div>--}}
{{--portfolio_works_header--}}
{!! $site_options['portfolio_works_header'] ?? "" !!}

@if (isset($other_portfolios) && !empty($other_portfolios))
    <div class="flex flex-col md:flex-row md:flex-wrap mt-12 lg:mt-14">
        @foreach($other_portfolios as $p)
            @php($img = $p->thumbnail ? "/imager/{$p->thumbnail}?w=360&h=260&fit=crop" : 'https://placehold.co/360x260')
            <div class="md:w-1/2 xl:w-1/4 mb-10">
                <a class="block md:px-2.5 md:mx-auto group" href="{{route('portfolios.show', ['slug' => $p->slug])}}">
                    <img src="{{$img}}" class="mb-2.5 xl:mb-5 group-hover:opacity-80" alt="{{$p->title}}">
                    <div class="text-3xl uppercase group-hover:text-[#adc1a4] group-hover:underline">{{$p->title}}</div>
                </a>
            </div>
        @endforeach
    </div>
@endif
