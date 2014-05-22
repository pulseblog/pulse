@if (Session::get('success_alert'))
    <div class="well is-success">
        {{ Session::get('success_alert') }}
    </div>
@endif
