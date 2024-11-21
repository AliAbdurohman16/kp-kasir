<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="" class="sidebar-logo justify-content-center">
            <img src="{{ asset('backend') }}/assets/images/logo-toko.png" alt="site logo" class="light-logo">
            <img src="{{ asset('backend') }}/assets/images/logo-toko.png" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li class="{{ request()->is('dashboard') ? 'active-page' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->hasRole('admin'))
            <li class="{{ request()->is('cashier*') ? 'active-page' : '' }}">
                <a href="{{ route('cashier.index') }}">
                    <iconify-icon icon="emojione-monotone:fax-machine" class="menu-icon"></iconify-icon>
                    <span>Kasir</span>
                </a>
            </li>
            @endif
            @if (Auth::user()->hasRole('owner'))
            <li class="{{ request()->is('log-activities') ? 'active-page' : '' }}">
                <a href="{{ route('log-activities') }}">
                    <iconify-icon icon="mage:clock" class="menu-icon"></iconify-icon>
                    <span>Log Aktivitas</span>
                </a>
            </li>
            @endif
            @if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('kepala-toko'))
            <li class="dropdown {{ request()->is('products*') ? 'open' : '' }}">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:gallery-wide-linear" class="menu-icon"></iconify-icon>
                    <span>Produk</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('products.index') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Semua Produk</a>
                    </li>
                    <li>
                        <a href="{{ route('safe-stock') }}"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Stok Masih Ada</a>
                    </li>
                    <li>
                        <a href="{{ route('out-of-stock') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Stok Habis</a>
                    </li>
                </ul>
            </li>
            @endif
            @if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
            <li class="{{ request()->is('transactions') ? 'active-page' : '' }}">
                <a href="{{ route('transactions') }}">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Transaksi</span>
                </a>
            </li>
            <li class="{{ request()->is('report*') ? 'active-page' : '' }}">
                <a href="{{ route('report.index') }}">
                    <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                    <span>Laporan</span>
                </a>
            </li>
            @endif
            @if (Auth::user()->hasRole('owner'))
            <li class="{{ request()->is('employees*') ? 'active-page' : '' }}">
                <a href="{{ route('employees.index') }}">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>Data Pegawai</span>
                </a>
            </li>
            @endif
            <li class="{{ request()->is('profile*') ? 'active-page' : '' }}">
                <a href="{{ route('profile.index') }}">
                    <iconify-icon icon="solar:user-linear" class="menu-icon"></iconify-icon>
                    <span>Profile</span>
                </a>
            </li>
            <li class="{{ request()->is('password-change*') ? 'active-page' : '' }}">
                <a href="{{ route('password-change.index') }}">
                    <iconify-icon icon="tabler:key" class="menu-icon"></iconify-icon>
                    <span>Ubah Kata Sandi</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <iconify-icon icon="lucide:power" class="menu-icon"></iconify-icon>
                    <span>Keluar</span>
                </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>
    </div>
</aside>