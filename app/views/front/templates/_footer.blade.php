<div class="l-block-1 social-links">
    <hr>
    @if (Config::get('pulse.social_networks.facebook'))
        {{ link_to(Config::get('pulse.social_networks.facebook'), "facebook", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.googleplus'))
        {{ link_to(Config::get('pulse.social_networks.googleplus'), "googleplus", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.github'))
        {{ link_to(Config::get('pulse.social_networks.github'), "githubalt", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.twitter'))
        {{ link_to(Config::get('pulse.social_networks.twitter'), "twitterbird", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.deviantart'))
        {{ link_to(Config::get('pulse.social_networks.deviantart'), "deviantart", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.pinterest'))
        {{ link_to(Config::get('pulse.social_networks.pinterest'), "pinterest", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.youtube'))
        {{ link_to(Config::get('pulse.social_networks.youtube'), "youtube", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.vimeo'))
        {{ link_to(Config::get('pulse.social_networks.vimeo'), "vimeo", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.tumblr'))
        {{ link_to(Config::get('pulse.social_networks.tumblr'), "tumblr", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.flickr'))
        {{ link_to(Config::get('pulse.social_networks.flickr'), "flickr", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.instagram'))
        {{ link_to(Config::get('pulse.social_networks.instagram'), "instagram", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.lastfm'))
        {{ link_to(Config::get('pulse.social_networks.lastfm'), "lastfm", ['class'=>'social-icon']) }}
    @endif
    @if (Config::get('pulse.social_networks.linkedin'))
        {{ link_to(Config::get('pulse.social_networks.linkedin'), "linkedin", ['class'=>'social-icon']) }}
    @endif
</div>
