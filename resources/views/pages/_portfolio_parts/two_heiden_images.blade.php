@php($isDown = $isDown ?? false)
<div class="flex flex-col gap-7 sm:flex-row" data-js-fade-scroll>
    <div class="sm:basis-1/2 sm:text-right {{ $isDown ? "sm:flex sm:flex-col sm:justify-end" : "" }}">
        <a class="font-helvetica text-3xl lg:text-4xl underline decoration-2 text-[#adc1a4] hover:opacity-80" href="{{route('portfolios.show', ['slug' => $slug])}}">{{ $title }}</a>
        <div class="text-xl md:text-2xl opacity-60">{{ $description }}</div>
    </div>
    <div class="sm:basis-1/2 flex gap-4 md:gap-7 {{ $isDown ? "items-end flex-row-reverse" : "" }}">
        <div>
            <img src="{{ $imgBig }}" alt="">
        </div>
        <div>
            <img src="{{ $imgSmall }}" class="" alt="">
        </div>
    </div>
</div>
