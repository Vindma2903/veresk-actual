@php($menuItems = $site_options['top_menu'] ?? [])
{{--@php($socialItems = [['title' => 'Telegram', 'url' => '#', 'i' => 'lab la-telegram'], ['title' => 'Whatsapp', 'url' => '#', 'i' => 'lab la-whatsapp']])--}}
@php($socialItems = $site_options['top_menu_contacts'] ?? [])
<header class="bg-black z-10 fixed left-0 right-0 top-0">
    <div class="container">
        <div class="flex items-center justify-between h-[70px]">
            <div class="flex items-center my-animation-fadeInLeft">
                <a href="/">
                    <img src="{{asset('storage/theme_assets/img/header_logo.svg')}}" alt="Мастерская ландшафтов «Вереск»">
                </a>
                <div class="tracking-[.17em] text-sm opacity-[.6] pl-3.5 hidden md:block">
                    мастерская ландшафтов
                </div>
            </div>
            <div class="relative">
                <div id="js-header-collapse-button" data-menu_items="{{json_encode($menuItems)}}" data-menu_contacts="{{json_encode($site_options['top_menu_contacts_mobile'] ?? [])}}"></div>

                <div class="flex items-center">
                    <ul class="hidden lg:flex gap-x-5 text-base h-[70px]">
                        @foreach($menuItems as $item)
                            <li class="relative h-[70px] group">
                                <a href="{{ $item['url'] }}" class="h-full flex items-center hover:underline hover:underline-offset-4 px-0.5 xl:px-2">{{ $item['title'] }}</a>
                                @if (isset($item['children']))
                                    <ul class="group-hover:block hidden absolute z-10 bg-black border border-[#404040] top-[70px] w-[380px]">
                                        @foreach($item['children'] as $child)
                                            <li class="block border-[#404040] border-b last:border-b-0">
                                                <a href="{{ $child['url'] }}" class="block hover:bg-gray-800 p-2">
                                                    <i class="las la-angle-right opacity-40 mr-2.5"></i>
                                                    {{ $child['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    <div class="hidden lg:flex ml-9 items-center gap-2">
                        <div class="uppercase text-[.7rem] opacity-70 tracking-widest">
                            написать
                        </div>
                        @foreach($socialItems as $item)
                            <a href="{{$item['url']}}" class="h-[44px] w-[44px] rounded-full flex items-center justify-center px-2.5 bg-[#7D9B73] hover:opacity-90 text-white text-2xl" target="_blank" title="{{$item['title']}}">
                                <i class="{{$item['i']}}"></i>
                            </a>
                        @endforeach
                    </div>
{{--                    <div class="hidden lg:flex ml-5 items-center">--}}
{{--                        <div class="uppercase text-xs opacity-60 mr-2.5">--}}
{{--                            написать--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            @foreach($socialItems as $item)--}}
{{--                                <a href="{{$item['url']}}" class="h-[35px] flex items-center px-2.5 hover:bg-[#7D9B73]" target="_blank">--}}
{{--                                    <i class="{{$item['i']}}"></i>--}}
{{--                                    <span class="text-sm ml-2">{{$item['title']}}</span>--}}
{{--                                </a>--}}
{{--                                @if ($loop->first)--}}
{{--                                    <div class="border-b border-gray-600"></div>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>

{{--    {#  line after header  #}--}}
    <div class="flex">
        <div class="bg-[#7D9B73] h-[7px] w-1/3"></div>
        <div class="bg-[#DCEBCB] h-[7px] w-1/3"></div>
        <div class="bg-[#A2B09D] h-[7px] w-1/3"></div>
    </div>
</header>
