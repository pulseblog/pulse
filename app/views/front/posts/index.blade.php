@extends('front.templates.main')

@section('content')
    @foreach ($posts as $post)
        <div class="l-block-1 postcard">
            {{ link_to_action('Pulse\Frontend\CmsController@showPost', $post->title, ['slug'=>$post->slug], ['class'=>'title h3']) }}

            <span class="date">
                {{ date('M d, Y', strtotime($post->created_at)) }}
            </span>

            <div class="short-content">
                {{{ $post->lean_content }}}
            </div>

            {{ link_to_action('Pulse\Frontend\CmsController@showPost', 'Read more', ['slug'=>$post->slug], ['class'=>'read-more']) }}
        </div>
    @endforeach

    @if (count($posts) == 0)
        <div class="h2">No posts =(</div>
    @endif
@stop
