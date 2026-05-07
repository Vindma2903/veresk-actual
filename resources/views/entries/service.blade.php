@extends('base')

@section('main_before')
    @if (!empty($entry->title_img))
        <div  class="bg-cover bg-center bg-no-repeat relative" style="background-image: url('{{asset('storage/' . $entry->title_img)}}')">
            <div class="absolute top-0 bottom-0 left-0 right-0 bg-black opacity-60"></div>
            <div class="container relative">
                <div class="h-[500px] flex flex-col justify-center">
                    <h1 class="text-4xl sm:text-6xl text-center">{{$entry->title}}</h1>
                </div>
            </div>
        </div>
    @else
        <h1 class="text-4xl sm:text-6xl text-center my-28">{{$entry->title}}</h1>
    @endif
@endsection

@section('content')
    <div class="lg:flex">
        <div class="mb-10 lg:mb-0 lg:w-2/5 lg:pr-10">
            <div class="sticky top-24">
                <div class="tree-menu" id="js-tree-menu">
                    @include('entries._entry_parts._service_tree_menu', [
                        'tree' => $tree,
                        'root_id' => $root_id,
                        'current_id' => $entry->id,
                    ])
                </div>
            </div>
        </div>
        <div class="lg:w-3/5">
            <div class="entry-content js-modal-images">
                {!! $entry->body !!}
            </div>
        </div>
    </div>

    @if (!empty($service_works))
        <h3 class="text-3xl mb-5 mt-10">
            Наши работы
            <i class="las la-long-arrow-alt-left opacity-40"></i>
            <i class="las la-long-arrow-alt-right opacity-40"></i>
        </h3>
        <div class="js-modal-images flex overflow-x-scroll my-scrollbar-width-none gap-x-6 lg:justify-between lg:w-full" data-js-horizontal-scroll-wheel>
            @foreach($service_works as $img)
                <div class="basis-[200px] sm:basis-[300px] grow-0 shrink-0">
                    <a href="{{asset('storage/' . $img)}}">
                        <img src="/imager/{{$img}}?w=300&h=225&fit=crop" alt="">
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
