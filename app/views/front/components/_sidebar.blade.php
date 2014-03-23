
<span class="logo">
    {{ HTML::image('assets/img/logo.png', $alt="Pulse" ) }}
</span>

<ul class="pages">
    @foreach($pages as $page)
        <li class="page-item">{{ $page->title }}</li>
    @endforeach
</ul>
