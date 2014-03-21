@extends ('backend.templates.main')

@section ('breadcrumb')
    <ul class='breadcrumb'>
        <li>Pulse</li>
        <li>{{ link_to_action('Pulse\Backend\PostsController@index', 'Posts') }}</li>
        <li>New Post</li>
    </ul>
@stop

@section ('content')
    <div class="l-block-1">
        {{ Form::model($post, [ 'action' => 'Pulse\Backend\PostsController@store' ]) }}
            <fieldset>
                {{ Form::label('title', trans('resources.attributes.Post.title')) }}
                {{ Form::text('title') }}
            </fieldset>

            <fieldset>
                {{ Form::label('slug', trans('resources.attributes.Post.slug')) }}
                {{ Form::text('slug') }}
            </fieldset>

            <fieldset>
                {{ Form::label('lean_content', trans('resources.attributes.Post.lean_content')) }}
                {{ Form::textarea('lean_content') }}
            </fieldset>

            <fieldset>
                {{ Form::label('content', trans('resources.attributes.Post.content')) }}
                {{ Form::textarea('content') }}
            </fieldset>

            <div class='well'>
                {{ Form::submit('Salvar Pagina') }}
                {{ link_to_action('Pulse\Backend\PostsController@index', 'Cancelar', null, ['class'=>'btn is-inverted']) }}
            </div>


        {{ Form::close() }}
    </div>
@stop
