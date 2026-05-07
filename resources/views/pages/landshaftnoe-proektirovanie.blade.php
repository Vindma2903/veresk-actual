@extends('base')

@section('main_before')
    @include('pages._landshaftnoe-proektirovanie_parts.intro')
@endsection

@section('main')
    <div class="container">
        @include('pages._landshaftnoe-proektirovanie_parts.services')
    </div>
@endsection
