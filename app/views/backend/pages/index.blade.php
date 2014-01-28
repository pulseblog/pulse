@extends ('backend.templates.main')

@section ('breadcrumb')
    <ul class='breadcrumb'>
        <li>Pulse</li>
        <li>Pages</li>
    </ul>
@stop

@section ('content')
    <div class="l-block-1">
        <div class='toolbar'>
            {{ link_to_action('Pulse\Backend\PagesController@create', 'Criar página', null, ['class'=>'btn']) }}
        </div>

        @if ( $pages && $pages->count() > 0 )
            <table>
                <thead>
                    <tr>
                        <th>{{ trans('resources.attributes.Page.title') }}</th>
                        <th>{{ trans('resources.attributes.Page.slug') }}</th>
                        <th>{{ trans('resources.attributes.Page.author') }}</th>
                        <th>{{ trans('resources.attributes.Page.created_at') }}</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                @foreach ($pages as $page)
                    <tbody>
                        <tr>
                            <td>{{
                                    link_to_action(
                                      'Pulse\Backend\PagesController@show',
                                      $page->title,
                                      ['id' => $page->id ]
                                    )
                                }}
                            </td>
                            <td>{{ $page->slug }}</td>
                            <td>{{ $page->author_id }}</td>
                            <td>{{ $page->created_at }}</td>
                            <td>
                                {{
                                    link_to_action(
                                      'Pulse\Backend\PagesController@edit',
                                      'Editar',
                                      ['id' => $page->id ]
                                    )
                                }}
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        @else
            <div class='well'>
                Não existe nenhuma página criada,
                {{ link_to_action('Pulse\Backend\PagesController@create', 'crie a primeira!') }}
            </div>
        @endif
    </div>
@stop
