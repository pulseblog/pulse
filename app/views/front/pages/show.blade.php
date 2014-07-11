@extends('front.templates.main')

@section('content')
    <div class="l-block-1">
        {{ $pagePresenter->display() }}
    </div>
@stop
