@extends('front.templates.main')

@section('content')
    {{ $postPresenter->display() }}
@stop
