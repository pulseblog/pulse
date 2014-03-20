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
        {{ Form::model(
            $page,
            [
                'action' => ['Pulse\Backend\PagesController@update', $page->id],
                'method' => 'PUT',
            ]
           )
        }}
            <fieldset>
                {{ Form::label('title', trans('resources.attributes.Page.title')) }}
                {{ Form::text('title') }}
            </fieldset>

            <fieldset>
                {{ Form::label('slug', trans('resources.attributes.Page.slug')) }}
                {{ Form::text('slug') }}
            </fieldset>

            <fieldset>
                {{ Form::label('lean_content', trans('resources.attributes.Page.lean_content')) }}
                {{ Form::textarea('lean_content') }}
            </fieldset>

            <fieldset>
                {{ Form::label('content', trans('resources.attributes.Page.content')) }}
                {{ Form::textarea('content') }}
            </fieldset>

            <div class='well'>
                {{ Form::submit('Salvar Pagina') }}
                {{ link_to_action('Pulse\Backend\PagesController@index', 'Cancelar', null, ['class'=>'btn is-inverted']) }}
                {{ link_to_action('Pulse\Backend\PagesController@destroy', 'Excluir', ['id'=>$page->id], ['method'=>'delete', 'class'=>'btn is-danger']) }}
            </div>

        {{ Form::close() }}
    </div>
@stop
