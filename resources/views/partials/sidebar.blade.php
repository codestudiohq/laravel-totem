<aside class="uk-width-1-6@l">
    <div class="">
        <img src="/vendor/totem/img/mask.svg" class="uk-svg">
        <div class="uk-text-large">Totem</div>
    </div>
    <ul class="uk-nav uk-nav-secondary">
        {{--<li class="nav-item {{ url()->current() == route('totem.dashboard') ? 'nav-item-active' : '' }}">--}}
            {{--<a class="nav-link" href="{{route('totem.dashboard')}}">--}}
                {{--<i>--}}
                    {{--<svg>--}}
                        {{--<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-dashboard"></use>--}}
                    {{--</svg>--}}
                {{--</i>--}}
                {{--KPI--}}
            {{--</a>--}}
        {{--</li>--}}
        <li class="{{ url()->current() == route('totem.tasks.all') ? 'uk-active' : '' }}">
            <a href="{{route('totem.tasks.all')}}" class="uk-flex uk-flex-middle">
                <img src="/vendor/totem/img/icons/clock.svg" width="15" heigh="15" class="uk-svg">
                <span class="uk-vertical-align-middle">Tasks</span>
            </a>
        </li>
    </ul>
</aside>