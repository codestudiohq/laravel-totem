<template>
    <aside class="main-sidebar">
        <ul class="nav">
            <router-link tag="li" to="/dashboard" active-class="nav-item-active" class="nav-item">
                <a class="nav-link">
                    <i>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="#zondicon-dashboard"></use>
                        </svg>
                    </i>
                    Dashboard
                </a>
            </router-link>

            <router-link tag="li" to="/schedule" active-class="nav-item-active" class="nav-item">
                <a class="nav-link">
                    <i>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="#zondicon-timer"></use>
                        </svg>
                    </i>
                    Schedule
                </a>
            </router-link>
        </ul>
    </aside>
</template>
