@extends ('backend.templates.main')

@section ('breadcrumb')
    <ul class='breadcrumb'>
        <li>Pulse</li>
        <li>Posts</li>
    </ul>
@stop

@section ('content')
    <div class="l-block-1">
        <div class='toolbar'>
            {{ link_to_action('Pulse\Backend\PostsController@create', 'Criar página', null, ['class'=>'btn']) }}
        </div>

        @if ( $posts && count($posts) > 0 )
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

                @foreach ($posts as $post)
                    <tbody>
                        <tr>
                            <td>{{
                                    link_to_action(
                                      'Pulse\Backend\PostsController@show',
                                      $post->title,
                                      ['id' => $post->id ]
                                    )
                                }}
                            </td>
                            <td>{{ $post->slug }}</td>
                            <td>{{ $post->author_id }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td>
                                {{
                                    link_to_action(
                                      'Pulse\Backend\PostsController@edit',
                                      'Editar',
                                      ['id' => $post->id ]
                                    )
                                }}
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        @else
            <div class='well'>
                Não existe nenhum post,
                {{ link_to_action('Pulse\Backend\PostsController@create', 'crie a primeira!') }}
            </div>
        @endif
    </div>
@stop
