@extends ('backend.templates.main')

@section ('breadcrumb')
    <ul class='breadcrumb'>
        <li>Pulse</li>
        <li>{{ link_to_action('Pulse\Backend\PagesController@index', 'Pages') }}</li>
        <li>Editting {{{ $page->title }}}</li>
    </ul>
@stop

@section ('content')
    <div class="l-block-1">
        @include ('backend.pages._form')
    </div>
@stop
