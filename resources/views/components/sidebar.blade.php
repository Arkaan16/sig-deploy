<aside class="flex min-h-screen relative bg-sidebar w-64 hidden sm:block shadow-xl">
    <div class="p-6">
        <a href="#" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
    </div>
    <nav class="text-white text-base font-semibold pt-3">
        <!-- Dashboard -->
        <a href="{{ route('peta.index') }}" 
           class="flex items-center {{ request()->routeIs('peta.index') ? 'bg-blue-600 text-white' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>   
        <!-- Data Rumah Sakit -->
        <a href="{{ route('rumah-sakit.index') }}"
           class="flex items-center {{ request()->routeIs('rumah-sakit.*') ? 'bg-blue-600 text-white' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-hospital mr-3"></i>
            Data Rumah Sakit
        </a>
        <a href="{{ route('keluar') }}"
           class="flex items-center py-4 pl-6 nav-item opacity-75 hover:opacity-100">
            <i class="fas fa-sign-out-alt mr-3"></i>
            Keluar
        </a>
    </nav>
</aside>
