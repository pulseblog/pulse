@extends('front.templates.main')

@section('content')
    @foreach ($posts as $post)
        <div class="l-block-1">
            {{ link_to_action('Pulse\Frontend\CmsController@showPost', $post->title, ['slug'=>$post->slug], ['class'=>'title']) }}

            <div class="published-at">
                {{ date('M D, Y', strtotime($post->created_at)) }}
            </div>

            <img src="http://lorempixel.com/837/350/nature" alt="" class="m-post-image">

            <div class="m-post-short-content">
                {{{ $post->lean_content }}}
            </div>

            {{ link_to_action('Pulse\Frontend\CmsController@showPost', 'Read more', ['slug'=>$post->slug], ['class'=>'title']) }}
        </div>
    @endforeach

    @if (count($posts) == 0)
        <div class="m-no-post-found">No posts =(</div>
    @endif
@stop
