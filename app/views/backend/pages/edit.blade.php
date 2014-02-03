{{ Form::model(
    $page,
    [
        'action' => ['Pulse\Backend\PagesController@update', $page->id],
        'method' => 'PUT',
    ]
   )
}}
    <fieldset>
        {{ Form::label('title', 'Título') }}
        {{ Form::text('title') }}
    </fieldset>

    <fieldset>
        {{ Form::label('slug', 'Slug') }}
        {{ Form::text('slug') }}
    </fieldset>

    <fieldset>
        {{ Form::label('lean_content', 'Resumo') }}
        {{ Form::textarea('lean_content') }}
    </fieldset>

    <fieldset>
        {{ Form::label('content', 'Conteúdo') }}
        {{ Form::textarea('content') }}
    </fieldset>

    {{ Form::submit('Salvar') }}

{{ Form::close() }}
