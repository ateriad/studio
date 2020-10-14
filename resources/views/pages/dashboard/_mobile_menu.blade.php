<ul class="border-t border-theme-24 py-5 hidden">
    <li>
        <a href="{{ route('dashboard.index') }}" class="menu @yield('mobile_dashboard')">
            <div class="menu__icon"><i data-feather="home"></i></div>
            <div class="menu__title">{{ trans('pages/general.dashboard') }}</div>
        </a>
    </li>
    @can('asset-categories-index|asset-categories-create')
        <li>
            <a href="javascript:void(0);" class="menu @yield('mobile_asset_categories')">
                <div class="menu__icon"><i data-feather="list"></i></div>
                <div class="menu__title">
                    {{ trans_choice('pages/general.asset_categories', 1) }}
                    <i data-feather="chevron-down" class="menu__sub-icon"></i>
                </div>
            </a>
            <ul class="@yield('mobile_asset_categories_sub')">
                @can('asset-categories-index')
                    <li>
                        <a href="{{ route('dashboard.asset-categories.index') }}"
                           class="menu @yield('mobile_asset_categories_index')">
                            <div class="menu__icon"><i data-feather="activity"></i></div>
                            <div class="menu__title">{{ trans('pages/general.list') }}</div>
                        </a>
                    </li>
                @endcan
                @can('asset-categories-create')
                    <li>
                        <a href="{{ route('dashboard.asset-categories.create') }}"
                           class="menu @yield('mobile_asset_categories_create')">
                            <div class="menu__icon"><i data-feather="activity"></i></div>
                            <div class="menu__title">{{ trans('pages/general.create') }}</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
    @can('assets-index|assets-create')
        <li>
            <a href="javascript:void(0);" class="menu @yield('mobile_assets')">
                <div class="menu__icon"><i data-feather="list"></i></div>
                <div class="menu__title">
                    {{ trans_choice('pages/general.assets', 1) }}
                    <i data-feather="chevron-down" class="menu__sub-icon"></i>
                </div>
            </a>
            <ul class="@yield('mobile_assets_sub')">
                @can('assets-index')
                    <li>
                        <a href="{{ route('dashboard.assets.index') }}"
                           class="menu @yield('mobile_assets_index')">
                            <div class="menu__icon"><i data-feather="activity"></i></div>
                            <div class="menu__title">{{ trans('pages/general.list') }}</div>
                        </a>
                    </li>
                @endcan
                @can('assets-create')
                    <li>
                        <a href="{{ route('dashboard.assets.create') }}"
                           class="menu @yield('mobile_assets_create')">
                            <div class="menu__icon"><i data-feather="activity"></i></div>
                            <div class="menu__title">{{ trans('pages/general.create') }}</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
</ul>
