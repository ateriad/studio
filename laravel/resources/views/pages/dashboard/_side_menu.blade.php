<ul>
    <li>
        <a href="{{ route('dashboard.index') }}" class="side-menu @yield('side_dashboard')">
            <div class="side-menu__icon"><i data-feather="home"></i></div>
            <div class="side-menu__title">{{ trans('pages/general.dashboard') }}</div>
        </a>
    </li>

    @can('asset-categories-index|asset-categories-create')
        <li>
            <a href="javascript:void(0);" class="side-menu @yield('side_asset_categories')">
                <div class="side-menu__icon"><i data-feather="list"></i></div>
                <div class="side-menu__title">
                    {{ trans_choice('pages/general.asset_categories', 1) }}
                    <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul class="@yield('side_asset_categories_sub')">
                @can('asset-categories-index')
                    <li>
                        <a href="{{ route('dashboard.asset-categories.index') }}"
                           class="side-menu @yield('side_asset_categories_index')">
                            <div class="side-menu__icon"><i data-feather="activity"></i></div>
                            <div class="side-menu__title">{{ trans('pages/general.list') }}</div>
                        </a>
                    </li>
                @endcan
                @can('asset-categories-create')
                    <li>
                        <a href="{{ route('dashboard.asset-categories.create') }}"
                           class="side-menu @yield('side_asset_categories_create')">
                            <div class="side-menu__icon"><i data-feather="activity"></i></div>
                            <div class="side-menu__title">{{ trans('pages/general.create') }}</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan

    @can('assets-index|assets-create')
        <li>
            <a href="javascript:void(0);" class="side-menu @yield('side_assets')">
                <div class="side-menu__icon"><i data-feather="box"></i></div>
                <div class="side-menu__title">
                    {{ trans_choice('pages/general.assets', 1) }}
                    <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul class="@yield('side_assets_sub')">
                @can('assets-index')
                    <li>
                        <a href="{{ route('dashboard.assets.index') }}"
                           class="side-menu @yield('side_assets_index')">
                            <div class="side-menu__icon"><i data-feather="activity"></i></div>
                            <div class="side-menu__title">{{ trans('pages/general.list') }}</div>
                        </a>
                    </li>
                @endcan
                @can('assets-create')
                    <li>
                        <a href="{{ route('dashboard.assets.create') }}"
                           class="side-menu @yield('side_assets_create')">
                            <div class="side-menu__icon"><i data-feather="activity"></i></div>
                            <div class="side-menu__title">{{ trans('pages/general.create') }}</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan

    <li>
        <a href="{{ route('dashboard.playout.index') }}" class="side-menu @yield('side_studio')">
            <div class="side-menu__icon"><i data-feather="film"></i></div>
            <div class="side-menu__title">استادیو</div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.streams.index') }}" class="side-menu @yield('side_streams')">
            <div class="side-menu__icon"><i data-feather="play"></i></div>
            <div class="side-menu__title">رکورد ها</div>
        </a>
    </li>

    @can('users-index|users-create')
        <li>
            <a href="javascript:void(0);" class="side-menu @yield('side_users')">
                <div class="side-menu__icon"><i data-feather="box"></i></div>
                <div class="side-menu__title">
                    {{ trans_choice('pages/general.users', 1) }}
                    <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul class="@yield('side_users_sub')">
                @can('users-index')
                    <li>
                        <a href="{{ route('dashboard.users.index') }}"
                           class="side-menu @yield('side_users_index')">
                            <div class="side-menu__icon"><i data-feather="activity"></i></div>
                            <div class="side-menu__title">{{ trans('pages/general.list') }}</div>
                        </a>
                    </li>
                @endcan
                @can('users-create')
                    <li>
                        <a href="{{ route('dashboard.users.create') }}"
                           class="side-menu @yield('side_users_create')">
                            <div class="side-menu__icon"><i data-feather="activity"></i></div>
                            <div class="side-menu__title">{{ trans('pages/general.create') }}</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan

    @can('admins-index|admins-create')
        <li>
            <a href="javascript:void(0);" class="side-menu @yield('side_admins')">
                <div class="side-menu__icon"><i data-feather="box"></i></div>
                <div class="side-menu__title">
                    {{ trans_choice('pages/general.admins', 1) }}
                    <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul class="@yield('side_admins_sub')">
                @can('admins-index')
                    <li>
                        <a href="{{ route('dashboard.admins.index') }}"
                           class="side-menu @yield('side_admins_index')">
                            <div class="side-menu__icon"><i data-feather="activity"></i></div>
                            <div class="side-menu__title">{{ trans('pages/general.list') }}</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan

    <li>
        <a href="{{ route('dashboard.settings') }}" class="side-menu @yield('side_settings')">
            <div class="side-menu__icon"><i data-feather="settings"></i></div>
            <div class="side-menu__title">تنظیمات</div>
        </a>
    </li>
</ul>
