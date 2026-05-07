@extends('base')
@php
    $aboutItems = [
        'Исходная ситуация' => 'На участке уже был построен дом, в котором проживали заказчики. Также был залит фундамент под баню.',
        'задача' => 'Провести на участке все необходимые коммуникации; выбрать место для реализации гаража и парковки; обустроить входную зону; предусмотреть место для детской площадки;организовать зону для огородных посадок. ',
        'Решение' => 'Решено подчеркнуть ландшафт созданием парадной зоны с сухим ручьём и мостиком. По берегам предусмотрены  островки зелени.',
    ];
@endphp

@section('main_before')
    <div class="container my-14 lg:my-20">
        <div class="lg:flex lg:gap-x-10 lg:justify-between">
            <div>
                <h1 class="text-4xl lg:text-7xl uppercase">Лунное озеро</h1>
                <span class="text-2xl opacity-60">Май'22</span>
            </div>
            <div class="mt-7 lg:mt-0 lg:max-w-[570px] text-sm">
                @foreach($aboutItems as $t => $d)
                    <div class="pt-5 pb-7 border-b border-gray-500 first:border-t first:border-gray-500 md:flex">
                        <div class="opacity-60 uppercase mb-5 md:basis-[240px]">{{$t}}</div>
                        <div class="md:basis-full">{{$d}}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="flex flex-col gap-24 lg:gap-32">
        <img src="{{asset('storage/theme_assets/moon-lake/0.jpg')}}" alt="">

        <div class="w-4/5 lg:w-1/2 xl:w-2/5 text-lg lg:text-2xl text-right ml-auto md:ml-0">Особенности данного рельефа требуют подпорной стенки.  Она выгодно совмещается с зоной парковки и гаражом.</div>

        @include('_parts/three_images_inline', ['images' => [asset('storage/theme_assets/moon-lake/1.jpg'), asset('storage/theme_assets/moon-lake/2.jpg'), asset('storage/theme_assets/moon-lake/3.jpg')]])

        <img src="{{asset('storage/theme_assets/moon-lake/4.jpg')}}" alt="">

        <div class="w-4/5 lg:w-1/2 xl:w-2/5 opacity-60 uppercase text-sm md:ml-auto lg:mr-40">Ландшафт территории посёлка включает в себя большое количество валунов. Некоторые зарыты в грунт, а часть располагалась на участке. Из-за внушительных размеров валунов было принято решение их дробить и вывозить частями. </div>

        <div>
            <img src="{{asset('storage/theme_assets/moon-lake/5.jpg')}}" alt="">
        </div>

        <div class="flex gap-3">
            <div class="basis-1/3"></div>
            <div class="basis-1/3">
                <img src="{{asset('storage/theme_assets/moon-lake/6.jpg')}}" alt="">
            </div>
            <div class="basis-1/3">
                <img src="{{asset('storage/theme_assets/moon-lake/7.jpg')}}" alt="">
            </div>
        </div>

        <div class="w-4/5 lg:w-1/2 xl:w-2/5 opacity-60 uppercase text-sm text-right lg:ml-40">Самими красивыми и большими камнями выделили детскую зону, а рядом разместили огородную территорию с приподнятыми грядами из лиственницы. Произвели посадку качественных овощных культур и ягод.</div>

        <div class="flex gap-3">
            <div class="basis-1/3">
                <img src="{{asset('storage/theme_assets/moon-lake/8.jpg')}}" alt="">
            </div>
            <div class="basis-2/3">
                <img src="{{asset('storage/theme_assets/moon-lake/9.jpg')}}" alt="">
            </div>
        </div>

        <div class="w-4/5 lg:w-1/2 xl:w-2/5 opacity-60 uppercase text-sm md:ml-auto lg:mr-40">На этапе обсуждения проекта с заказчиком решили выделить небольшое естественное углубление. Там реализовали пруд и зону отдыха с видом на озеро и лес.</div>
    </div>
@endsection
