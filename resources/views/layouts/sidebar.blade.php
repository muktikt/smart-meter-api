<aside class="fixed left-0 top-0 w-[290px] h-screen bg-[#2191d1] text-white px-5 py-6 hidden lg:flex flex-col shadow-2xl overflow-y-auto z-50">

    <!-- LOGO -->
    <div class="mb-8">

        <div class="flex items-center gap-3">

            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-2xl shadow-lg">
                💧
            </div>

            <div>

                <h1 class="text-2xl font-bold leading-tight">
                    Smart Meter
                </h1>

                <p class="text-blue-100 text-sm">
                    PDAM Tirta Dharma Ayu
                </p>

            </div>

        </div>

    </div>

    <!-- MENU -->
    <nav class="flex-1 space-y-2">

        <!-- DASHBOARD -->
        <a href="/dashboard"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300
           {{ request()->is('dashboard') ? 'bg-white text-[#2191d1] shadow-lg' : 'hover:bg-white/10 text-white' }}">

            <span class="text-xl">📊</span>

            <div>

                <p class="font-semibold text-sm">
                    Dashboard
                </p>

                <p class="text-[11px] {{ request()->is('dashboard') ? 'text-gray-500' : 'text-blue-100' }}">
                    Statistik sistem
                </p>

            </div>

        </a>

        <!-- PELANGGAN -->
        <a href="/pelanggan"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300
           {{ request()->is('pelanggan*') ? 'bg-white text-[#2191d1] shadow-lg' : 'hover:bg-white/10 text-white' }}">

            <span class="text-xl">👥</span>

            <div>

                <p class="font-semibold text-sm">
                    Pelanggan
                </p>

                <p class="text-[11px] {{ request()->is('pelanggan*') ? 'text-gray-500' : 'text-blue-100' }}">
                    Data pelanggan
                </p>

            </div>

        </a>

        <!-- PETUGAS -->
        <a href="/petugas"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300
           {{ request()->is('petugas*') ? 'bg-white text-[#2191d1] shadow-lg' : 'hover:bg-white/10 text-white' }}">

            <span class="text-xl">👨‍🔧</span>

            <div>

                <p class="font-semibold text-sm">
                    Petugas
                </p>

                <p class="text-[11px] {{ request()->is('petugas*') ? 'text-gray-500' : 'text-blue-100' }}">
                    Monitoring petugas
                </p>

            </div>

        </a>

        <!-- METER -->
        <a href="/meter"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300
           {{ request()->is('meter*') ? 'bg-white text-[#2191d1] shadow-lg' : 'hover:bg-white/10 text-white' }}">

            <span class="text-xl">💧</span>

            <div>

                <p class="font-semibold text-sm">
                    Meter Air
                </p>

                <p class="text-[11px] {{ request()->is('meter*') ? 'text-gray-500' : 'text-blue-100' }}">
                    Upload meter
                </p>

            </div>

        </a>

        <!-- TAGIHAN -->
        <a href="/tagihan"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300
           {{ request()->is('tagihan*') ? 'bg-white text-[#2191d1] shadow-lg' : 'hover:bg-white/10 text-white' }}">

            <span class="text-xl">💳</span>

            <div>

                <p class="font-semibold text-sm">
                    Tagihan
                </p>

                <p class="text-[11px] {{ request()->is('tagihan*') ? 'text-gray-500' : 'text-blue-100' }}">
                    Pembayaran
                </p>

            </div>

        </a>

        <!-- PENGADUAN -->
        <a href="/pengaduan"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 relative
           {{ request()->is('pengaduan*') ? 'bg-white text-[#2191d1] shadow-lg' : 'hover:bg-white/10 text-white' }}">

            <span class="text-xl">📢</span>

            <div class="flex-1">

                <p class="font-semibold text-sm">
                    Pengaduan
                </p>

                <p class="text-[11px] {{ request()->is('pengaduan*') ? 'text-gray-500' : 'text-blue-100' }}">
                    Keluhan pelanggan
                </p>

            </div>

        </a>

        <!-- GANGGUAN -->
        <a href="/gangguan"
        class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300
        {{ request()->is('gangguan*') ? 'bg-white text-[#2191d1] shadow-lg' : 'hover:bg-white/10 text-white' }}">

            <span class="text-xl">🚧</span>

            <div>

                <p class="font-semibold text-sm">
                    Gangguan Air
                </p>

                <p class="text-[11px] {{ request()->is('gangguan*') ? 'text-gray-500' : 'text-blue-100' }}">
                    Informasi gangguan
                </p>

            </div>

        </a>

        <!-- MONITORING -->
        <a href="/monitoring"
        class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300
        {{ request()->is('monitoring*') ? 'bg-white text-[#2191d1] shadow-lg' : 'hover:bg-white/10 text-white' }}">

            <span class="text-xl">📈</span>

            <div>

                <p class="font-semibold text-sm">
                    Monitoring
                </p>

                <p class="text-[11px] {{ request()->is('monitoring*') ? 'text-gray-500' : 'text-blue-100' }}">
                    Monitoring realtime
                </p>

            </div>

        </a>

        <!-- LAPORAN -->
        <a href="/laporan"
        class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300
        {{ request()->is('laporan*') ? 'bg-white text-[#2191d1] shadow-lg' : 'hover:bg-white/10 text-white' }}">

            <span class="text-xl">📄</span>

            <div>

                <p class="font-semibold text-sm">
                    Laporan
                </p>

                <p class="text-[11px] {{ request()->is('laporan*') ? 'text-gray-500' : 'text-blue-100' }}">
                    Statistik & export
                </p>

            </div>

        </a>

    </nav>

</aside>