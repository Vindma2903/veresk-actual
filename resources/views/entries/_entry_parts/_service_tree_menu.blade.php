<ul>
    @foreach($tree as $item)
        @php
            $hasChildren = isset($item['children']);
            $isParent = $item['parent_id'] === null;
            $itemClasses = [];
            $isCurrent = isset($current_id) && $current_id === $item['id'];
            if (!$isParent) $itemClasses[] = 'ml-5';
            if (isset($root_id) && $root_id === $item['id']) $itemClasses[] = 'active';
        @endphp
        <li class="{{join(' ', $itemClasses)}}" data-id="{{$item['id']}}">
            <div class="flex items-center justify-between gap-x-2.5">
                <a href="/services/{{$item['slug']}}">
                    <i class="las la-angle-right opacity-40 mr-1"></i>
                    <span class="{{$isCurrent ? 'text-[#adc1a4]' : ''}}">{{ $item['title']}}</span>
                </a>
                @if ($hasChildren && $isParent)
                    <button type="button" class="border w-[36px] h-[36px] rounded-full">
                        <i class="las la-arrow-down"></i>
                    </button>
                @endif
            </div>
            @if($hasChildren)
                <ul>
                    @foreach($item['children'] as $child)
                        <li class="ml-5" data-id="{{$child['id']}}">
                            <div class="flex items-center justify-between gap-x-2.5">
                                <a href="/services/{{$child['slug']}}">
                                    <i class="las la-angle-right opacity-40 mr-1"></i>
                                    <span class="{{isset($current_id) && $current_id === $child['id'] ? 'text-[#adc1a4]' : ''}}">{{ $child['title']}}</span>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
