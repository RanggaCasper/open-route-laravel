<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="https://www.pnb.ac.id/img/logo-pnb.3aae610b.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <div class="gap-2 mt-3 d-flex align-items-center">
                    <img src="https://www.pnb.ac.id/img/logo-pnb.3aae610b.png" alt="Logo" height="32">
                    <div class="text-white flex-grow-2">
                        <h6 class="p-0 m-0 text-white opacity-75 fw-bolder">{{ config('app.name') }}</h6>
                        <h6 class="p-0 m-0 text-white opacity-50">Control Panel</h6>
                    </div>
                </div>
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="https://www.pnb.ac.id/img/logo-pnb.3aae610b.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <div class="gap-2 mt-3 d-flex align-items-center">
                    <img src="https://www.pnb.ac.id/img/logo-pnb.3aae610b.png" alt="Logo" height="32">
                    <div class="text-white flex-grow-2">
                        <h6 class="p-0 m-0 text-white opacity-75 fw-bolder">{{ config('app.name') }}</h6>
                        <h6 class="p-0 m-0 text-white opacity-50">Control Panel</h6>
                    </div>
                </div>
            </span>
        </a>
        <button type="button" class="p-0 btn btn-sm fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                @php
                    $menus = App\Models\MenuGroup::query()
                        ->with('items', function ($query) {
                            return $query->where('status', true)->orderBy('position');
                        })
                        ->where('status', true)
                        ->orderBy('position')
                        ->get();
                @endphp
                @foreach ($menus as $menu)
                    @can($menu->permission_name)
                    <x-menu-title title="{{ $menu->name }}" />
                        @foreach ($menu->items as $item)
                            @can($item->permission_name)
                                <x-navlink icon="{{ $item->icon }}" title="{{ $item->name }}" href="{{ route($item->route) }}" active="{{ request()->routeIs($item->route) }}" />
                            @endcan
                        <!-- end can item -->
                        @endforeach
                    <!-- end foreach items -->
                    @endcan
                <!-- end can menu -->
                @endforeach
                
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>