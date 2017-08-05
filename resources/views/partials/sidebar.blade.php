<aside class="main-sidebar">
    <div class="pb3">
        <div class="aic jcsb ft22 fw9">
            <img src="/vendor/totem/img/mask.svg">
            <div class="tcg5">Totem</div>
        </div>


    </div>
    <ul class="nav">
        <li class="nav-item {{ url()->current() == route('totem.dashboard') ? 'nav-item-active' : '' }}">
            <a class="nav-link" href="{{route('totem.dashboard')}}">
                <i>
                    <svg>
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-dashboard"></use>
                    </svg>
                </i>
                Dashboard
            </a>
        </li>
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