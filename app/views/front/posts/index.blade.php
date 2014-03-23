@extends('layouts.front')

@section('content')
    @foreach ($posts as $post)
        <a href="{{ URL::action('Pulse\Frontend\CmsController@showPost', ['slug'=>$post->slug]); }}">
            <h2>{{ $post->title }}</h2>
            <small>{{ $post->lean_content }}</small>
        </a>
    @endforeach
    @if (count($posts) == 0)
        <div class="m-no-post-found">No posts =(</div>
    @endif
@stop
