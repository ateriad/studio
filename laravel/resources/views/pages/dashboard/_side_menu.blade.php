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
</ul>
