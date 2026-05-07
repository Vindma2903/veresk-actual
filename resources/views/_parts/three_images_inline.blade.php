<div class="flex gap-1.5 sm:gap-3" data-js-fade-scroll>
    @foreach($images as $img)
        <div>
            <img src="{{ $img }}" class="max-w-full" alt="">
        </div>
    @endforeach
</div>
