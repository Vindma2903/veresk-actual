<div class="sm:flex {{ ($isCentered ?? false) ? "sm:items-center" : "" }}" data-js-fade-scroll>
    <div class="sm:basis-1/4 opacity-40 uppercase text-sm font-helvetica mb-2.5 sm:mb-0 sm:mr-5">{{ $title ?? '' }}</div>
    <div class="sm:basis-3/4">
        {{$slot}}
    </div>
</div>
