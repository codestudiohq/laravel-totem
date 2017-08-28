<aside class="uk-width-1-6@l uk-margin-bottom">
    <div class="uk-text-center">
        <img src="{{asset('vendor/totem/img/mask.svg')}}" class="uk-svg">
        <div class="uk-text-large">Totem</div>
    </div>
    <hr>
    <ul class="uk-nav uk-nav-default">
        <li class="{{ str_contains(url()->current(), 'tasks') ? 'uk-active' : '' }}">
            <a href="{{route('totem.tasks.all')}}" class="uk-flex uk-flex-middle">
                <icon name="clock" :scale="100" class="uk-visible@m uk-margin-small-right uk-icon"></icon>
                <span class="uk-vertical-align-middle">Tasks</span>
            </a>
        </li>
    </ul>
    <hr>
</aside>