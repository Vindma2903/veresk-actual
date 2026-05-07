<div class="flex flex-col-reverse gap-7 sm:flex-row" data-js-fade-scroll>
    <div class="sm:basis-1/2">
        <img src="{{ $img }}" alt="" class="sm:ml-auto">
    </div>
    <div>
        <a class="font-helvetica text-3xl lg:text-4xl underline decoration-2 text-[#adc1a4] hover:opacity-80" href="{{route('portfolios.show', ['slug' => $slug])}}">{{ $title }}</a>
        <div class="text-xl md:text-2xl opacity-60">{{ $description }}</div>
    </div>
</div>
