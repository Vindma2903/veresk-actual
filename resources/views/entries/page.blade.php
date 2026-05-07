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
@endsection

@section('custom_scripts')
    <script type="text/javascript">
        window.service_slider_data = '{{json_encode($service_slider_data)}}'.replace(/&quot;/ig,'"');
    </script>
@endsection
