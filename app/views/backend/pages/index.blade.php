<div>
    {{ link_to_action('Pulse\Backend\PagesController@create', 'Criar página') }}
</div>

@if ( $pages && $pages->count() > 0 )
    <table>
        <tr>
            <th>Título</th>
            <th>Slug</th>
            <th>Autor</th>
            <th>Data de criação</th>
        </tr>

        @foreach ($pages as $page)
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
        @endforeach
    </table>
@else
    Não existe nenhuma página criada,
    {{ link_to_action('Pulse\Backend\PagesController@create', 'crie a primeira!') }}
@endif
