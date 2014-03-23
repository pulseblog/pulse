@extends('layouts.front')

@section('content')
    @foreach ($posts as $post)
        <div class="m-post-container">
            <a class="m-post-title" href="{{ URL::action('Pulse\Frontend\CmsController@showPost', ['slug'=>$post->slug]); }}">
                {{ $post->title }}
            </a>
            <div class="published-at">{{ date('M D,Y', strtotime($post->created_at)) }}</div>

            <img src="http://lorempixel.com/837/350/nature" alt="" class="m-post-image">

            <div class="m-post-short-content">
                {{ $post->lean_content }}
            </div>

            <a href="#" class="m-post-read-more">Read more</a>
        </div>
    @endforeach

    @if (count($posts) == 0)
        <div class="m-no-post-found">No posts =(</div>
    @endif
@stop
