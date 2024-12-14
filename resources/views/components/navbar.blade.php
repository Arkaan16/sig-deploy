<nav class="flex flex-wrap items-center justify-between p-3 bg-sky-200 sticky top-0 z-50">
    <div class="flex items-center">
        <img src="/assets/img/logol.png" alt="Logo" class="h-12 mr-4">
        <div class="text-2xl font-bold">SIG Lampung Selatan</div>
    </div>
    <div class="flex md:hidden">
        <button id="hamburger">
            <img class="toggle block" src="https://img.icons8.com/fluent-systems-regular/2x/menu-squared-2.png" width="40" height="40" />
            <img class="toggle hidden" src="https://img.icons8.com/fluent-systems-regular/2x/close-window.png" width="40" height="40" />
        </button>
    </div>
    <div class="toggle hidden w-full md:w-auto md:flex text-right text-bold mt-5 md:mt-0 md:border-none space-y-3 md:space-y-0 md:space-x-5">
        <a href="{{ url('/') }}#home" 
           class="block md:inline-block hover:text-sky-300 px-3 py-3 md:border-none {{ Request::is('/') ? 'bg-sky-700 rounded text-white' : '' }}">
           Beranda
        </a>
        <a href="/peta" 
           class="block md:inline-block hover:text-sky-300 px-3 py-3 md:border-none ">
           Peta
        </a>
    </div>
</nav>
