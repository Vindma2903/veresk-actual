<div class="sm:flex sm:justify-between max-w-[1080px] mx-auto" data-js-fade-scroll>
    <h3 class="opacity-40 uppercase mb-10 sm:mb-0 mr-10">{{ $title }}</h3>
    <div class="sm:max-w-[550px]">
        <div class="text-xl sm:text-2xl">{{ $description }}</div>
        @isset($afterDescription){{$afterDescription}}@endisset
    </div>
</div>
