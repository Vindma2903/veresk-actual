@extends('base')

@section('main_before')
    @if (!empty($entry->body_before))
        {!! $entry->body_before !!}
    @endif
@endsection

@section('main')
    @if (empty($entry->body_before))
        <div class="container">
            <h1 class="text-5xl sm:text-7xl mb-24 uppercase">{{$entry->title}}</h1>
        </div>
    @endif
    {!! $entry->body !!}

    <div class="container">
        @include('entries._entry_parts._portfolio_works')
    </div>
@endsection
