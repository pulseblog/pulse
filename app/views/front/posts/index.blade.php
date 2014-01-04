@foreach ($posts as $post)
    <h2>{{ $post->title }}</h2>
    <small>{{ $post->lean_content }}</small>
@endforeach
