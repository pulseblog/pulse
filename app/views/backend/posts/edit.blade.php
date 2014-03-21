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
        {{ Form::model(
            $post,
            [
                'action' => ['Pulse\Backend\PostsController@update', $post->id],
                'method' => 'PUT',
            ]
           )
        }}
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
                {{ link_to_action('Pulse\Backend\PostsController@destroy', 'Excluir', ['id'=>$post->id], ['method'=>'delete', 'class'=>'btn is-danger']) }}
            </div>

        {{ Form::close() }}
    </div>
@stop
