@php($isRight = $isRight ?? false)
<div class="flex flex-col gap-7 sm:justify-end {{ $isRight ? "sm:flex-row" : "sm:flex-row-reverse" }}" data-js-fade-scroll>
    <div class="{{ $isRight ? "sm:text-right" : "" }}">
        <a class="font-helvetica text-3xl lg:text-4xl underline decoration-2 text-[#adc1a4] hover:opacity-80" href="{{route('portfolios.show', ['slug' => $slug])}}">{{ $title }}</a>
        <div class="text-xl md:text-2xl opacity-60">{{ $description }}</div>
    </div>
    <div class="sm:basis-1/2 lg:basis-8/12 flex flex-col gap-4 md:gap-7 {{ $isRight ? "lg:flex-row" : "lg:flex-row-reverse" }}">
        <div>
            <img src="{{ $imgBig }}" alt="">
        </div>
        <div class="w-3/5 md:w-auto">
            <img src="{{ $imgSmall }}" class="" alt="">
        </div>
    </div>
</div>
