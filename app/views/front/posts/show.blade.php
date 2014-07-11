@extends('front.templates.main')

@section('content')
    <div class="l-block-1">
        {{ $postPresenter->display() }}
    </div>

    @if (Config::get("pulse.discuss_name", null))
        <div class="l-block-1">
            <hr>
            <div id="disqus_thread"></div>
            <script type="text/javascript">
                var disqus_shortname  = '{{ Config::get("pulse.discuss_name", "pulse-blogging") }}';
                var disqus_identifier = '{{$post->id}}';
                var disqus_title = '{{$post->title}}';

                (function() {
                    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments.</a></noscript>
            <a href="http://disqus.com" class="dsq-brlink"></a>

        </div>
    @endif
@stop
