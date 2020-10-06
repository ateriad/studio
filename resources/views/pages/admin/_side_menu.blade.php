<ul>
    <li>
        <a href="{{ route('admin.dashboard') }}" class="side-menu @yield('side_dashboard')">
            <div class="side-menu__icon"><i data-feather="home"></i></div>
            <div class="side-menu__title">{{ trans('pages/general.dashboard') }}</div>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);" class="side-menu @yield('side_asset_categories')">
            <div class="side-menu__icon"><i data-feather="list"></i></div>
            <div class="side-menu__title">
                {{ trans_choice('pages/general.asset_categories', 1) }}
                <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
            </div>
        </a>
        <ul class="@yield('side_asset_categories_sub')">
            <li>
                <a href="{{ route('admin.asset-categories.index') }}"
                   class="side-menu @yield('side_asset_categories_index')">
                    <div class="side-menu__icon"><i data-feather="activity"></i></div>
                    <div class="side-menu__title">{{ trans('pages/general.list') }}</div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.asset-categories.create') }}"
                   class="side-menu @yield('side_asset_categories_create')">
                    <div class="side-menu__icon"><i data-feather="activity"></i></div>
                    <div class="side-menu__title">{{ trans('pages/general.create') }}</div>
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript:void(0);" class="side-menu @yield('side_assets')">
            <div class="side-menu__icon"><i data-feather="box"></i></div>
            <div class="side-menu__title">
                {{ trans_choice('pages/general.assets', 1) }}
                <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
            </div>
        </a>
        <ul class="@yield('side_assets_sub')">
            <li>
                <a href="{{ route('admin.assets.index') }}"
                   class="side-menu @yield('side_assets_index')">
                    <div class="side-menu__icon"><i data-feather="activity"></i></div>
                    <div class="side-menu__title">{{ trans('pages/general.list') }}</div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.assets.create') }}"
                   class="side-menu @yield('side_assets_create')">
                    <div class="side-menu__icon"><i data-feather="activity"></i></div>
                    <div class="side-menu__title">{{ trans('pages/general.create') }}</div>
                </a>
            </li>
        </ul>
    </li>

</ul>
