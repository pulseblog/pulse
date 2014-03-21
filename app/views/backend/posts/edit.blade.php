@extends ('backend.templates.main')

@section ('breadcrumb')
    <ul class='breadcrumb'>
        <li>Pulse</li>
        <li>{{ link_to_action('Pulse\Backend\PostsController@index', 'Posts') }}</li>
        <li>Editting {{{ $post->title }}}</li>
    </ul>
@stop

@section ('content')
    <div class="l-block-1">
        @include ('backend.posts._form')
    </div>
@stop
