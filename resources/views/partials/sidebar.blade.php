<aside class="main-sidebar">
    <ul class="nav">
        {{--<li class="nav-item {{ request()->is(route('totem.dashboard')) ? 'nav-item-active' : '' }}">--}}
            {{--<a class="nav-link" href="{{route('totem.dashboard')}}">--}}
                {{--<i>--}}
                    {{--<svg>--}}
                        {{--<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-dashboard"></use>--}}
                    {{--</svg>--}}
                {{--</i>--}}
                {{--Dashboard--}}
            {{--</a>--}}
        {{--</li>--}}
        <li class="nav-item {{ url()->current() == route('totem.tasks.all') ? 'nav-item-active' : '' }}">
            <a class="nav-link" href="{{route('totem.tasks.all')}}">
                <i>
                    <svg>
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-time"></use>
                    </svg>
                </i>
                Tasks
            </a>
        </li>
    </ul>
</aside>